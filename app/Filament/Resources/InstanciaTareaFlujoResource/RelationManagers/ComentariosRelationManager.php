<?php

namespace App\Filament\Resources\InstanciaTareaFlujoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class ComentariosRelationManager extends RelationManager
{
    protected static string $relationship = 'comentarios';
    protected static ?string $title = 'Comentarios';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('descripcion')
                    ->label('Comentario')
                    ->placeholder('Escribe un comentario...')
                    ->maxLength(800)
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'link',
                        'orderedList',
                        'unorderedList',
                    ])
                      ->extraAttributes([
                    'x-on:keydown.enter.prevent' => '',
                    'style' => 'min-height: 100px;'
                ])
                    ->live()
                    ->helperText(fn ($state): string => 'Caracteres restantes: ' . (800 - strlen(strip_tags($state ?? ''))))
                    ->validationMessages([
                        'required' => 'Campo requerido.',
                        'max' => 'El comentario no puede superar los 800 caracteres.',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('descripcion')
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Comentario')
                    ->html()
                    ->searchable()
                    ->description(fn ($record): string => $record->user->name . ' - ' . $record->created_at->format('d/m/Y H:i:s'))
                    ->wrap(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
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
          ;
    }
}
