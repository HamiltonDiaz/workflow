<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstanciaFlujoTrabajoResource\Pages;
use App\Filament\Resources\InstanciaFlujoTrabajoResource\RelationManagers;
use App\Models\InstanciaFlujoTrabajo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstanciaFlujoTrabajoResource extends Resource
{
    protected static ?string $model = InstanciaFlujoTrabajo::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-up';
    protected static ?string $navigationLabel = 'Flujos';
    protected static ?string $modelLabel = 'Flujos';
    protected static ?string $navigationGroup = 'Instancias flujos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('orden')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('es_final')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('flujo_trabajo_id')
                    ->relationship('flujoTrabajo', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('es_final')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('flujoTrabajo.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListInstanciaFlujoTrabajos::route('/'),
            'create' => Pages\CreateInstanciaFlujoTrabajo::route('/create'),
            'view' => Pages\ViewInstanciaFlujoTrabajo::route('/{record}'),
            'edit' => Pages\EditInstanciaFlujoTrabajo::route('/{record}/edit'),
        ];
    }
}
