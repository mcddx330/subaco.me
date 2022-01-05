<?php

namespace App\Console\Commands;

use App\Models\DiaryArticleModel;
use App\Models\DiaryCategoryModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportExportDiaryFileCommand extends Command {
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'import:diary {filepath : exported file}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Import hatena blog exported file.';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle() {
        $file = file_get_contents($this->argument("filepath"));
        $exploded_raw_contents = explode('--------', $file);
        $exploded_raw_contents = array_reverse($exploded_raw_contents);

        try {
            $default_category_id = DiaryCategoryModel::find(1);
            if (!($default_category_id instanceof DiaryCategoryModel)) {
                $default_category_id = DiaryCategoryModel::create([
                    'name'     => '未設定',
                    'headline' => false,
                ])->id;
            }

            DB::beginTransaction();
            $total_count = count($exploded_raw_contents);
            foreach ($exploded_raw_contents as $i => $raw_content) {
                $raw_content = ltrim($raw_content); // 先頭改行削除

                // ステータス
                preg_match("/STATUS:(.+)/u", $raw_content, $match);
                $current_status = "Draft";
                if (isset($match[1]) && !empty($match[1])) {
                    $current_status = strtolower(trim($match[1]));
                }

                // 投稿日時
                preg_match("/DATE:(.+)/u", $raw_content, $match);
                $published_date = Carbon::createFromTimestamp(0);
                if (isset($match[1])) {
                    preg_match(
                        '/([0-9]{2})\/([0-9]{2})\/([0-9]{4}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/u',
                        $match[1],
                        $match
                    );
                    $published_date = Carbon::create(
                        $match[3],
                        $match[1],
                        $match[2],
                        $match[4],
                        $match[5],
                        $match[6],
                    );
                }

                // カテゴリー
                preg_match("/CATEGORY:(.*)/u", $raw_content, $match);
                $category_id = $default_category_id;
                if (isset($match[1])) {
                    $category_name = trim($match[1]);
                    $category = DiaryCategoryModel::findByName($category_name);
                    if (empty($category)) {
                        $category_id = DiaryCategoryModel::create([
                            'name'     => $category_name,
                            'headline' => (in_array($category_name, ['雑記', '制作'], true)),
                        ])->id;
                    }
                }

                // タイトル
                preg_match("/TITLE:(.+)/u", $raw_content, $match);
                $title = "■";
                if (isset($match[1])) {
                    $trimed = trim($match[1]);
                    if (!empty($trimed)) {
                        $title = $this->optimize_string($trimed);
                    }
                }

                // 本文
                preg_match("/BODY:\n([\s\S]*)\n-----\n/u", $raw_content, $match);
                $body = null;
                if (isset($match[1])) {
                    $body = trim($match[1]);
                }
                if (strlen($body) < 1) {
                    continue;
                }

                // 「続きを読む」文削除
                $body = preg_replace('/-----(|\n)EXTENDED BODY:/u', '', $body);

                $article = DiaryArticleModel::create([
                    'author_id'      => 1,
                    'current_status' => $current_status,
                    'category_id'    => $category_id,
                    'type'           => DiaryArticleModel::TYPE_TEXT,
                    'slug'           => $published_date->timestamp,
                    'title'          => $title,
                    'body'           => $this->parse($body),
                ]);
                $article->created_at = $published_date->toString();
                $article->updated_at = $published_date->toString();
                $article->save();

                $this->info(sprintf('Done: %4d/%4d', $i + 1, $total_count));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error(sprintf('Error: %s', $e->getMessage()));
        }

        return 0;
    }

    private function parse(string $string): string {
        $string = $this->convert_link($string);
        $string = $this->convert_br_to_p($string);
        $string = $this->remove_keyword_link($string);
        $string = $this->optimize_string($string);

        return $string;
    }

    private function convert_link(string $string): string {
        $string = str_replace('http://d.hatena.ne.jp/mcddx30', route('diary.index'), $string);
        if (!strpos($string, route('diary.index'))) {
            return $string;
        }

        preg_match(
            sprintf(
                '/%s\/([0-9]{8})#([0-9]{1,99})/u',
                str_replace('/', '\/', route('diary.index'))
            ),
            $string,
            $match
        );
        if (!isset($match[1]) || empty($match[1])) {
            return $string;
        }

        $new_link = route('diary.show_article', ['ymd' => $match[1], 'slug' => $match[2]]);
        $string = str_replace($match[0], $new_link, $string);

        return $string;
    }

    private function convert_br_to_p(string $string): string {
        preg_match('/(<br>|<br \/>)/u', $string, $match);
        if (!isset($match[1]) || empty($match[1])) {
            return $string;
        }


        $base_slice = explode($match[1], $string);
        $new_string = '';
        foreach ($base_slice as $i => $slice) {
            $slice = preg_replace('/(<p>|<\/p>)/u', '', $slice);
            $new_string .= sprintf("<p>%s</p>", str_replace("\n", '', $slice));
            if ($i < count($base_slice) - 1) {
                $new_string .= "\n";
            }
        }

        return $new_string;
    }

    private function remove_keyword_link(string $string): string {
        preg_match_all(
            '/<a.+d.hatena.ne.jp\/keyword\/.+">(.+)<\/a>/u',
            str_replace('</a>', "</a>\n", $string),
            $match
        );

        foreach ($match[0] as $i => $base_string) {
            if (!isset($match[1][$i]) || empty($match[1][$i])) {
                continue;
            }
            $string = str_replace($base_string, $match[1][$i], $string);
        }

        return $string;
    }

    private function optimize_string(string $string): string {
        $string = $this->remove_empty_tags_p($string);
        $string = $this->remove_li_wrapped_p($string);


        $string = $this->restore_html_entities($string);

        return $string;
    }

    private function remove_empty_tags_p(string $string): string {
        return str_replace('<p></p>', '', $string);
    }

    private function remove_li_wrapped_p(string $string): string {
        preg_match('/<p><ul><li>(|.+)<\/li><\/ul>(|.+)<\/p>/u', $string, $match);
        if (!isset($match[1])) {
            return $string;
        }

        return str_replace(
            $match[0],
            sprintf(
                "<ul><li>%s</li></ul><p>%s</p>",
                $match[1],
                $match[2]
            ),
            $string
        );
    }

    private function restore_html_entities(string $string): string {
        $string = str_replace('&quot;', '"', $string);
        $string = str_replace('&amp;', '&', $string);
        $string = str_replace('&#039;', "'", $string);
        $string = str_replace('&lt;', '<', $string);
        $string = str_replace('&gt;', '>', $string);

        return $string;
    }
}
