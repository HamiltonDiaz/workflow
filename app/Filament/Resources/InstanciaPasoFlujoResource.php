<?php

namespace App\Filament\Resources;

use App\Enums\GlobalEnums;
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
    protected static ?string $modelLabel = 'Instancia pasos';
    protected static ?string $navigationGroup = 'Instancias flujos';
    protected static ?int $navigationSort = 2;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('instancia_flujo_trabajo_id')
                    ->relationship('instanciaFlujoTrabajo', 'nombre')
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\Grid::make()
                    ->columns(12)
                    ->schema([
                        Forms\Components\Select::make('orden')
                            ->required()
                            ->options(function (Forms\Get $get, $record) {
                                $flujoId = $get('instancia_flujo_trabajo_id');
                                if (!$flujoId) {
                                    return [1];
                                }
                                $ordenActual = $record ? $record->orden : null;
                                $ordenes = InstanciaPasoFlujo::buscarOrden($flujoId, $ordenActual, 'instancia_flujo_trabajo_id');
                                return array_combine($ordenes, $ordenes);
                            })
                            ->live()
                            ->afterStateUpdated(fn(Forms\Set $set) => $set('orden', fn($state) => $state))
                            ->columnSpan(['xs' => 12,'md' => 12, 'xl' => 4]),
                        Forms\Components\Select::make('estado')
                            ->label('Estado')
                            ->relationship('listaElementos', 'nombre')
                            ->required()
                            ->columnSpan(['xs' => 12,'md' => 12, 'xl' => 4]),
                        Forms\Components\Toggle::make('es_final')
                            ->required()
                            ->default(0)
                            ->columnSpan(['xs' => 12,'md' => 12, 'xl' => 4]),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('id', '!=', GlobalEnums::INSTANCIA_PASO_GENERAL->value());
            })
            ->columns([
                Tables\Columns\TextColumn::make('instanciaFlujoTrabajo.consecutivo')
                ->label('Id flujo')
                ->sortable()
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('instanciaFlujoTrabajo.nombre')
                    ->label('Nombre flujo')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('estado')
                    ->icons([
                        'heroicon-o-arrow-right-circle' => GlobalEnums::ACTIVO_INSTANCIA_PASO->value(), // Activo
                        'heroicon-o-pause-circle' => GlobalEnums::PAUSA_INSTANCIA_PASO->value(), // Pausado
                        'heroicon-o-check-circle' => GlobalEnums::COMPLETO_INSTANCIA_PASO->value(), // Completo
                    ])
                    ->colors([
                        'success' => GlobalEnums::COMPLETO_INSTANCIA_PASO->value(), // Verde para completo
                        'gray' => GlobalEnums::PAUSA_INSTANCIA_PASO->value(), // Amarillo para pausado
                        'info' => GlobalEnums::ACTIVO_INSTANCIA_PASO->value(), // Azul para activo
                    ])
                    ->tooltip(fn(int $state): string => match ($state) {
                        GlobalEnums::ACTIVO_INSTANCIA_PASO->value() => 'Activo',
                        GlobalEnums::PAUSA_INSTANCIA_PASO->value() => 'Pausado',
                        GlobalEnums::COMPLETO_INSTANCIA_PASO->value() => 'Completo',
                        default => 'Desconocido',
                    })
                    ->sortable(),
                Tables\Columns\IconColumn::make('es_final')
                    ->label('Es Final')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->sortable(),
                Tables\Columns\TextColumn::make('consecutivo')
                    ->searchable()
                    ->sortable(),
          
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
            // 'view' => Pages\ViewInstanciaPasoFlujo::route('/{record}'),
            'edit' => Pages\EditInstanciaPasoFlujo::route('/{record}/edit'),
        ];
    }
}
