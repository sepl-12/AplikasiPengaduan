<?php

namespace App\Filament\Resources\Pengaduans\Tables;

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
                TextColumn::make('siswa.nama_siswa')
                    ->numeric()
                    ->label('Nama Siswa')
                    ->sortable(),
                TextColumn::make('kategori.nama_kategori')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lokasi')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(StatusPengaduan::class),
                TextColumn::make('feedback')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->sortable()
                    ->label('Admin'),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
