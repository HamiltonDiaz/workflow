<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TareaFlujoResource\Pages;
use App\Filament\Resources\TareaFlujoResource\RelationManagers;
use App\Models\TareaFlujo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('pasos_flujo_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(45),
                Forms\Components\Textarea::make('descripcion')
                    ->columnSpanFull(),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pasos_flujo_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orden')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('es_final')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('es_editable')
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
            'index' => Pages\ListTareaFlujos::route('/'),
            'create' => Pages\CreateTareaFlujo::route('/create'),
            'view' => Pages\ViewTareaFlujo::route('/{record}'),
            'edit' => Pages\EditTareaFlujo::route('/{record}/edit'),
        ];
    }
}
