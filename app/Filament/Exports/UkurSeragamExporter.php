<?php

namespace App\Filament\Exports;

use App\Models\UkurSeragam;
use Filament\Actions\Exports\Exporter;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\CellVerticalAlignment;

class UkurSeragamExporter extends Exporter
{
    protected static ?string $model = UkurSeragam::class;

    // public function getXlsxHeaderCellStyle(): ?Style
    // {
    //     return (new Style())
    //         ->setFontBold()
    //         ->setFontItalic()
    //         ->setFontSize(14)
    //         ->setFontName('Consolas')
    //         ->setFontColor(Color::rgb(255, 255, 77))
    //         ->setBackgroundColor(Color::rgb(128, 128, 128))
    //         ->setCellAlignment(CellAlignment::CENTER)
    //         ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    // }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('personnel.personel_nrp')->label('NRP'),
            ExportColumn::make('personnel.personel_nama')->label('Nama Personel'),
            ExportColumn::make('personnel.personel_kelamin')->label('JK'),
            ExportColumn::make('personnel.tb')->label('Tinggi Badan'),
            ExportColumn::make('personnel.bb')->label('Berat Badan'),
            ExportColumn::make('personnel.pangkat_nama')->label('Pangkat'),
            ExportColumn::make('personnel.satker_nama')->label('Satker'),
            ExportColumn::make('personnel.jabatan_nama')->label('Jabatan'),

            ExportColumn::make('jenis_ukuran')->label('Jenis Ukuran PDU'),
            ExportColumn::make('size_pdu')->label('Size PDU'),

            ExportColumn::make('lebar_bahu_pdu')->label('Lebar Bahu PDU'),
            ExportColumn::make('toleransi_lebar_bahu_pdu')->label('Toleransi Lebar Bahu PDU'),

            ExportColumn::make('lebar_belakang_pdu')->label('Lebar Belakang PDU'),
            ExportColumn::make('toleransi_lebar_belakang_pdu')->label('Toleransi Lebar Belakang PDU'),

            ExportColumn::make('lebar_depan_pdu')->label('Lebar Depan PDU'),
            ExportColumn::make('toleransi_lebar_depan_pdu')->label('Toleransi Lebar Depan PDU'),

            ExportColumn::make('lebar_dada_pdu')->label('Lebar Dada PDU'),
            ExportColumn::make('toleransi_lebar_dada_pdu')->label('Toleransi Lebar Dada PDU'),

            ExportColumn::make('lebar_pinggang_pdu')->label('Lebar Pinggang PDU'),
            ExportColumn::make('toleransi_lebar_pinggang_pdu')->label('Toleransi Lebar Pinggang PDU'),

            ExportColumn::make('lebar_bawah_pdu')->label('Lebar Bawah PDU'),
            ExportColumn::make('toleransi_lebar_bawah_pdu')->label('Toleransi Lebar Bawah PDU'),

            ExportColumn::make('panjang_baju_pdu')->label('Panjang Baju PDU'),
            ExportColumn::make('toleransi_panjang_baju_pdu')->label('Toleransi Panjang Baju PDU'),

            ExportColumn::make('panjang_tangan_pdu')->label('Panjang Tangan PDU'),
            ExportColumn::make('toleransi_panjang_tangan_pdu')->label('Toleransi Panjang Tangan PDU'),

            ExportColumn::make('lingkar_tangan_atas_pdu')->label('Lingkar Tangan Atas PDU'),
            ExportColumn::make('toleransi_lingkar_tangan_atas_pdu')->label('Toleransi Lingkar Tangan Atas PDU'),

            ExportColumn::make('lingkar_tangan_bawah_pdu')->label('Lingkar Tangan Bawah PDU'),
            ExportColumn::make('toleransi_lingkar_tangan_bawah_pdu')->label('Toleransi Lingkar Tangan Bawah PDU'),

            ExportColumn::make('jenis_ukuran_kemeja')->label('Jenis Ukuran Kemeja'),
            ExportColumn::make('size_kemeja')->label('Size Kemeja'),

            ExportColumn::make('lebar_bahu_kemeja')->label('Lebar Bahu Kemeja'),
            ExportColumn::make('toleransi_lebar_bahu_kemeja')->label('Toleransi Lebar Bahu Kemeja'),

            ExportColumn::make('lebar_belakang_kemeja')->label('Lebar Belakang Kemeja'),
            ExportColumn::make('toleransi_lebar_belakang_kemeja')->label('Toleransi Lebar Belakang Kemeja'),

            ExportColumn::make('lebar_depan_kemeja')->label('Lebar Depan Kemeja'),
            ExportColumn::make('toleransi_lebar_depan_kemeja')->label('Toleransi Lebar Depan Kemeja'),

            ExportColumn::make('lebar_dada_kemeja')->label('Lebar Dada Kemeja'),
            ExportColumn::make('toleransi_lebar_dada_kemeja')->label('Toleransi Lebar Dada Kemeja'),

            ExportColumn::make('lebar_pinggang_kemeja')->label('Lebar Pinggang Kemeja'),
            ExportColumn::make('toleransi_lebar_pinggang_kemeja')->label('Toleransi Lebar Pinggang Kemeja'),

            ExportColumn::make('lebar_bawah_kemeja')->label('Lebar Bawah Kemeja'),
            ExportColumn::make('toleransi_lebar_bawah_kemeja')->label('Toleransi Lebar Bawah Kemeja'),

            ExportColumn::make('panjang_baju_kemeja')->label('Panjang Baju Kemeja'),
            ExportColumn::make('toleransi_panjang_baju_kemeja')->label('Toleransi Panjang Baju Kemeja'),

            ExportColumn::make('panjang_tangan_kemeja')->label('Panjang Tangan Kemeja'),
            ExportColumn::make('toleransi_panjang_tangan_kemeja')->label('Toleransi Panjang Tangan Kemeja'),

            ExportColumn::make('lingkar_tangan_atas_kemeja')->label('Lingkar Tangan Atas Kemeja'),
            ExportColumn::make('toleransi_lingkar_tangan_atas_kemeja')->label('Toleransi Lingkar Tangan Atas Kemeja'),

            ExportColumn::make('lingkar_tangan_bawah_kemeja')->label('Lingkar Tangan Bawah Kemeja'),
            ExportColumn::make('toleransi_lingkar_tangan_bawah_kemeja')->label('Toleransi Lingkar Tangan Bawah Kemeja'),

            ExportColumn::make('jenis_ukuran_celana_pdu')->label('Jenis Ukuran Celana PDU'),
            ExportColumn::make('size_celana_pdu')->label('Size Celana PDU'),

            ExportColumn::make('lebar_pinggang_celana_pdu')->label('Lebar Pinggang Celana PDU'),
            ExportColumn::make('toleransi_lebar_pinggang_celana_pdu')->label('Toleransi Lebar Pinggang Celana PDU'),

            ExportColumn::make('lebar_pinggul_celana_pdu')->label('Lebar Pinggul Celana PDU'),
            ExportColumn::make('toleransi_lebar_pinggul_celana_pdu')->label('Toleransi Lebar Pinggul Celana PDU'),

            ExportColumn::make('lebar_paha_celana_pdu')->label('Lebar Paha Celana PDU'),
            ExportColumn::make('toleransi_lebar_paha_celana_pdu')->label('Toleransi Lebar Paha Celana PDU'),

            ExportColumn::make('lebar_lutut_celana_pdu')->label('Lebar Lutut Celana PDU'),
            ExportColumn::make('toleransi_lebar_lutut_celana_pdu')->label('Toleransi Lebar Lutut Celana PDU'),

            ExportColumn::make('lebar_bawah_celana_pdu')->label('Lebar Bawah Celana PDU'),
            ExportColumn::make('toleransi_lebar_bawah_celana_pdu')->label('Toleransi Lebar Bawah Celana PDU'),

            ExportColumn::make('kress_celana_pdu')->label('Kress Celana PDU'),
            ExportColumn::make('toleransi_kress_celana_pdu')->label('Toleransi Kress Celana PDU'),

            ExportColumn::make('panjang_celana_celana_pdu')->label('Panjang Celana PDU'),
            ExportColumn::make('toleransi_panjang_celana_celana_pdu')->label('Toleransi Panjang Celana PDU'),

            ExportColumn::make('created_at')->label('Created At'),
            ExportColumn::make('updated_at')->label('Updated At'),
        ];
    }


    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your ukur seragam export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
