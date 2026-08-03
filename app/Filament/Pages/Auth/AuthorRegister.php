<?php

namespace App\Filament\Pages\Auth;

use App\Models\Author;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthorRegister extends BaseRegister
{
    /**
     * Override form: tambahkan field username, avatar, bio
     * di samping field bawaan Filament (name, email, password, password confirmation).
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),

                TextInput::make('username')
                    ->required()
                    ->unique(table: 'authors', column: 'username')
                    ->maxLength(255),

                $this->getEmailFormComponent(),

                FileUpload::make('avatar')
                    ->image()
                    ->directory('authors/avatars')
                    ->imageEditor()
                    ->avatar(),

                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),

                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ])
            ->statePath('data');
    }

    /**
     * Override proses registrasi: buat User (role = author)
     * sekaligus buat record Author terkait, dalam satu transaksi.
     */
    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $user = $this->getUserModel()::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'author',
            ]);

            Author::create([
                'user_id' => $user->id,
                'username' => $data['username'],
                'avatar' => $data['avatar'] ?? null,
                'bio' => $data['bio'] ?? null,
            ]);

            return $user;
        });
    }
}
