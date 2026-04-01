<?php

namespace App\Filament\Resources\Pengaduans\Tables;

use App\StatusPengaduan;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                    ->badge(),
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
                Filter::make('tanggal_pengaduan')
                    ->schema([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->recordActions([
                Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(StatusPengaduan::class)
                            ->required(),
                        Textarea::make('feedback')
                            ->label('Feedback')
                            ->required(),
                    ])
                    ->action(function ($record, $data) {
                        $data['user_id'] = auth()->user()->id;
                        $record->update($data);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
