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
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(45),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('fecha_inicio'),
                Forms\Components\DatePicker::make('fecha_vencimiento'),
                Forms\Components\TextInput::make('orden')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('es_final')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('es_editable')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('instancia_paso_flujo_id')
                    ->relationship('instanciaPasoFlujo', 'id')
                    ->required(),
                Forms\Components\TextInput::make('estado')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('asignado_a')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('asignado_por')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_vencimiento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('es_final')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('es_editable')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('instanciaPasoFlujo.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('asignado_a')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('asignado_por')
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
            'index' => Pages\ListInstanciaTareaFlujos::route('/'),
            'create' => Pages\CreateInstanciaTareaFlujo::route('/create'),
            'view' => Pages\ViewInstanciaTareaFlujo::route('/{record}'),
            'edit' => Pages\EditInstanciaTareaFlujo::route('/{record}/edit'),
        ];
    }
}
