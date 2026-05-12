<?php

namespace App\Http\Controllers\Admin;

use App\Models\Surat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $jenisSurat = JenisSurat::all();
        return view('admin.laporan.index', compact('jenisSurat'));
    }

    public function preview(Request $request)
    {
        $query = Surat::with(['warga', 'jenisSurat'])
            ->where('status', 'selesai')
            ->whereBetween('updated_at', [$request->tgl_awal . ' 00:00:00', $request->tgl_akhir . ' 23:59:59'])
            ->orderBy('updated_at', 'asc'); // Urutkan dari yang paling awal

        if ($request->jenis_surat != 'semua') {
            $query->where('jenis_surat_id', $request->jenis_surat);
        }

        $surat = $query->get();

        return response()->json([
            'count' => $surat->count(),
            'html' => view('admin.laporan.preview', compact('surat'))->render()
        ]);
    }

    public function exportExcel(Request $request)
    {
        $tglAwal = $request->tgl_awal;
        $tglAkhir = $request->tgl_akhir;
        $jenisSuratId = $request->jenis_surat;

        // 1. Identifikasi Mode Laporan
        $isSemua = ($jenisSuratId == 'semua');
        $isDomisili = ($jenisSuratId == 6); 
        
        $namaJenis = 'SEMUA JENIS SURAT';
        if (!$isSemua) {
            $js = JenisSurat::find($jenisSuratId);
            $namaJenis = strtoupper($js->nama_jenis ?? $js->nama_jenis);
        }

        // 2. Query Data dengan Pengurutan Waktu
        $query = Surat::with(['warga', 'jenisSurat'])
            ->where('status', 'selesai')
            ->whereBetween('updated_at', [$tglAwal . ' 00:00:00', $tglAkhir . ' 23:59:59'])
            ->orderBy('updated_at', 'asc'); // Urutkan dari yang paling awal

        if (!$isSemua) {
            $query->where('jenis_surat_id', $jenisSuratId);
        }

        $dataSurat = $query->get();

        // 3. Tentukan Headings
        $headings = ['NO', 'NO SURAT', 'TANGGAL'];
        if ($isSemua) $headings[] = 'JENIS SURAT';
        $headings = array_merge($headings, ['NAMA WARGA', 'NIK', 'ALAMAT LENGKAP', 'KEPERLUAN', 'KETERANGAN']);
        
        // Tampilkan kolom data usaha jika mode "Semua Jenis" ATAU "Domisili Usaha"
        if ($isDomisili || $isSemua) {
            $headings = array_merge($headings, ['NAMA USAHA', 'PIMPINAN', 'JABATAN', 'ALAMAT USAHA']);
        }

        // 4. Mapping Data
        $exportData = $dataSurat->map(function($surat, $index) use ($isSemua, $isDomisili) {
            $w = $surat->warga;
            $alamat = "RT " . ($w->rt ?? '-') . " / RW " . ($w->rw ?? '-') . ", Kel. " . ($w->kelurahan ?? '-') . ", Kec. " . ($w->kecamatan ?? '-');

            $row = [
                $index + 1,
                $surat->nomor_surat,
                $surat->updated_at->format('d/m/Y'),
            ];

            if ($isSemua) $row[] = $surat->jenisSurat->nama_jenis ?? '-';
            
            $row[] = $w->nama_lengkap ?? '-';
            $row[] = "'" . ($w->nik ?? '-');
            $row[] = $alamat;
         

            // Masukkan data usaha jika mode "Semua Jenis" (hanya terisi jika surat tersebut memang domisili) atau mode spesifik Domisili
            if ($isDomisili || $isSemua) {
                $row[] = $surat->nama_lembaga ?? '-';
                $row[] = $surat->penanggung_jawab ?? '-';
                $row[] = $surat->jabatan_penanggung_jawab ?? '-';
                $row[] = $surat->alamat_lembaga ?? '-';
            }
               $row[] = $surat->keperluan;
            $row[] = $surat->keterangan ?? '-';

            return $row;
        });

        $title = "LAPORAN REKAPITULASI " . $namaJenis;
        $periode = "PERIODE: " . Carbon::parse($tglAwal)->format('d/m/Y') . " s/d " . Carbon::parse($tglAkhir)->format('d/m/Y');
        $fileName = 'Laporan_Surat_' . str_replace(' ', '_', $namaJenis) . '_' . date('dmY') . '.xlsx';

        // 5. Build Excel dengan Styling Profesional
        return Excel::download(new class($exportData, $headings, $title, $periode) implements FromCollection, ShouldAutoSize, WithStyles, WithEvents {
            protected $data, $headings, $title, $periode;

            public function __construct($data, $headings, $title, $periode) {
                $this->data = $data;
                $this->headings = $headings;
                $this->title = $title;
                $this->periode = $periode;
            }

            public function collection() {
                return collect([
                    [$this->title],
                    [$this->periode],
                    [''],
                    $this->headings
                ])->concat($this->data);
            }

            public function styles(Worksheet $sheet) {
                $lastCol = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();

                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->mergeCells("A2:{$lastCol}2");
                
                return [
                    1 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
                    2 => ['font' => ['bold' => true, 'size' => 11], 'alignment' => ['horizontal' => 'center']],
                    4 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '198754']]], 
                ];
            }

            public function registerEvents(): array {
                return [
                    AfterSheet::class => function(AfterSheet $event) {
                        $lastCol = $event->sheet->getHighestColumn();
                        $lastRow = $event->sheet->getHighestRow();
                        $range = "A4:{$lastCol}{$lastRow}";
                        
                        $event->sheet->getStyle($range)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['rgb' => '000000'],
                                ],
                            ],
                            'alignment' => [
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                        ]);
                    },
                ];
            }
        }, $fileName);
    }
}