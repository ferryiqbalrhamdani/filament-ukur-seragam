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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('latestUkurSeragam');
    }


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
                        'L' => 'L',
                        'P' => 'P',
                        'PJ' => 'PJ',
                    ])
                    ->inline()
                    ->inlineLabel(false),
                Forms\Components\TextInput::make('tb')
                    ->numric()
                    ->label('Tinggi Badan'),
                Forms\Components\TextInput::make('bb')
                    ->numric()
                    ->label('Berat Badan'),
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('personel_nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('personel_kelamin')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tb')
                    ->label('Tinggi Badan')
                    ->default('-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bb')
                    ->label('Berat Badan')
                    ->default('-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pangkat_nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('satker_nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan_nama')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('latestUkurSeragam.size_pdu')
                    ->label('Size PDU')
                    ->default('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_bahu_pdu')
                    ->label('Lebar Bahu PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_belakang_pdu')
                    ->label('Lebar Belakang PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_depan_pdu')
                    ->label('Lebar Depan PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_dada_pdu')
                    ->label('Lebar Dada PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_pinggang_pdu')
                    ->label('Lebar Pinggang PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_bawah_pdu')
                    ->label('Lebar Bawah PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.panjang_baju_pdu')
                    ->label('Panjang Baju PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.panjang_tangan_pdu')
                    ->label('Panjang Tangan PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lingkar_tangan_atas_pdu')
                    ->label('Lingkar Tangan Atas PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lingkar_tangan_bawah_pdu')
                    ->label('Lingkar Tangan Bawah PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),

                Tables\Columns\TextColumn::make('latestUkurSeragam.size_kemeja')
                    ->label('Size Kemeja')
                    ->default('-'),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_bahu_kemeja')
                    ->label('Lebar Bahu Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_belakang_kemeja')
                    ->label('Lebar Belakang Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_depan_kemeja')
                    ->label('Lebar Depan Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_dada_kemeja')
                    ->label('Lebar Dada Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_pinggang_kemeja')
                    ->label('Lebar Pinggang Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_bawah_kemeja')
                    ->label('Lebar Bawah Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.panjang_baju_kemeja')
                    ->label('Panjang Baju Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.panjang_tangan_kemeja')
                    ->label('Panjang Tangan Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lingkar_tangan_atas_kemeja')
                    ->label('Lingkar Tangan Atas Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lingkar_tangan_bawah_kemeja')
                    ->label('Lingkar Tangan Bawah Kemeja')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),

                Tables\Columns\TextColumn::make('latestUkurSeragam.size_celana_pdu')
                    ->label('Size Celana PDU')
                    ->default('-'),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_pinggang_celana_pdu')
                    ->label('Lebar Pinggang Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_pinggul_celana_pdu')
                    ->label('Lebar Pinggul Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_paha_celana_pdu')
                    ->label('Lebar Paha Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_lutut_celana_pdu')
                    ->label('Lebar Lutut Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.lebar_bawah_celana_pdu')
                    ->label('Lebar Bawah Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.kress_celana_pdu')
                    ->label('Kress Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),
                Tables\Columns\TextColumn::make('latestUkurSeragam.panjang_celana_celana_pdu')
                    ->label('Panjang Celana PDU')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->default(0),

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
