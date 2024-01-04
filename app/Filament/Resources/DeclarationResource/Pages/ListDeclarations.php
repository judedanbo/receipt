<?php

namespace App\Filament\Resources\DeclarationResource\Pages;

use App\Filament\Resources\DeclarationResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListDeclarations extends ListRecords
{
    protected static string $resource = DeclarationResource::class;

    public function getTabs(): array{
        return [
            'all' => Tab::make('All Declarations'),
            'synced' => Tab::make('Synced')
                ->modifyQueryUsing(function($query){
                    return $query->where('synced', true);
                }),
            'local' => Tab::make('Local')
                ->modifyQueryUsing(function($query){
                    return $query->where('synced', false);
                }),
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
