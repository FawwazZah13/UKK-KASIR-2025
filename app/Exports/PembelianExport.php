<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize,
    WithMapping
};

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Pembelian;

class PembelianExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    public function collection()
    {
        // Ambil data pembelian beserta relasi customer dan detail produk
        return Pembelian::with(['customer', 'details.produk'])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'Nomor Telpon',
            'Poin',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal',
        ];
    }

    public function map($row): array
    {
        $produkList = $row->details->map(function ($item) {
            $nama = $item->produk->nama_produk ?? '-';
            $qty = $item->qty ?? 0;
            $harga = number_format($item->produk->harga ?? 0, 0, ',', '.');
            return "$nama (x$qty) - Rp$harga";
        })->implode(', ');
        

        return [
            $row->customer->name ?? '-',
            $row->customer->no_tlp ?? '-',
            $row->customer->poin ?? '-',
            $produkList,
            'Rp ' . number_format($row->total_harga, 0, ',', '.'),
            'Rp ' . number_format($row->total_bayar, 0, ',', '.'),
            'Rp ' . number_format($row->total_harga, 0, ',', '.'),
            'Rp ' . number_format($row->total_kembalian, 0, ',', '.'),
            $row->created_at->format('d-m-Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],
        ];
    }
}
