<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoListaElementoResource\Pages;
use App\Filament\Resources\TipoListaElementoResource\RelationManagers;
use App\Models\TipoListaElemento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoListaElementoResource extends Resource
{
    protected static ?string $model = TipoListaElemento::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $navigationGroup = 'Parámetros';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->formatStateUsing(fn ($state) => mb_strtoupper($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->formatStateUsing(fn ($state) => mb_strtoupper($state))
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->label('')
                ->tooltip('Ver'),
                Tables\Actions\EditAction::make()
                ->label('')
                ->tooltip('Editar'),
                Tables\Actions\DeleteAction::make()
                ->tooltip('Eliminar')
                ->label(''),
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
            'index' => Pages\ListTipoListaElementos::route('/'),
            'create' => Pages\CreateTipoListaElemento::route('/create'),
            'view' => Pages\ViewTipoListaElemento::route('/{record}'),
            'edit' => Pages\EditTipoListaElemento::route('/{record}/edit'),
        ];
    }
}
