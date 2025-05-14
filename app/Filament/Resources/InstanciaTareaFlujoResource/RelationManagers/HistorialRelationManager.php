<?php

namespace App\Filament\Resources\InstanciaTareaFlujoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistorialRelationManager extends RelationManager
{
    protected static string $relationship = 'historial';


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('descripcion')
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(80)
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detalle cambio')
                    ->form([
                        Forms\Components\Textarea::make('descripcion')
                            ->label('')
                            ->formatStateUsing(function ($record) {
                                return $record->descripcion;
                            })
                            ->helperText(fn ($record): string => $record->user->name . ' - ' . $record->created_at->format('d/m/Y H:i'))
                            ->columnSpanFull()
                            ->disabled()
                            ->rows(5)
                            ->autosize(),
                    ])
            ])
            ->reorderable(false)
            ->poll();
    }

    protected function refreshTable(): void
    {
        $this->resetTable();
    }
}
