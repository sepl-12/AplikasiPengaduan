<?php

namespace App\Filament\Siswa\Pages;

use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;

class LoginSiswa extends Login
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getNisFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent()
        ]);
    }

    protected function getNisFormComponent()
    {
        return TextInput::make('nis')
            ->label('NIS (Nomor Induk Siswa)')
            ->required()
            ->autocomplete('nis')
            ->autofocus()
            ->placeholder('Masukkan NIS Anda, contoh: 2023001')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'nis'      => $data['nis'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
