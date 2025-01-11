<?php

namespace App\Enum;

enum ContactType: string
{
    case G = '一般';
    case MBR = 'MAPLE BLUE RECORDS';
//    case MBS = 'THE MAPLE BLUE SHOW';

    public function label(): string
    {
        return match($this) {
            self::G => self::G->value,
            self::MBR => self::MBR->value,
//            self::MBS => self::MBS->value,
        };
    }

    public static function all(): array
    {
        return array_map(
            fn($case) => $case->value,
            self::cases()
        );
    }
}
