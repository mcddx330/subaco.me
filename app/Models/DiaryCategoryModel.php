<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiaryCategoryModel extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'diary_category';

    protected $fillable = [
        'name',
        'headline',
    ];

    /**
     * @param string $name
     *
     * @return Builder
     */
    public function scopeName(Builder $builder, string $name): Builder {
        return $builder->where('name', '=', $name);
    }

    public function scopeActiveHeadline(Builder $builder): Builder {
        return $builder
            ->where('headline', '=', true);
    }

    /**
     * @param string $name
     *
     * @return static|null
     */
    public static function findByName(string $name): ?self {
        return (new self())
            ->name($name)
            ->first();
    }

    public static function getHeadlineCategories() {
        return (new self())
            ->activeHeadline()
            ->get();
    }
}
