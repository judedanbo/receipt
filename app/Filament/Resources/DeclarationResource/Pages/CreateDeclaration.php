<?php

namespace App\Filament\Resources\DeclarationResource\Pages;

use App\Filament\Resources\DeclarationResource;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Resources\Pages\CreateRecord;

class CreateDeclaration extends CreateRecord
{
    protected static string $resource = DeclarationResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['receipt_no'] = Str::random(10);
        $data['qr_code'] = Str::random(10);
        $data['synced'] = false;
        $data['staff_id'] = 1;
        $data['user_id'] = auth()->id();
    
        return $data;
    }
    protected function afterCreate(): void
    {
        // TODO send data to server
    }
}
