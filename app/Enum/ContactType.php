<?php

namespace App\Enum;

enum ContactType: string
{
    case G = '一般';
    case MB = 'MAPLE BLUE RECORDS';

    public function label(): string
    {
        return match($this) {
            self::G => self::G->value,
            self::MB => self::MB->value,
        };
    }

    /**
     * すべての列挙値を返却するメソッド
     */
    public static function all(): array
    {
        return array_map(
            fn($case) => $case->value,
            self::cases()
        );
    }
}
