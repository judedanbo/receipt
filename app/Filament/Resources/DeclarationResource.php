<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeclarationResource\Pages;
use App\Filament\Resources\DeclarationResource\RelationManagers;
use App\Models\Declaration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeclarationResource extends Resource
{
    protected static ?string $model = Declaration::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Declaration::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receipt_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('declared_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('post')
                    ->searchable(),
                Tables\Columns\TextColumn::make('schedule')
                    ->searchable(),
                Tables\Columns\TextColumn::make('office_location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('witness')
                    ->searchable(),
                Tables\Columns\TextColumn::make('witness_occupation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_by_contact')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qr_code')
                    ->searchable(),
                Tables\Columns\IconColumn::make('synced')
                    ->boolean(),
                Tables\Columns\TextColumn::make('office.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('old_received_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('old_serial_no')
                    ->searchable(),
                Tables\Columns\TextColumn::make('old_declaration_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('staff.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeclarations::route('/'),
            'create' => Pages\CreateDeclaration::route('/create'),
            'edit' => Pages\EditDeclaration::route('/{record}/edit'),
        ];
    }
}
