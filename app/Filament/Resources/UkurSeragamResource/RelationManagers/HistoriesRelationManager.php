<?php

namespace App\Filament\Resources\UkurSeragamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'histories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ukuran_seragam_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ukuran_seragam_id')
            ->columns([
                Tables\Columns\TextColumn::make('jenis_ukuran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('size_pdu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lebar_bahu_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_belakang_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_depan_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_dada_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_pinggang_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_bawah_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_baju_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_tangan_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_tangan_atas_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_tangan_bawah_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_ukuran_kemeja'),
                Tables\Columns\TextColumn::make('size_kemeja')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lebar_bahu_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_belakang_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_depan_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_dada_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_pinggang_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_bawah_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_baju_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_tangan_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_tangan_atas_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_tangan_bawah_kemeja')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_ukuran_celana_pdu'),
                Tables\Columns\TextColumn::make('size_celana_pdu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lebar_pinggang_celana_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_pinggul_celana_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_paha_celana_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_lutut_celana_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_bawah_celana_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kress_celana_pdu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_celana_celana_pdu')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
