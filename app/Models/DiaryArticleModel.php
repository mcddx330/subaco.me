<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DiaryArticleModel extends Model {
    use HasFactory, SoftDeletes;

    const STATUS_DRAFT   = 'draft';
    const STATUS_PUBLISH = 'publish';
    const TYPE_TEXT      = 'text';
    const TYPE_MARKDOWN  = 'markdown';

    const CURRENT_STATUSES = [
        'draft'   => '下書き',
        'publish' => '公開',
    ];

    protected $table = 'diary_article';

    protected $fillable = [
        'author_id',
        'current_status',
        'category_id',
        'type',
        'slug',
        'title',
        'body',
        'thumbnail_filename',
    ];

    protected $casts = [
        'author_id' => 'int',
    ];

    public function category() {
        return $this->hasOne(DiaryCategoryModel::class, 'id', 'category_id');
    }


    public function getYearAttribute() {
        return Carbon::createFromTimestamp(strtotime($this->created_at))->year;
    }

    public function getMonthAttribute() {
        return Carbon::createFromTimestamp(strtotime($this->created_at))->month;
    }

    public function getDayAttribute() {
        return Carbon::createFromTimestamp(strtotime($this->created_at))->day;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeDesc(Builder $builder): Builder {
        return $builder->orderByDesc('id');
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeAsc(Builder $builder): Builder {
        return $builder->orderBy('id', 'ASC');
    }

    public function scopeOnlyPublished(Builder $builder): Builder {
        return $builder->where('current_status', '=', self::STATUS_PUBLISH);
    }

    public function scopeUris(Builder $builder, int $year, int $month, int $day, string $slug): Builder {
        $builder->where('created_at', '>=', Carbon::createFromDate($year, $month, $day)->format('Y-m-d 00:00:00'));
        if (!empty($slug)) {
            $builder->where('slug', '=', $slug);
        }

        return $builder;
    }

    public static function getByDesc() {
        return (new self())
            ->with(['category'])
            ->desc()
            ->get();
    }

    public static function getLatests() {
        return (new self())
            ->with(['category'])
            ->onlyPublished()
            ->desc()
            ->limit(20)
            ->get();
    }

    public static function getCalendars() {
        $model = (new self())
            ->onlyPublished()
            ->orderBy('date', 'DESC')
        ;

        $driver = DB::connection()->getConfig()['driver'];
        switch (true) {
            case ($driver === 'sqlite'):
                $model
                    ->select(DB::raw("STRFTIME(' %Y', created_at) AS `date`, COUNT(*) AS count"))
                    ->groupBy(DB::raw("STRFTIME(' %Y', created_at)"))
                ;
                break;
            default:
                $model
                    ->select(DB::raw("DATE_FORMAT(created_at, ' %Y') AS `date`, COUNT(*) AS count"))
                    ->groupBy(DB::raw("DATE_FORMAT(created_at, ' %Y')"))
                ;
                break;
        }

        return $model;
    }

    public static function getArticleByURIParts(int $ymd, string $slug) {
        $year = $month = $day = 0;

        preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})/u', $ymd, $match);
        if (isset($match[1])) {
            $year = $match[1];
        }
        if (isset($match[2])) {
            $year = $match[2];
        }
        if (isset($match[3])) {
            $year = $match[3];
        }

        return (new self())
            ->uris($year, $month, $day, $slug)
            ->asc()
            ->first();
    }
}
