<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstanciaTareaFlujoResource\Pages;
use App\Filament\Resources\InstanciaTareaFlujoResource\RelationManagers;
use App\Models\InstanciaTareaFlujo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstanciaTareaFlujoResource extends Resource
{
    protected static ?string $model = InstanciaTareaFlujo::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Tareas';
    protected static ?string $modelLabel = 'Tareas';
    protected static ?string $navigationGroup = 'Instancias flujos';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('instancia_paso_flujo_id')
                            ->relationship('instanciaPasoFlujo', 'nombre')
                            ->required()
                            ->columnSpan(['sm' => 12, 'md' => 12, 'lg' => 4]),
                        Forms\Components\TextInput::make('titulo')
                            ->required()
                            ->maxLength(45)
                            ->columnSpan(['sm' => 12, 'md' => 12, 'lg' => 8]),
                    ])
                    ->columns(12),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\DatePicker::make('fecha_inicio')
                            ->columnSpan(['sm' => 12, 'md' => 6, 'lg' => 3]),
                        Forms\Components\DatePicker::make('fecha_vencimiento')
                            ->columnSpan(['sm' => 12, 'md' => 6, 'lg' => 3]),
                        Forms\Components\TextInput::make('orden')
                            ->required()
                            ->numeric()
                            ->columnSpan(['sm' => 12, 'md' => 4, 'lg' => 2]),
                        Forms\Components\Toggle::make('es_final')
                            ->inline(false)
                            ->required()
                            ->default(0)
                            ->columnSpan(['sm' => 6, 'md' => 4, 'lg' => 2]),
                        Forms\Components\Toggle::make('es_editable')
                            ->inline(false)
                            ->required()
                            ->default(0)
                            ->columnSpan(['sm' => 6, 'md' => 4, 'lg' => 2]),
                    ])
                    ->columns(12),
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('estado')
                            ->placeholder('Seleccione')
                            ->relationship('estados', 'nombre')
                            ->required()
                            ->columnSpan(['sm' => 6, 'md' => 4, 'lg' => 2]),
                        Forms\Components\Select::make('asignado_a')
                            ->relationship('asignadoA', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(['sm' => 6, 'md' => 4, 'lg' => 5]),
                        Forms\Components\Select::make('asignado_por')
                            ->relationship('asignadoPor', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(['sm' => 6, 'md' => 4, 'lg' => 5]),
                    ])
                    ->columns(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('instanciaPasoFlujo.instanciaFlujoTrabajo.consecutivo')
                    ->label('Id Flujo')
                    ->sortable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('instanciaPasoFlujo.instanciaFlujoTrabajo.nombre')
                    ->label('Nombre flujo')
                    ->limit(20)
                    ->sortable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('estados.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('asignadoA.name')
                    ->label('Responsable')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->date()
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
            RelationManagers\ComentariosRelationManager::class,
            RelationManagers\HistorialRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstanciaTareaFlujos::route('/'),
            'create' => Pages\CreateInstanciaTareaFlujo::route('/create'),
            // 'view' => Pages\ViewInstanciaTareaFlujo::route('/{record}'),
            'edit' => Pages\EditInstanciaTareaFlujo::route('/{record}/edit'),
        ];
    }
}
