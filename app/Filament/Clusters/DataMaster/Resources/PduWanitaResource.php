<?php

namespace App\Filament\Clusters\DataMaster\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PduWanita;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\DataMaster;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use App\Filament\Clusters\DataMaster\Resources\PduWanitaResource\Pages;
use App\Filament\Clusters\DataMaster\Resources\PduWanitaResource\RelationManagers;

class PduWanitaResource extends Resource
{
    protected static ?string $model = PduWanita::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = DataMaster::class;

    protected static ?string $slug = 'pdu-wanita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('size')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('lebar_bahu')
                            ->numeric(),
                        Forms\Components\TextInput::make('lebar_belakang')
                            ->numeric(),
                        Forms\Components\TextInput::make('lebar_depan')
                            ->numeric(),
                        Forms\Components\TextInput::make('lebar_dada')
                            ->numeric(),
                        Forms\Components\TextInput::make('lebar_pinggang')
                            ->numeric(),
                        Forms\Components\TextInput::make('lebar_bawah')
                            ->numeric(),
                        Forms\Components\TextInput::make('panjang_baju')
                            ->numeric(),
                        Forms\Components\TextInput::make('panjang_tangan')
                            ->numeric(),
                        Forms\Components\TextInput::make('lingkar_tangan_atas')
                            ->numeric(),
                        Forms\Components\TextInput::make('lingkar_tangan_bawah')
                            ->numeric(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lebar_bahu')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_belakang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_depan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_dada')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_pinggang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_bawah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_baju')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_tangan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_tangan_atas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkar_tangan_bawah')
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
                DateRangeFilter::make('created_at')
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
            'index' => Pages\ListPduWanitas::route('/'),
            'create' => Pages\CreatePduWanita::route('/create'),
            'edit' => Pages\EditPduWanita::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'PDU Wanita';
    }

    public static function getModelLabel(): string
    {
        return 'PDU Wanita';
    }

    public static function getPluralModelLabel(): string
    {
        return 'PDU Wanita';
    }
}
