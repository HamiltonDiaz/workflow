<?php

namespace App\Filament\Resources;

use App\Enums\PermissionActionEnum;
use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'Permisos';
    protected static ?string $modelLabel = 'Permisos';
    protected static ?string $navigationGroup = 'Parámetros';
    protected static ?int $navigationSort = 2;


    // Definir los modelos que serán excluidos de la lista
    protected static array $excludedModels = [
        'PersonalAccessToken',
        'PasswordResetToken',
        'Media',
        'Audit',
        'Setting',
        'Migration',
        'Job',
        'FailedJob',
    ];


    public static function form(Form $form): Form
    {

        // Obtener modelos de la aplicación excluyendo los no deseados
        $modelOptions = self::getAvailableModels();

        $actionOptions =PermissionActionEnum::asSelectArray();

        return $form
            ->schema([
                Select::make('modelo')
                    ->label('Modelo')
                    ->options($modelOptions)
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, \Filament\Forms\Get $get) {
                        $modelo = $get('modelo');
                        $accion = $get('accion');
                        if ($modelo && $accion && $accion !== 'custom') {
                            $set('name', "$modelo.$accion");
                        }
                    }),

                Select::make('accion')
                    ->label('Acción')
                    ->options($actionOptions)
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, \Filament\Forms\Get $get) {
                        $modelo = $get('modelo');
                        $accion = $get('accion');
                        if ($modelo && $accion && $accion !== 'custom') {
                            $set('name', "$modelo.$accion");
                        }
                    }),

                TextInput::make('name')
                    ->label('Nombre del permiso')
                    ->helperText('Este será el nombre del permiso registrado')
                    ->required()
                    ->disabled()
                    ->dehydrated(true)
                    ->live(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->label('Roles asignados'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('modelo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('accion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guard_name')
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            //'view' => Pages\ViewPermission::route('/{record}'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    /**
     * Obtiene la lista de modelos disponibles para permisos
     */
    protected static function getAvailableModels(): array
    {
        $modelOptions = [];
        $modelFiles = glob(app_path('Models') . '/*.php');

        foreach ($modelFiles as $file) {
            $modelName = pathinfo($file, PATHINFO_FILENAME);

            // Excluir modelos de la lista
            if (!in_array($modelName, static::$excludedModels)) {
                $modelNameLower = Str::lower($modelName);
                $modelOptions[$modelNameLower] = $modelName;
            }
        }

        return $modelOptions;
    }
}
