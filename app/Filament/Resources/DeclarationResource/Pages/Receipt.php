<?php

namespace App\Filament\Resources\DeclarationResource\Pages;

use App\Filament\Resources\DeclarationResource;
use Filament\Resources\Pages\Page;

class Receipt extends Page
{
    protected static string $resource = DeclarationResource::class;

    protected static string $view = 'filament.resources.declaration-resource.pages.receipt';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }
}
