<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasoFlujoResource\Pages;
use App\Filament\Resources\PasoFlujoResource\RelationManagers;
use App\Models\PasoFlujo;
use Filament\Forms;
use Filament\Forms\Form;
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
