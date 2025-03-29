<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstanciaPasoFlujoResource\Pages;
use App\Filament\Resources\InstanciaPasoFlujoResource\RelationManagers;
use App\Models\InstanciaPasoFlujo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstanciaPasoFlujoResource extends Resource
{
    protected static ?string $model = InstanciaPasoFlujo::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Pasos';
    protected static ?string $modelLabel = 'Paso';
    protected static ?string $navigationGroup = 'Instancias flujos';
    protected static ?int $navigationSort = 2;

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
                Forms\Components\Select::make('instancia_flujo_trabajo_id')
                    ->relationship('instanciaFlujoTrabajo', 'id')
                    ->required(),
                Forms\Components\TextInput::make('estado')
                    ->required()
                    ->numeric(),
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
                Tables\Columns\TextColumn::make('instanciaFlujoTrabajo.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
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
            'index' => Pages\ListInstanciaPasoFlujos::route('/'),
            'create' => Pages\CreateInstanciaPasoFlujo::route('/create'),
            'view' => Pages\ViewInstanciaPasoFlujo::route('/{record}'),
            'edit' => Pages\EditInstanciaPasoFlujo::route('/{record}/edit'),
        ];
    }
}
