<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\PduPria;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\PduWanita;
use App\Models\Personnel;
use App\Models\KemejaPria;
use Filament\Tables\Table;
use App\Models\UkurSeragam;
use App\Models\KemejaWanita;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\UkurSeragamExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UkurSeragamResource\Pages;
use App\Filament\Resources\UkurSeragamResource\RelationManagers;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use App\Filament\Resources\UkurSeragamResource\Widgets\StatsUkurSeragamOverview;
use App\Filament\Resources\UkurSeragamResource\RelationManagers\HistoriesRelationManager;

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
                            Forms\Components\Select::make('personel_id')
                                ->label('NRP')
                                ->unique(UkurSeragam::class, 'personel_id', ignoreRecord: true)
                                ->required()
                                ->searchable()
                                ->reactive()
                                ->getSearchResultsUsing(
                                    fn(string $search) =>
                                    Personnel::query()
                                        ->where('personel_nrp', 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck('personel_nrp', 'id')
                                )
                                ->getOptionLabelUsing(
                                    fn($value) =>
                                    Personnel::find($value)?->personel_nrp
                                )
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $personel = \App\Models\Personnel::find($state);

                                    if ($personel) {
                                        $set('personel_nama', $personel->personel_nama);
                                        $set('personel_kelamin', $personel->personel_kelamin);
                                        $set('pangkat_nama', $personel->pangkat_nama);
                                        $set('satker_nama', $personel->satker_nama);
                                        $set('jabatan_nama', $personel->jabatan_nama);
                                    } else {
                                        $set('personel_nama', null);
                                        $set('personel_kelamin', null);
                                        $set('pangkat_nama', null);
                                        $set('satker_nama', null);
                                        $set('jabatan_nama', null);
                                    }

                                    // Reset field-field ukuran saat personel diganti
                                    $set('size_pdu', null);
                                    $set('lebar_bahu_pdu', null);
                                    $set('lebar_belakang_pdu', null);
                                    $set('lebar_depan_pdu', null);
                                    $set('lebar_dada_pdu', null);
                                    $set('lebar_pinggang_pdu', null);
                                    $set('lebar_bawah_pdu', null);
                                    $set('panjang_baju_pdu', null);
                                    $set('panjang_tangan_pdu', null);
                                    $set('lingkar_tangan_atas_pdu', null);
                                    $set('lingkar_tangan_bawah_pdu', null);
                                })
                                ->columnSpanFull()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('personel_nrp')
                                        ->label('NRP')
                                        ->unique(Personnel::class, 'personel_nrp', ignoreRecord: true)
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('personel_nama')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\Select::make('personel_kelamin')
                                        ->label('Jenis Kelamin')
                                        ->required()
                                        ->options([
                                            'L' => 'L',
                                            'P' => 'P',
                                            'PJ' => 'PJ',
                                        ]),
                                    Forms\Components\TextInput::make('pangkat_nama')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('satker_nama')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('jabatan_nama')
                                        ->required()
                                        ->maxLength(255),
                                ]),
                            Forms\Components\Fieldset::make('Informasi Personel')
                                ->schema([
                                    Forms\Components\Placeholder::make('personel_nama')
                                        ->label('Nama Personel')
                                        ->content(fn($get) => $get('personel_nama') ?? '-'),
                                    Forms\Components\Select::make('personel_kelamin')
                                        ->label('Jenis Kelamin')
                                        ->options([
                                            'L' => 'L',
                                            'P' => 'P',
                                            'PJ' => 'PJ',
                                        ])
                                        ->disabled(
                                            fn(Get $get) => $get('personel_id') === NULL
                                        ),
                                    Forms\Components\TextInput::make('pangkat_nama')
                                        ->label('Pangkat')
                                        ->disabled(
                                            fn(Get $get) => $get('personel_id') === NULL
                                        ),
                                    Forms\Components\TextInput::make('satker_nama')
                                        ->label('Satker')
                                        ->disabled(
                                            fn(Get $get) => $get('personel_id') === NULL
                                        ),
                                    Forms\Components\TextInput::make('jabatan_nama')
                                        ->label('Jabatan')
                                        ->disabled(
                                            fn(Get $get) => $get('personel_id') === NULL
                                        )
                                        ->columnSpanFull(),
                                ]),


                        ])
                        ->columns(2),
                    Wizard\Step::make('PDU')
                        ->schema([
                            Forms\Components\Radio::make('jenis_ukuran')
                                ->reactive()
                                ->options([
                                    'standar' => 'Standar',
                                    'kastem' => 'Kastem',
                                ])
                                ->afterStateUpdated(function (callable $set) {
                                    // Reset field-field ukuran saat personel diganti
                                    $set('size_pdu', null);
                                    $set('lebar_bahu_pdu', null);
                                    $set('lebar_belakang_pdu', null);
                                    $set('lebar_depan_pdu', null);
                                    $set('lebar_dada_pdu', null);
                                    $set('lebar_pinggang_pdu', null);
                                    $set('lebar_bawah_pdu', null);
                                    $set('panjang_baju_pdu', null);
                                    $set('panjang_tangan_pdu', null);
                                    $set('lingkar_tangan_atas_pdu', null);
                                    $set('lingkar_tangan_bawah_pdu', null);
                                })
                                ->inline()
                                ->inlineLabel(false),
                            Forms\Components\Select::make('size_pdu')
                                ->label('Ukuran PDU')
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->options(function (callable $get) {
                                    $personelId = $get('personel_id');
                                    if (!$personelId) return [];

                                    $personel = Personnel::find($personelId);
                                    if (!$personel) return [];

                                    return in_array($personel->personel_kelamin, ['P', 'PJ'])
                                        ? PduWanita::all()->pluck('size', 'size') // pakai size sebagai key & value
                                        : PduPria::all()->pluck('size', 'size');
                                })
                                ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                    $personelId = $get('personel_id');
                                    $personel = Personnel::find($personelId);
                                    $jenisUkuran = $get('jenis_ukuran');

                                    if (!$personel || !$state || $jenisUkuran !== 'standar') return;

                                    $model = in_array($personel->personel_kelamin, ['P', 'PJ'])
                                        ? PduWanita::where('size', $state)->first()
                                        : PduPria::where('size', $state)->first();

                                    if (!$model) return;

                                    $set('lebar_bahu_pdu', $model->lebar_bahu);
                                    $set('lebar_belakang_pdu', $model->lebar_belakang);
                                    $set('lebar_depan_pdu', $model->lebar_depan);
                                    $set('lebar_dada_pdu', $model->lebar_dada);
                                    $set('lebar_pinggang_pdu', $model->lebar_pinggang);
                                    $set('lebar_bawah_pdu', $model->lebar_bawah);
                                    $set('panjang_baju_pdu', $model->panjang_baju);
                                    $set('panjang_tangan_pdu', $model->panjang_tangan);
                                    $set('lingkar_tangan_atas_pdu', $model->lingkar_tangan_atas);
                                    $set('lingkar_tangan_bawah_pdu', $model->lingkar_tangan_bawah);
                                }),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_bahu_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Bahu')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_bahu_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_belakang_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Belakang')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_belakang_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_depan_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Depan')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_depan_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_dada_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Dada')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_dada_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_pinggang_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Pinggang')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_pinggang_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_bawah_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Bawah')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_bawah_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('panjang_baju_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Panjang Baju')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_panjang_baju_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('panjang_tangan_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Panjang Tangan')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_panjang_tangan_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lingkar_tangan_atas_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lingkar_tangan_atas_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lingkar_tangan_bawah_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran');
                                        $sizePdu = $get('size_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkat Tangan Bawah')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lingkar_tangan_bawah_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_pdu'),
                                                $get('lebar_belakang_pdu'),
                                                $get('lebar_depan_pdu'),
                                                $get('lebar_dada_pdu'),
                                                $get('lebar_pinggang_pdu'),
                                                $get('lebar_bawah_pdu'),
                                                $get('panjang_baju_pdu'),
                                                $get('panjang_tangan_pdu'),
                                                $get('lingkar_tangan_atas_pdu'),
                                                $get('lingkar_tangan_bawah_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                        ])
                        ->columns(2),
                    Wizard\Step::make('Kemeja')
                        ->schema([
                            Forms\Components\Radio::make('jenis_ukuran_kemeja')
                                ->label('Jenis Ukuran')
                                ->reactive()
                                ->options([
                                    'standar' => 'Standar',
                                    'kastem' => 'Kastem',
                                ])
                                ->afterStateUpdated(function (callable $set) {
                                    // Reset field-field ukuran saat personel diganti
                                    $set('size_kemeja', null);
                                    $set('lebar_bahu_kemeja', null);
                                    $set('lebar_belakang_kemeja', null);
                                    $set('lebar_depan_kemeja', null);
                                    $set('lebar_dada_kemeja', null);
                                    $set('lebar_pinggang_kemeja', null);
                                    $set('lebar_bawah_kemeja', null);
                                    $set('panjang_baju_kemeja', null);
                                    $set('panjang_tangan_kemeja', null);
                                    $set('lingkar_tangan_atas_kemeja', null);
                                    $set('lingkar_tangan_bawah_kemeja', null);

                                    $set('toleransi_lebar_bahu_kemeja', 0);
                                    $set('toleransi_lebar_belakang_kemeja', 0);
                                    $set('toleransi_lebar_depan_kemeja', 0);
                                    $set('toleransi_lebar_dada_kemeja', 0);
                                    $set('toleransi_lebar_pinggang_kemeja', 0);
                                    $set('toleransi_lebar_bawah_kemeja', 0);
                                    $set('toleransi_panjang_baju_kemeja', 0);
                                    $set('toleransi_panjang_tangan_kemeja', 0);
                                    $set('toleransi_lingkar_tangan_atas_kemeja', 0);
                                    $set('toleransi_lingkar_tangan_bawah_kemeja', 0);
                                })
                                ->inline()
                                ->inlineLabel(false),
                            Forms\Components\Select::make('size_kemeja')
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->options(function (callable $get) {
                                    $personelId = $get('personel_id');
                                    if (!$personelId) return [];

                                    $personel = Personnel::find($personelId);
                                    if (!$personel) return [];

                                    return in_array($personel->personel_kelamin, ['P', 'PJ'])
                                        ? KemejaWanita::all()->pluck('size', 'size') // pakai size sebagai key & value
                                        : KemejaPria::all()->pluck('size', 'size');
                                })
                                ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                    $personelId = $get('personel_id');
                                    $personel = Personnel::find($personelId);
                                    $jenisUkuran = $get('jenis_ukuran_kemeja');

                                    if (!$personel || !$state || $jenisUkuran !== 'standar') return;


                                    $model = in_array($personel->personel_kelamin, ['P', 'PJ'])
                                        ? KemejaWanita::where('size', $state)->first()
                                        : KemejaPria::where('size', $state)->first();

                                    if (!$model) return;

                                    $set('lebar_bahu_kemeja', $model->lebar_bahu);
                                    $set('lebar_belakang_kemeja', $model->lebar_belakang);
                                    $set('lebar_depan_kemeja', $model->lebar_depan);
                                    $set('lebar_dada_kemeja', $model->lebar_dada);
                                    $set('lebar_pinggang_kemeja', $model->lebar_pinggang);
                                    $set('lebar_bawah_kemeja', $model->lebar_bawah);
                                    $set('panjang_baju_kemeja', $model->panjang_baju);
                                    $set('panjang_tangan_kemeja', $model->panjang_tangan);
                                    $set('lingkar_tangan_atas_kemeja', $model->lingkar_tangan_atas);
                                    $set('lingkar_tangan_bawah_kemeja', $model->lingkar_tangan_bawah);
                                }),
                            // start

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_bahu_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Bahu')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_bahu_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_belakang_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Belakang')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_belakang_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_depan_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Depan')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_depan_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_dada_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Dada')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_dada_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_pinggang_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Pinggang')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_pinggang_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_bawah_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lebar Bawah')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_bawah_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('panjang_baju_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Panjang Baju')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_panjang_baju_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('panjang_tangan_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Panjang Tangan')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_panjang_tangan_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lingkar_tangan_atas_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lingkar_tangan_atas_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),
                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lingkar_tangan_bawah_kemeja')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_kemeja');
                                        $sizePdu = $get('size_kemeja');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkat Tangan Bawah')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lingkar_tangan_bawah_kemeja')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_kemeja') === 'kastem'
                                            || collect([
                                                $get('lebar_bahu_kemeja'),
                                                $get('lebar_belakang_kemeja'),
                                                $get('lebar_depan_kemeja'),
                                                $get('lebar_dada_kemeja'),
                                                $get('lebar_pinggang_kemeja'),
                                                $get('lebar_bawah_kemeja'),
                                                $get('panjang_baju_kemeja'),
                                                $get('panjang_tangan_kemeja'),
                                                $get('lingkar_tangan_atas_kemeja'),
                                                $get('lingkar_tangan_bawah_kemeja'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            // end

                        ])
                        ->columns(2),
                    Wizard\Step::make('Celana PDU')
                        ->schema([
                            Forms\Components\Radio::make('jenis_ukuran_celana_pdu')
                                ->label('Jenis Ukuran')
                                ->reactive()
                                ->options([
                                    'standar' => 'Standar',
                                    'kastem' => 'Kastem',
                                ])
                                ->afterStateUpdated(function (callable $set) {
                                    // Reset field-field ukuran saat personel diganti
                                    $set('size_celana_pdu', null);
                                    $set('lebar_pinggang_celana_pdu', null);
                                    $set('lebar_pinggul_celana_pdu', null);
                                    $set('lebar_paha_celana_pdu', null);
                                    $set('lebar_lutut_celana_pdu', null);
                                    $set('lebar_bawah_celana_pdu', null);
                                    $set('kress_celana_pdu', null);
                                    $set('panjang_celana_celana_pdu', null);

                                    $set('toleransi_lebar_pinggang_celana_pdu', 0);
                                    $set('toleransi_lebar_pinggul_celana_pdu', 0);
                                    $set('toleransi_lebar_paha_celana_pdu', 0);
                                    $set('toleransi_lebar_lutut_celana_pdu', 0);
                                    $set('toleransi_lebar_bawah_celana_pdu', 0);
                                    $set('toleransi_kress_celana_pdu', 0);
                                    $set('toleransi_panjang_celana_celana_pdu', 0);
                                })
                                ->inline()
                                ->inlineLabel(false),
                            Forms\Components\Select::make('size_celana_pdu')
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->options(function (callable $get) {
                                    $personelId = $get('personel_id');
                                    if (!$personelId) return [];

                                    $personel = Personnel::find($personelId);
                                    if (!$personel) return [];

                                    return in_array($personel->personel_kelamin, ['P', 'PJ'])
                                        ? KemejaWanita::all()->pluck('size', 'size') // pakai size sebagai key & value
                                        : KemejaPria::all()->pluck('size', 'size');
                                })
                                ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                    $personelId = $get('personel_id');
                                    $personel = Personnel::find($personelId);
                                    $jenisUkuran = $get('jenis_ukuran_celana_pdu');

                                    if (!$personel || !$state || $jenisUkuran !== 'standar') return;

                                    $model = in_array($personel->personel_kelamin, ['P', 'PJ'])
                                        ? KemejaWanita::where('size', $state)->first()
                                        : KemejaPria::where('size', $state)->first();

                                    if (!$model) return;

                                    $set('lebar_pinggang_celana_pdu', $model->lebar_bahu);
                                    $set('lebar_pinggul_celana_pdu', $model->lebar_belakang);
                                    $set('lebar_paha_celana_pdu', $model->lebar_depan);
                                    $set('lebar_lutut_celana_pdu', $model->lebar_dada);
                                    $set('lebar_bawah_celana_pdu', $model->lebar_pinggang);
                                    $set('kress_celana_pdu', $model->lebar_bawah);
                                    $set('panjang_celana_celana_pdu', $model->panjang_baju);
                                }),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_pinggang_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_pinggang_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_pinggul_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_pinggul_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_paha_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_paha_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_lutut_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_lutut_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('lebar_bawah_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_lebar_bawah_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('kress_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_kress_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                            Forms\Components\Group::make([
                                Forms\Components\TextInput::make('panjang_celana_celana_pdu')
                                    ->numeric()
                                    ->readOnly(function (callable $get) {
                                        $jenisUkuran = $get('jenis_ukuran_celana_pdu');
                                        $sizePdu = $get('size_celana_pdu');

                                        // Jika dua-duanya null
                                        if (is_null($jenisUkuran) && is_null($sizePdu)) {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && $jenisUkuran === 'standar') {
                                            return true;
                                        }

                                        // Jika size_pdu diisi dan jenis_ukuran adalah 'standar'
                                        if (!is_null($sizePdu) && is_null($jenisUkuran)) {
                                            return true;
                                        }



                                        // Selain itu, editable
                                        return false;
                                    })
                                    ->label('Lingkar Tangan Atas')
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('toleransi_panjang_celana_celana_pdu')
                                    ->numeric()
                                    ->maxValue(1)
                                    ->minValue(-1)
                                    ->default(0)
                                    ->label('Toleransi')
                                    ->readOnly(function (callable $get) {
                                        return $get('jenis_ukuran_celana_pdu') === 'kastem'
                                            || collect([
                                                $get('lebar_pinggang_celana_pdu'),
                                                $get('lebar_pinggul_celana_pdu'),
                                                $get('lebar_paha_celana_pdu'),
                                                $get('lebar_lutut_celana_pdu'),
                                                $get('lebar_bawah_celana_pdu'),
                                                $get('kress_celana_pdu'),
                                                $get('panjang_celana_celana_pdu'),
                                            ])->filter()->isEmpty();
                                    })
                                    ->columnSpan(2),
                            ])
                                ->columns(6),

                        ])
                        ->columns(2),
                ])
                    ->columnSpanFull(),




            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(UkurSeragamExporter::class)
                    ->slideOver()
                    ->modalWidth(MaxWidth::FiveExtraLarge),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('personnel.personel_nrp')
                    ->label('NRP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('personnel.personel_nama')
                    ->label('Nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('personnel.personel_kelamin')
                    ->label('JK')
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
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                DateRangeFilter::make('created_at')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\ViewAction::make(),
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
            HistoriesRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsUkurSeragamOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUkurSeragams::route('/'),
            'create' => Pages\CreateUkurSeragam::route('/create'),
            'view' => Pages\ViewUkurSeragam::route('/{record}'),
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
