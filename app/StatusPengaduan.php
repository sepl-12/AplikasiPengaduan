<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusPengaduan: string implements HasLabel, HasColor, HasIcon
{
    case MENUNGGU = 'menunggu';
    case PROSES = 'proses';
    case SELESAI = 'selesai';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::PROSES => 'Proses',
            self::SELESAI => 'Selesai',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MENUNGGU => 'warning',
            self::PROSES => 'info',
            self::SELESAI => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MENUNGGU => 'heroicon-o-clock',
            self::PROSES => 'heroicon-o-clock',
            self::SELESAI => 'heroicon-o-check-circle',
        };
    }
}
