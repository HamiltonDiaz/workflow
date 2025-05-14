<?php

namespace App\Filament\Resources;

use App\Enums\GlobalEnums;
use App\Filament\Resources\TareaFlujoResource\Pages;
use App\Filament\Resources\TareaFlujoResource\RelationManagers;
use App\Models\FlujoTrabajo;
use App\Models\PasoFlujo;
use App\Models\TareaFlujo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class TareaFlujoResource extends Resource
{
    protected static ?string $model = TareaFlujo::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Tareas';
    protected static ?string $modelLabel = 'Tareas';
    protected static ?string $navigationGroup = 'Parámetros flujos';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('flujo_trabajo_id')
                ->label('Flujo de Trabajo')
                ->relationship(
                    name: 'pasoFlujo.flujoTrabajo',
                    titleAttribute: 'nombre'
                )
                ->default(function (?TareaFlujo $record): ?string {
                    return $record?->pasoFlujo?->flujo_trabajo_id;
                })
                ->afterStateHydrated(function (Forms\Components\Select $component, $state, ?TareaFlujo $record, callable $set) {
                    if ($record) {
                        $nuevoEstado = $record->pasoFlujo?->flujo_trabajo_id;
                        $component->state($nuevoEstado);
                        $set('pasos_flujo_id', null);

                    }
                    
                    // Si está vacío el estado después de la hidratación, asegurar que se limpie el campo dependiente
                    if (empty($component->getState())) {
                        $set('pasos_flujo_id', null);
                    }
                })
                ->preload()
                ->live()
                ->afterStateUpdated(function ($get, callable $set) {           
                    $set('pasos_flujo_id', null);
                    $set('pasos_flujo_id', $get('pasos_flujo_id'));
                })
                ->required(),
                Forms\Components\Select::make('pasos_flujo_id')
                    ->relationship(
                        name: 'pasoFlujo',
                        titleAttribute: 'nombre'
                    )
                    ->options(function (Get $get, ?TareaFlujo $record): Collection {
                        $flujoId = $get('flujo_trabajo_id');

                        if (!$flujoId) {
                            return collect();
                        }

                        return PasoFlujo::query()
                            ->where('flujo_trabajo_id', $flujoId)
                            ->pluck('nombre', 'id');
                    })
                    ->live()
                    ->afterStateHydrated(function (Forms\Components\Select $component, $state, callable $get) {
                        // Si no hay flujo de trabajo, nos aseguramos de que este campo esté vacío
                        if (empty($get('flujo_trabajo_id'))) {
                            $component->state(null);
                        }
                    })
                    ->required(),

                Forms\Components\Grid::make()
                    ->columns(12)
                    ->schema([
                        Forms\Components\TextInput::make('titulo')
                            ->required()
                            ->maxLength(45)
                            ->columnSpan(['sm' => 12,'md' => 12, 'xl' => 6]),
                        Forms\Components\Select::make('orden')
                            ->placeholder('Seleccione')
                            ->required()
                            ->options(function (Get $get, ?TareaFlujo $record): array {
                                $pasoId = $get('pasos_flujo_id');
                                
                                if (!$pasoId && $record) {
                                    $pasoId = $record->pasos_flujo_id;
                                }
                                
                                if (!$pasoId) {
                                    return [1];
                                }
                                
                                $ordenActual = $record ? $record->orden : null;
                                $ordenes = TareaFlujo::buscarOrden($pasoId, $ordenActual,'pasos_flujo_id');
                                return array_combine($ordenes, $ordenes);
                            })
                            ->live()
                            ->columnSpan(['sm' => 12,'md' => 12, 'xl' => 2]),
                        Forms\Components\Toggle::make('es_final')                            
                            ->default(0)
                            ->columnSpan(['sm' => 6,'md' => 6, 'xl' => 2]),
                        Forms\Components\Toggle::make('es_editable')
                            ->default(0)
                            ->columnSpan(['sm' => 6,'sm' => 6, 'xl' => 2]),
                    ]),

                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasoFlujo.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('es_final')
                    ->label('Final')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                Tables\Columns\IconColumn::make('es_editable')
                    ->label('Editable')
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
            'index' => Pages\ListTareaFlujos::route('/'),
            'create' => Pages\CreateTareaFlujo::route('/create'),
            //'view' => Pages\ViewTareaFlujo::route('/{record}'),
            'edit' => Pages\EditTareaFlujo::route('/{record}/edit'),
        ];
    }
}
