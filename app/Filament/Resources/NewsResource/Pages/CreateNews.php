<?php

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jaga-jaga: pastikan author yang login tidak bisa membuat berita atas nama author lain
        $user = auth()->user();

        if ($user?->isAuthor()) {
            $data['author_id'] = $user->author?->id;
        }

        return $data;
    }
}
