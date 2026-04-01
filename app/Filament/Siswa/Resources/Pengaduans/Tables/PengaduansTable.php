<?php

namespace App\Filament\Siswa\Resources\Pengaduans\Tables;

use App\StatusPengaduan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PengaduansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_pengaduan')
                    ->date()
                    ->sortable(),
                TextColumn::make('kategori.nama_kategori')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lokasi')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('feedback')
                    ->label('Feedback')
                    ->placeholder('Menunggu balasan'),
                TextColumn::make('user.name')
                    ->label('Admin yang Menangani')
                    ->placeholder('Menunggu balasan'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->disabled(fn($record) => $record->status !== StatusPengaduan::MENUNGGU),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
