<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeclarationResource\Pages;
use App\Filament\Resources\DeclarationResource\RelationManagers;
use App\Models\Declaration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification; 
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DeclarationResource extends Resource
{
    protected static ?string $model = Declaration::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Declaration::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->filtersTriggerAction(function($action){
                return $action->button()->label('Filters');
            })
            ->columns([
                Tables\Columns\TextColumn::make('receipt_no')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('declared_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->description(function(Declaration $declaration) {
                        return Str::of($declaration->post. ' (' . $declaration->office_location .") / " . $declaration->schedule);
                    })
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('post')
                //     ->wrap()
                //     ->sortable()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('schedule')
                //     ->wrap()
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('office_location')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('witness')
                    ->description(function (Declaration $declaration) {
                        return $declaration->witness_occupation;
                    })
                    ->wrap()
                    ->searchable()
                    ->toggleable(),
                // Tables\Columns\TextColumn::make('witness_occupation')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('submitted_by')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('submitted_by_contact')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('qr_code')
                    ->searchable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('synced')
                    ->boolean(),
                Tables\Columns\TextColumn::make('office.name')
                    ->sortable()
                    ->searchable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('old_received_by')
                    ->searchable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('old_serial_no')
                    ->searchable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('old_declaration_id')
                    ->searchable()
                     ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('staff.title')
                    ->numeric()
                    ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('synced'),
                SelectFilter::make('post')
                    ->options(Declaration::all()->unique()->pluck('post', 'id'))
                    ->attribute('id')
                    ->searchable()
                    ->preload(),

                // ::make('synced'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('sync')
                        ->visible(function(Declaration $declaration){
                            return ! $declaration->synced;
                        })
                        ->icon('heroicon-o-arrow-path')
                        ->action(function(Declaration $declaration) {
                            $declaration->sync();
                        })->after(function (Declaration $declaration) {
                            if ($declaration->sync()){
                                Notification::make()
                                    ->success()
                                    ->title('The Declaration has been synced')
                                    ->body('This declaration has been synced successfully.')
                                    ->send();
                            } 
                            else{
                                Notification::make()
                                    ->danger()
                                    ->title('The Declaration failed     synced')
                                    ->body('This declaration could not be synced at this time. Please try again later.')
                                    ->send();
                            }
                        }),
                        Tables\Actions\Action::make('view receipt')
                            ->action(function(Declaration $declaration){
                                redirect()->route('filament.receipt.resources.declarations.receipt', ['receipt' => $declaration->id]);
                            })
                            ->icon('heroicon-o-receipt-refund')
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                     Tables\Actions\BulkAction::make('Sync All')
                     ->action(function(Collection $declarations) {
                        $declarations->each->sync();
                     }),
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Export to excel')
                        ->icon('heroicon-o-document-text')
                        ->tooltip(function($livewire){
                            return "This will export {$livewire->getFilteredTableQuery()->count()} record on the table now. you may adjust filter to export more/fewer Declarations";
                        })
                        ->action(function($livewire){
                            return $livewire->getFilteredTableQuery()->count();
                        }),
                        Tables\Actions\Action::make('Export to pdf')
                        ->icon('heroicon-o-document')
                        ->tooltip(function($livewire){
                            return "This will export {$livewire->getFilteredTableQuery()->count()} record on the table now. you may adjust filter to export more/fewer Declarations";
                        })
                        ->action(function($livewire){
                            return $livewire->getFilteredTableQuery()->count();
                        }),
                ])
                ->label("Export")
                ->button()
                ->icon('heroicon-o-document-arrow-down'),
            ])
            ;
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Declarant Information')
                    ->columns(3)
                    ->schema([
                        Group::make()
                            ->schema([
                                TextEntry::make('declared_date')
                                    ->date('d F Y'),
                                // TextEntry::make('synced'),
                                TextEntry::make('receipt_no'),
                                TextEntry::make('qr_code'),
                            ]),
                        Group::make()
                            ->columnSpan(2)
                            ->columns(3)
                            ->schema([
                                TextEntry::make('office.name'),
                                TextEntry::make('staff.full_name'),
                                TextEntry::make('user.name'),
                            ]),
                    ]),
                Section::make('Declarant Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('post'),
                        TextEntry::make('schedule'),
                        TextEntry::make('office_location'),
                        TextEntry::make('address'),
                        TextEntry::make('contact'),
                    ]),
                Section::make('Declarant Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('witness'),
                        TextEntry::make('witness_occupation'),
                    ]),
                    Section::make('Declarant Information')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('submitted_by'),
                        TextEntry::make('submitted_by_contact'),
                    ]),
                        
                    
            ]); 
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OfficeRelationManager::class,
            RelationManagers\StaffRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeclarations::route('/'),
            'create' => Pages\CreateDeclaration::route('/create'),
            'view' => Pages\ViewDeclaration::route('/{record}'),
            'receipt' => Pages\ViewDeclaration::route('/receipt/{receipt}'),
            // 'edit' => Pages\EditDeclaration::route('/{record}/edit'),
        ];
    }
}
