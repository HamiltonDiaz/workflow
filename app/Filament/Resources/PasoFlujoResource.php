<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasoFlujoResource\Pages;
use App\Filament\Resources\PasoFlujoResource\RelationManagers;
use App\Models\PasoFlujo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PasoFlujoResource extends Resource
{
    protected static ?string $model = PasoFlujo::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Pasos';
    protected static ?string $modelLabel = 'Paso';
    protected static ?string $navigationGroup = 'Parámetros flujos';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('flujo_trabajo_id')
                    ->relationship('flujoTrabajo', 'nombre')
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\Select::make('orden')
                    ->required()
                    ->options(function (Forms\Get $get, $record) {
                        $flujoId = $get('flujo_trabajo_id');
                        if (!$flujoId) {
                            return [1];
                        }
                        $ordenActual = $record ? $record->orden : null;
                        $ordenes = PasoFlujo::buscarOrden($flujoId, $ordenActual);
                        return array_combine($ordenes, $ordenes);
                    })
                    ->live()
                    ->afterStateUpdated(fn(Forms\Set $set) => $set('orden', fn($state) => $state)),
                Forms\Components\Toggle::make('es_final')
                    ->required()
                    ->default(0),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('flujoTrabajo.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('es_final')
                    ->label('Es Final')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
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
            'index' => Pages\ListPasoFlujos::route('/'),
            'create' => Pages\CreatePasoFlujo::route('/create'),
            'view' => Pages\ViewPasoFlujo::route('/{record}'),
            'edit' => Pages\EditPasoFlujo::route('/{record}/edit'),
        ];
    }
}
