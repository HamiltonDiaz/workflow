<?php

namespace App\Filament\Resources;

use App\Enums\GlobalEnums;
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
    protected static ?string $modelLabel = 'Instancia flujos';
    protected static ?string $navigationGroup = 'Instancias flujos';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('flujo_trabajo_id')
                    ->relationship('flujoTrabajo', 'nombre')
                    ->live()
                    ->required()
                    ->disabled(fn ($context) => $context === 'edit')
                    ->dehydrated(true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {//$state: Contiene el valor seleccionado (ID del flujo de trabajo)
                            $flujoTrabajo = \App\Models\FlujoTrabajo::find($state);
                            if ($flujoTrabajo) {
                                $set('nombre', $flujoTrabajo->nombre);
                                $set('descripcion', $flujoTrabajo->descripcion);
                            }
                        } else {
                            // Si no hay valor seleccionado (deselección)
                            // Limpia los campos
                            $set('nombre', '');
                            $set('descripcion', '');
                        }
                    }),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->live()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->live()
                    ->columnSpanFull(),                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('id', '!=', GlobalEnums::INSTANCIA_FLUJO_GENERAL->value());
            })
            ->columns([
                Tables\Columns\TextColumn::make('flujoTrabajo.nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('consecutivo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->sortable()
                    ->limit(40)
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
            ]) 
            ->recordUrl(null)//Esto es para evitar que se genere el link editar
            ->recordAction(null);//Esto suprime las acciones de la tabla al dar clic en la fila
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
            // 'view' => Pages\ViewInstanciaFlujoTrabajo::route('/{record}'),
            'edit' => Pages\EditInstanciaFlujoTrabajo::route('/{record}/edit'),
        ];
    }
}
