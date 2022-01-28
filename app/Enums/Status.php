<?php

namespace App\Enums;

enum Status : int
{
    case PROCESSING = 1;
    case SHIPPED = 2;
    case DELIVERED = 3;
    case CANCELLED = 4;

    public function getName() : string
    {
        return match ($this) {
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
            default => 'Status Not Found',
        };
    }

    public function getStyles() : string
    {
        return match ($this) {
            self::PROCESSING => 'bg-yellow-200 text-yellow-800',
            self::SHIPPED => 'bg-purple-200 text-purple-800',
            self::DELIVERED => 'bg-green-200 text-green-800',
            self::CANCELLED => 'bg-red-200 text-red-800',
            default => '',
        };
    }
}
