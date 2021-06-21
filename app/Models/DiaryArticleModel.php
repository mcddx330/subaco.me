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
            ->desc()
            ->onlyPublished()
            ->limit(20)
            ->get();
    }

    public static function getCalendars() {
        return (new self())
            ->select(DB::raw("DATE_FORMAT(created_at, ' %Y') AS `date`, COUNT(*) AS count"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, ' %Y')"))
            ->orderBy('date', 'DESC')
            ->get();
    }

    public static function getArticleByURIParts(int $year, int $month, int $day, string $slug) {
        return (new self())
            ->uris($year, $month, $day, $slug)
            ->asc()
            ->first();
    }
}
