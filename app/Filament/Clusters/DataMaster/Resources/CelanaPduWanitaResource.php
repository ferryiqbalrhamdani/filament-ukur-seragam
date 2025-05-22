<?php

namespace App\Filament\Clusters\DataMaster\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CelanaPduWanita;
use Filament\Resources\Resource;
use App\Filament\Clusters\DataMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use App\Filament\Clusters\DataMaster\Resources\CelanaPduWanitaResource\Pages;
use App\Filament\Clusters\DataMaster\Resources\CelanaPduWanitaResource\RelationManagers;

class CelanaPduWanitaResource extends Resource
{
    protected static ?string $model = CelanaPduWanita::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = DataMaster::class;

    protected static ?string $slug = 'celana-pdu-wanita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('size')
                    ->maxLength(100),
                Forms\Components\TextInput::make('lebar_pinggang')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_pinggul')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_paha')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_lutut')
                    ->numeric(),
                Forms\Components\TextInput::make('lebar_bawah')
                    ->numeric(),
                Forms\Components\TextInput::make('kress')
                    ->numeric(),
                Forms\Components\TextInput::make('panjang_celana')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lebar_pinggang')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_pinggul')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_paha')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_lutut')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lebar_bawah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kress')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('panjang_celana')
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
            'index' => Pages\ListCelanaPduWanitas::route('/'),
            'create' => Pages\CreateCelanaPduWanita::route('/create'),
            'edit' => Pages\EditCelanaPduWanita::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Celana PDU Wanita';
    }

    public static function getModelLabel(): string
    {
        return 'Celana PDU Wanita';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Celana PDU Wanita';
    }
}
