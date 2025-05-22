<?php

namespace App\Filament\Clusters\DataMaster\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Personnel;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\DataMaster;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Pages;
use App\Filament\Clusters\DataMaster\Resources\PersonnelResource\RelationManagers;
use App\Filament\Clusters\DataMaster\Resources\PersonnelResource\Widgets\PersonnelOverview;

class PersonnelResource extends Resource
{
    protected static ?string $model = Personnel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = DataMaster::class;

    protected static ?string $slug = 'personel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('personel_nrp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('personel_nama')
                    ->maxLength(255),
                Forms\Components\Radio::make('personel_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan'
                    ])
                    ->inline()
                    ->inlineLabel(false),
                Forms\Components\TextInput::make('pangkat_nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('satker_nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan_nama')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('destroy_all')
                    ->label('Hapus semua data')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->modalIcon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function () {

                        Personnel::query()->delete();

                        Notification::make()
                            ->title('Data berhasil dihapus')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                Tables\Columns\TextColumn::make('personel_nrp')
                    ->sortable(),
                Tables\Columns\TextColumn::make('personel_nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('personel_kelamin')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pangkat_nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('satker_nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan_nama')
                    ->searchable()
                    ->limit(50),
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
            'index' => Pages\ListPersonnels::route('/'),
            'create' => Pages\CreatePersonnel::route('/create'),
            'edit' => Pages\EditPersonnel::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PersonnelOverview::class,
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Personel';
    }

    public static function getModelLabel(): string
    {
        return 'Personel';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Personel';
    }
}
