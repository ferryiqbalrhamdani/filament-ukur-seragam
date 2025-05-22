<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UkurSeragamResource\Pages;
use App\Filament\Resources\UkurSeragamResource\RelationManagers;
use App\Models\UkurSeragam;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UkurSeragamResource extends Resource
{
    protected static ?string $model = UkurSeragam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'ukur-seragam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Informasi Umum')
                        ->schema([
                             Forms\Components\TextInput::make('personel_id')
                                ->required()
                                ->numeric(),
                            Forms\Components\TextInput::make('jenis_ukuran')
                                ->maxLength(255),
                        ]),
                    Wizard\Step::make('Delivery')
                        ->schema([
                            // ...
                        ]),
                    Wizard\Step::make('Billing')
                        ->schema([
                            // ...
                        ]),
                ]),
               
                Forms\Components\TextInput::make('size_pdu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('lebar_bahu_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_belakang_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_depan_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_dada_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_pinggang_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_bawah_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_baju_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_tangan_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lingkar_tangan_atas_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lingkar_tangan_bawah_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('size_kemeja')
                    ->maxLength(100),
                Forms\Components\TextInput::make('lebar_bahu_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_belakang_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_depan_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_dada_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_pinggang_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_bawah_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_baju_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_tangan_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lingkar_tangan_atas_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('lingkar_tangan_bawah_kemeja')
                    ->numeric(),
                Forms\Components\TextInput::make('size_celana_pdu')
                    ->maxLength(100),
                Forms\Components\TextInput::make('lebar_pinggang_celana_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_pinggul_celana_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_paha_celana_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_lutut_celana_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_bawah_celana_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('kress_celana_pdu')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_celana_celana_pdu')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('personel_id')
                    ->numeric()
                    ->sortable(),
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
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUkurSeragams::route('/'),
            'create' => Pages\CreateUkurSeragam::route('/create'),
            'edit' => Pages\EditUkurSeragam::route('/{record}/edit'),
        ];
    }

      public static function getNavigationLabel(): string
    {
        return 'Ukur Seragam';
    }

    public static function getModelLabel(): string
    {
        return 'Ukur Seragam';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Ukur Seragam';
    }
}
