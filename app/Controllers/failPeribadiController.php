<?php namespace App\Controllers;

use App\Models\failPeribadiModel;
use App\Models\failPeribadiPinjamModel;
use App\Models\peminjamModel;
use App\Models\lokasiModel;
use App\Models\bhgnCwgnModel;
use App\Models\jawatanModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;

class failPeribadiController extends BaseController
{
    public function index()
    {
        $model = new failPeribadiModel();
        $data['failPeribadi'] = $model->findAll();
        return view('failPeribadi/index', $data);
    }

    public function store()
    {
        $model = new failPeribadiModel();
    
        // Get input values
        $nokp = $this->request->getPost('NOKP');
        $nofail = $this->request->getPost('NOFAIL');
        $nojilid = $this->request->getPost('NOJILID');
    
        // Check for duplicate combination of NOKP, NOFAIL, and NOJILID
        $existingRecord = $model->where([
            'NOKP' => $nokp,
            'NOFAIL' => $nofail,
            'NOJILID' => $nojilid,
        ])->first();
    
        if ($existingRecord) {
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', 'Maklumat fail tidak sah kerana mempunyai no. kad pengenalan, no. fail dan jilid yang sama.');
        }
    
        // Prepare data for insertion
        $data = [
            'NAMA' => $this->request->getPost('NAMA'),
            'NOKP' => $nokp,
            'JAWATAN' => $this->request->getPost('JAWATAN'),
            'BAHAGIAN_CAWANGAN' => $this->request->getPost('BAHAGIAN_CAWANGAN'),
            'NOFAIL' => $nofail,
            'NOJILID' => $nojilid,
            'TARIKH' => $this->request->getPost('TARIKH'),
            'STATUS' => $this->request->getPost('STATUS'),
            'CATITAN' => $this->request->getPost('CATITAN') ?? '-',
            'LOKASI_FAIL' => $this->request->getPost('LOKASI_FAIL'),
        ];
    
        // Save data
        $model->save($data);
    
        // Redirect with success message
        return redirect()->to('failPeribadi')->with('statusindexfp', 'Fail peribadi berjaya dimasukkan');
    }

    public function add()
    {
        $lokasiModel = new lokasiModel();
        $bhgnCwgnModel = new bhgnCwgnModel();
        $jawatanModel = new jawatanModel();
        $data['lokasiFail'] = $lokasiModel->findAll();
        $data['bhgnCwgn'] = $bhgnCwgnModel->findAll();
        $data['jawatan'] = $jawatanModel->findAll();
        return view('failPeribadi/add', $data);
    }

    public function edit($id)
    {
        $failPeribadiModel = new failPeribadiModel();
        $lokasiModel = new lokasiModel();
        $bhgnCwgnModel = new bhgnCwgnModel();
        $jawatanModel = new jawatanModel();
        $data['failPeribadi'] = $failPeribadiModel->find($id);
        $data['lokasiFail'] = $lokasiModel->findAll();
        $data['bhgnCwgn'] = $bhgnCwgnModel->findAll();
        $data['jawatan'] = $jawatanModel->findAll();
        return view('failPeribadi/edit', $data);
    }

    public function update($id)
    {
        $model = new failPeribadiModel();
    
        // Get input values
        $nokp = $this->request->getPost('NOKP');
        $nofail = $this->request->getPost('NOFAIL');
        $nojilid = $this->request->getPost('NOJILID');
    
        // Check for duplicate combination of NOKP, NOFAIL, and NOJILID (excluding the current record)
        $existingRecord = $model->where([
            'NOKP' => $nokp,
            'NOFAIL' => $nofail,
            'NOJILID' => $nojilid,
        ])
        ->where('id !=', $id) // Exclude the current record
        ->first();
    
        if ($existingRecord) {
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', 'Maklumat fail tidak sah kerana mempunyai no. kad pengenalan, no. fail dan jilid yang sama.');
        }
    
        // Prepare data for update
        $data = [
            'NAMA' => $this->request->getPost('NAMA'),
            'NOKP' => $nokp,
            'JAWATAN' => $this->request->getPost('JAWATAN'),
            'BAHAGIAN_CAWANGAN' => $this->request->getPost('BAHAGIAN_CAWANGAN'),
            'NOFAIL' => $nofail,
            'NOJILID' => $nojilid,
            'TARIKH' => $this->request->getPost('TARIKH'),
            'STATUS' => $this->request->getPost('STATUS'),
            'CATITAN' => $this->request->getPost('CATITAN') ?? '-',
            'LOKASI_FAIL' => $this->request->getPost('LOKASI_FAIL'),
        ];
    
        // Update data
        $model->update($id, $data);
    
        // Redirect with success message
        return redirect()->to(base_url('failPeribadi'))->with('statusindexfp', 'Fail peribadi berjaya dikemaskini!');
    }

    public function delete($id)
    {
        $failPeribadiModel = new failPeribadiModel();
        $failPeribadiModel->delete($id);
        return;
    }

    public function pinjam()
    {
        $failPeribadiModel = new failPeribadiModel();
        $data['failPeribadi'] = $failPeribadiModel->findAll();
        return view('/failPeribadi/pinjam', $data);
    }

    public function getDetails($NOKP, $NOFAIL, $NOJILID)
    {
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $fileDetails = $failPeribadiPinjamModel->where([
            'NOKP' => $NOKP,
            'NOFAIL' => $NOFAIL,
            'NOJILID' => $NOJILID
        ])
            ->orderBy('TARIKHPPT', 'DESC')
            ->findAll();

        if ($fileDetails) {
            return $this->response->setJSON($fileDetails);
        }

        return $this->response->setJSON(['error' => 'No data found'])->setStatusCode(404);
    }

    public function pinjamPulang($NOKP, $NOFAIL, $NOJILID)
    {
        $failPeribadiModel = new failPeribadiModel();
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $peminjamModel = new peminjamModel();

        $data['failPeribadi'] = $failPeribadiModel->where([
            'NOKP' => $NOKP,
            'NOFAIL' => $NOFAIL,
            'NOJILID' => $NOJILID
        ])->first();

        $data['failPeribadiPinjam'] = $failPeribadiPinjamModel->where([
            'NOKP' => $NOKP,
            'NOFAIL' => $NOFAIL,
            'NOJILID' => $NOJILID
        ])->orderBy('TARIKHPPT', 'DESC')->first();

        $data['peminjam'] = $peminjamModel->findAll();

        $data['NOKP'] = $NOKP;
        $data['NOFAIL'] = $NOFAIL;
        $data['NOJILID'] = $NOJILID;

        return view('failPeribadi/pinjamPulang', $data);
    }

    public function editPinjamPulang($id)
    {
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $peminjamModel = new peminjamModel();

        $data['failPeribadiPinjam'] = $failPeribadiPinjamModel->find($id);
        $data['peminjam'] = $peminjamModel->findAll();

        return view('failPeribadi/editPinjamPulang', $data);
    }

    public function updatePinjamPulang($id)
    {
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $data = [
            'NAMAPENGGUNA'=> $this->request->getPost('NAMAPENGGUNA'),
            'TARIKHPPT'=> $this->request->getPost('TARIKHPPT'),
            'STATUS2'=> $this->request->getPost('STATUS2'),
        ];
        $failPeribadiPinjamModel->update($id, $data);
        return redirect()->to(base_url('failPeribadi/pinjam'))->with('statuspinjamfp','Data pinjam fail peribadi berjaya dikemaskini!');
    }

    public function deletePinjamPulang($id)
    {
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $result = $failPeribadiPinjamModel->delete($id);

        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function addPinjamPulang()
    {
        $failPeribadiModel = new failPeribadiModel();
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $peminjamModel = new peminjamModel();
    
        // Retrieve POST data
        $NOKP = $this->request->getPost('NOKP');
        $NOFAIL = $this->request->getPost('NOFAIL');
        $NOJILID = $this->request->getPost('NOJILID');
        $NAMAPENGGUNA = $this->request->getPost('NAMAPENGGUNA');
        $TARIKHPPT = $this->request->getPost('TARIKHPPT');
        $STATUS2 = $this->request->getPost('STATUS2');
    
        // Fetch borrower details
        $namaPeminjam = $peminjamModel->where('user', $NAMAPENGGUNA)->first();
        $phone = $namaPeminjam['phone'] ?? '';
        $email = $namaPeminjam['email'] ?? '';
    
        // Retrieve existing data
        $existingData = $failPeribadiModel->where(['NOKP' => $NOKP, 'NOFAIL' => $NOFAIL, 'NOJILID' => $NOJILID])->first();
    
        if ($existingData) {
            // Merge POST data with existing data
            $data = array_merge($existingData, [
                'NAMAPENGGUNA' => $NAMAPENGGUNA,
                'TARIKHPPT' => $TARIKHPPT,
                'STATUS2' => $STATUS2,
                'phone' => $phone,
                'email' => $email,
            ]);
    
            // Insert updated data
            $failPeribadiPinjamModel->insert($data);
    
            // Set status message
            $message = match ($STATUS2) {
                'DIPINJAM' => 'Fail berjaya dipinjam',
                'DIPULANG' => 'Fail berjaya dipulang',
                'DITUTUP' => 'Fail berjaya ditutup',
                'DILUPUS' => 'Fail berjaya dilupus',
                default => 'Status tidak dikenali',
            };
    
            // Redirect to the appropriate page with the status message
            return redirect()->to('/failPeribadi/pinjam/')->with('statuspinjamfp', $message);
        } else {
            // Handle case where existing data is not found
            return redirect()->to('/failPeribadi/pinjam/')->with('statuspinjamfp', 'Data tidak dijumpai');
        }
    }    

    public function laporanKeseluruhanData()
    {
        $failPeribadiModel = new failPeribadiModel();
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();

        $failBaru = $failPeribadiModel->select("MONTH(TARIKH) as bulan, COUNT(*) as jumlah_baru")
            ->where("TARIKH IS NOT NULL")
            ->groupBy("MONTH(TARIKH)")
            ->findAll();

        $failTutup = $failPeribadiPinjamModel->select("MONTH(TARIKHPPT) as bulan, COUNT(*) as jumlah_tutup")
            ->where("TARIKHPPT IS NOT NULL")
            ->where("STATUS2", "TUTUP")
            ->groupBy("MONTH(TARIKHPPT)")
            ->findAll();

        $failPinjam = $failPeribadiPinjamModel->select("MONTH(TARIKHPPT) as bulan, COUNT(*) as jumlah_pinjam")
            ->where("TARIKHPPT IS NOT NULL")
            ->where("STATUS2", "DIPINJAM")
            ->groupBy("MONTH(TARIKHPPT)")
            ->findAll();

        $failPulang = $failPeribadiPinjamModel->select("MONTH(TARIKHPPT) as bulan, COUNT(*) as jumlah_pulang")
            ->where("TARIKHPPT IS NOT NULL")
            ->where("STATUS2", "DIPULANG")
            ->groupBy("MONTH(TARIKHPPT)")
            ->findAll();

        $failBaruCounts = array_fill(1, 12, 0);
        $failTutupCounts = array_fill(1, 12, 0);
        $failPinjamCounts = array_fill(1, 12, 0);
        $failPulangCounts = array_fill(1, 12, 0);

        foreach ($failBaru as $row) {
            $failBaruCounts[$row['bulan']] = $row['jumlah_baru'];
        }

        foreach ($failTutup as $row) {
            $failTutupCounts[$row['bulan']] = $row['jumlah_tutup'];
        }

        foreach ($failPinjam as $row) {
            $failPinjamCounts[$row['bulan']] = $row['jumlah_pinjam'];
        }

        foreach ($failPulang as $row) {
            $failPulangCounts[$row['bulan']] = $row['jumlah_pulang'];
        }

        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April',
            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
        ];

        return [
            'failBaru' => $failBaruCounts,
            'failTutup' => $failTutupCounts,
            'failPinjam' => $failPinjamCounts,
            'failPulang' => $failPulangCounts,
            'months' => $months
        ];
    }

    public function laporanKeseluruhanPDF()
    {
        $data = $this->laporanKeseluruhanData();
        $html = view('failPeribadi/pdf/laporanKeseluruhanPdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan Keseluruhan Fail Peribadi.pdf", ["Attachment" => true]);
    }

    public function laporanKeseluruhanExcel()
    {
        $data = $this->laporanKeseluruhanData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()->setTitle('Laporan Keseluruhan Fail Peribadi');

        // Add a title
        $sheet->setCellValue('A1', 'Laporan Keseluruhan Fail Peribadi');

        // Set headers for the columns
        $headers = [
            'Bulan',
            'Fail Baru',
            'Fail Tutup',
            'Fail Dipinjamkan',
            'Fail Dipulangkan'
        ];

        // Add headers to the first row of the sheet
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '3', $header);
            $column++;
        }

        // Populate the data
        $row = 4;
        if (!empty($data['months'])) {
            foreach ($data['months'] as $index => $month) {
                $sheet->setCellValue('A' . $row, $month);
                $sheet->setCellValue('B' . $row, $data['failBaru'][$index] ?? '-');
                $sheet->setCellValue('C' . $row, $data['failTutup'][$index] ?? '-');
                $sheet->setCellValue('D' . $row, $data['failPinjam'][$index] ?? '-');
                $sheet->setCellValue('E' . $row, $data['failPulang'][$index] ?? '-');
                $row++;
            }
        } else {
            $sheet->setCellValue('A5', 'Tiada data dijumpai.');
        }

        // Set auto column size
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set the header for download
        $filename = 'Laporan Keseluruhan Fail Peribadi.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');


        ob_end_clean();
        ob_start();

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        $output = ob_get_clean();
        header('Content-Length: ' . strlen($output));
        echo $output;
        exit();
    }

    public function laporanKeseluruhan()
    {
        $data = $this->laporanKeseluruhanData();

        return view('failPeribadi/laporanKeseluruhan', $data);
    }

    public function laporanTkhBln()
    {
        return view('/failPeribadi/laporanTkhBln');
    }

    public function getAvailableYears()
    {
        $failPeribadiModel = new failPeribadiModel();
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $fileType = $this ->request->getGet('fileType');

        $years = [];
        if ($fileType == 'baru') {
            $years = $failPeribadiModel->select("YEAR(TARIKH) as year")
                ->where('TARIKH IS NOT NULL')
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        } elseif ($fileType == 'tutup') {
            $years = $failPeribadiPinjamModel->select("YEAR(TARIKHPPT) as year")
                ->where('TARIKHPPT IS NOT NULL')
                ->where('STATUS2', 'TUTUP')
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        } elseif ($fileType == 'pinjam' || $fileType == 'peminjam' || $fileType == 'peminjamLewat') {
            $years = $failPeribadiPinjamModel->select("YEAR(TARIKHPPT) as year")
                ->where('TARIKHPPT IS NOT NULL')
                ->where('STATUS2', 'DIPINJAM')
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        } elseif ($fileType == 'pulang') {
            $years = $failPeribadiPinjamModel->select("YEAR(TARIKHPPT) as year")
                ->where('TARIKHPPT IS NOT NULL')
                ->where('STATUS2', 'DIPULANG')
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        }

        return $this->response->setJSON($years);
    }

    public function laporanTkhBlnTblPDF()
    {
        // Load the required library for PDF generation
        $dompdf = new Dompdf();
    
        // Get the data passed via POST
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
        $failPeribadiData = json_decode($this->request->getPost('failPeribadiData'), true);
        $pdfPageRange = $this->request->getPost('pdfPageRange');
        $recordsPerPdfPage = 14;

        list($startPage, $endPage) = explode('-', $pdfPageRange);
        $startRecord = ($startPage - 1) * $recordsPerPdfPage;
        $endRecord = $endPage * $recordsPerPdfPage;

        $failPeribadiData = array_slice($failPeribadiData, $startRecord, $endRecord - $startRecord + 1);

        $startingNumber = $startRecord + 1;
    
        // Load the PDF view and pass data to it
        $html = view('failPeribadi/pdf/laporanTkhBlnTblPdf', [
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'fileType' => $fileType,
            'failPeribadiData' => $failPeribadiData,
            'startingNumber' => $startingNumber
        ]);
    
        // Render the HTML into a PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
    
        // Output the generated PDF
        $dompdf->stream($reportTitle . '.pdf', ['Attachment' => true]);
    }

    public function laporanTkhBlnTblExcel()
    {
        // Retrieve the data passed from the form
        $failPeribadiData = json_decode($this->request->getPost('failPeribadiData'), true);
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
    
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Set document properties
        $spreadsheet->getProperties()->setTitle($reportTitle);
    
        // Add a title
        $sheet->setCellValue('A1', $reportTitle);
        $sheet->setCellValue('A2', $dateDetails);
    
        // Set headers for the columns based on the data
        $headers = [
            'No.',
            'Nama',
            'No. KP',
            'Jawatan',
            'Bahagian / Cawangan',
            'No. Fail',
            'No. Jilid',
            'Status',
            'Lokasi Fail',
        ];
    
        if ($fileType === 'baru' || $fileType === 'tutup') {
            $headers[] = 'Tarikh ' . ($fileType === 'baru' ? 'Buka' : 'Tutup');
        } elseif ($fileType === 'pinjam' || $fileType === 'pulang') {
            $headers[] = 'Nama Peminjam';
            $headers[] = 'Telefon';
            $headers[] = 'Email';
            $headers[] = 'Tarikh ' . ($fileType === 'pinjam' ? 'Pinjam' : 'Pulang');
        }
    
        // Add headers to the first row of the sheet
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '4', $header);
            $column++;
        }
    
        // Populate the data
        $row = 5;
        if (!empty($failPeribadiData)) {
            foreach ($failPeribadiData as $index => $fail) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $fail['NAMA'] ?? '-');
                $sheet->setCellValue('C' . $row, $fail['NOKP'] ?? '-');
                $sheet->setCellValue('D' . $row, $fail['JAWATAN'] ?? '-');
                $sheet->setCellValue('E' . $row, $fail['BAHAGIAN_CAWANGAN'] ?? '-');
                $sheet->setCellValue('F' . $row, $fail['NOFAIL'] ?? '-');
                $sheet->setCellValue('G' . $row, $fail['NOJILID'] ?? '-');
                $sheet->setCellValue('H' . $row, $fail['STATUS'] ?? '-');
                $sheet->setCellValue('I' . $row, $fail['LOKASI_FAIL'] ?? '-');
    
                // Render columns based on fileType
                if ($fileType === 'baru' || $fileType === 'tutup') {
                    $sheet->setCellValue('J' . $row, $fileType === 'baru' ? ($fail['TARIKH'] ?? '-') : ($fail['TARIKHPPT'] ?? '-'));
                } elseif ($fileType === 'pinjam' || $fileType === 'pulang') {
                    $sheet->setCellValue('J' . $row, $fail['NAMAPENGGUNA'] ?? '-');
                    $sheet->setCellValue('K' . $row, $fail['phone'] ?? '-');
                    $sheet->setCellValue('L' . $row, $fail['email'] ?? '-');
                    $sheet->setCellValue('M' . $row, $fail['TARIKHPPT'] ?? '-');
                }
                $row++;
            }
        } else {
            $sheet->setCellValue('A5', 'Tiada data dijumpai.');
        }

        foreach (range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Set the header for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $reportTitle . '.xlsx"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        ob_start();
    
        // Write the file to output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        $output = ob_get_clean();
        header('Content-Length: ' . strlen($output));
        echo $output;
        exit();
    }

    public function laporanTkhBlnTbl()
    {
        $fileType = $this->request->getGet('fileType');
        $startDate = $this->request->getGet('start-date');
        $endDate = $this->request->getGet('end-date');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
    
        $failPeribadiModel = new failPeribadiModel();
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
    
        $query = null;
        $dateColumn = '';

        $malayMonths = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Mac',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Jun',
            '7' => 'Julai',
            '8' => 'Ogos',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember'
        ];
    
        if ($fileType === 'baru') {
            $query = $failPeribadiModel;
            $dateColumn = 'TARIKH';
        } elseif ($fileType === 'tutup') {
            $query = $failPeribadiPinjamModel->where('STATUS2', 'TUTUP');
            $dateColumn = 'TARIKHPPT';
        } elseif ($fileType === 'pinjam') {
            $query = $failPeribadiPinjamModel->where('STATUS2', 'DIPINJAM');
            $dateColumn = 'TARIKHPPT';
        } elseif ($fileType === 'pulang') {
            $query = $failPeribadiPinjamModel->where('STATUS2', 'DIPULANG');
            $dateColumn = 'TARIKHPPT';
        }
    
        $reportTitle = '';
        $dateDetails = '';
    
        if ($query) {
            if ($startDate && $endDate) {
                $query = $query->where("$dateColumn >=", $startDate)
                               ->where("$dateColumn <=", $endDate);
                $reportTitle = "Laporan Mengikut Tarikh Fail " . ucfirst($fileType) . " (Fail Peribadi)";
                $dateDetails = "Tarikh: $startDate hingga $endDate";
            } elseif ($month && $year) {
                if ($month == 13) {
                    $query = $query->where("YEAR($dateColumn)", $year);
                    $reportTitle = "Laporan Tahunan Fail " . ucfirst($fileType) . " (Fail Peribadi)";
                    $dateDetails = "Tahun: $year (Semua Bulan)";
                } else {
                    $query = $query->where("MONTH($dateColumn)", $month)
                                   ->where("YEAR($dateColumn)", $year);
                    $monthName = $malayMonths[$month];
                    $reportTitle = "Laporan Bulanan Fail " . ucfirst($fileType) . " (Fail Peribadi)";
                    $dateDetails = "$monthName $year";
                }
            } else {
                $reportTitle = "Laporan Fail " . ucfirst($fileType) . " (Fail Peribadi)";
            }
    
            $query = $query->orderBy($dateColumn, 'ASC');
        }
    
        $failPeribadiData = $query ? $query->findAll() : [];

        $recordsPerPdfPage = 14; // Adjust based on layout
        $totalPdfPages = ceil(count($failPeribadiData) / $recordsPerPdfPage);

        if (empty($failPeribadiData)) {
            session()->setFlashdata('statustkhblnfp', 'Tiada data dijumpai');
        }

        return view('/failPeribadi/laporanTkhBlnTbl', [
            'failPeribadiData' => $failPeribadiData,
            'fileType' => $fileType,
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'totalPdfPages' => $totalPdfPages,
            'recordsPerPdfPage' => $recordsPerPdfPage
        ]);
    }

    public function laporanSttsPmnjm()
    {
        return view('/failPeribadi/laporanSttsPmnjm');
    }

    public function laporanSttsPmnjmTblPDF()
    {
        $dompdf = new Dompdf();
    
        // Get the data passed via POST
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
        $failPeribadiPinjamData = json_decode($this->request->getPost('failPeribadiPinjamData'), true);
        $pdfPageRange = $this->request->getPost('pdfPageRange');
        $recordsPerPdfPage = 14;

        list($startPage, $endPage) = explode('-', $pdfPageRange);
        $startRecord = ($startPage - 1) * $recordsPerPdfPage;
        $endRecord = $endPage * $recordsPerPdfPage;

        $failPeribadiPinjamData = array_slice($failPeribadiPinjamData, $startRecord, $endRecord - $startRecord + 1);

        $startingNumber = $startRecord + 1;
    
        // Load the PDF view and pass data to it
        $html = view('failPeribadi/pdf/laporanSttsPmnjmTblPdf', [
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'fileType' => $fileType,
            'failPeribadiPinjamData' => $failPeribadiPinjamData,
            'startingNumber' => $startingNumber
        ]);
    
        // Render the HTML into a PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
    
        // Output the generated PDF
        $dompdf->stream($reportTitle . '.pdf', ['Attachment' => true]);
    }

    public function laporanSttsPmnjmTblExcel()
    {
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
        $failPeribadiPinjamData = json_decode($this->request->getPost('failPeribadiPinjamData'), true);

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getProperties()->setTitle($reportTitle);

        // Set the title and header rows
        $sheet->setCellValue('A1', 'Sistem Pengurusan Fail (SPF)');
        $sheet->setCellValue('A2', $reportTitle);
        $sheet->setCellValue('A3', $dateDetails);

        // Header row
        $sheet->setCellValue('A5', 'No.');
        $sheet->setCellValue('B5', 'Nama Peminjam');
        $sheet->setCellValue('C5', 'Telefon');
        $sheet->setCellValue('D5', 'Email');
        $sheet->setCellValue('E5', 'Nama Fail');
        $sheet->setCellValue('F5', 'No. KP');
        $sheet->setCellValue('G5', 'No. Fail');
        $sheet->setCellValue('H5', 'No. Jilid');
        $sheet->setCellValue('I5', 'Tarikh Pinjam');

        // Populate the data rows
        if (!empty($failPeribadiPinjamData)) {
            $row = 6; // Starting row for data
            foreach ($failPeribadiPinjamData as $index => $fail) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $fail['NAMAPENGGUNA'] ?? '-');
                $sheet->setCellValue('C' . $row, $fail['phone'] ?? '-');
                $sheet->setCellValue('D' . $row, $fail['email'] ?? '-');
                $sheet->setCellValue('E' . $row, $fail['NAMA'] ?? '-');
                $sheet->setCellValue('F' . $row, $fail['NOKP'] ?? '-');
                $sheet->setCellValue('G' . $row, $fail['NOFAIL'] ?? '-');
                $sheet->setCellValue('H' . $row, $fail['NOJILID'] ?? '-');
                $sheet->setCellValue('I' . $row, $fail['TARIKHPPT'] ?? '-');
                $row++;
            }
        }

        // Set auto width for each column
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Send the Excel file to the browser for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $reportTitle . ' ' . $dateDetails . '.xlsx"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        ob_start();

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $output = ob_get_clean();
        header('Content-Length: ' . strlen($output));
        echo $output;
        exit();
    }

    public function laporanSttsPmnjmTbl()
    {
        ini_set('max_execution_time', 300); // Ensure script has 5 minutes to run
    
        // Get the values from GET parameters (passed from frontend)
        $fileType = $this->request->getGet('fileType');
        $startDate = $this->request->getGet('start-date');
        $endDate = $this->request->getGet('end-date');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
    
        // Initialize the model
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $failPeribadiPinjamData = [];  // Initialize variable
    
        $query = null;
        $dateColumn = 'TARIKHPPT';
    
        $malayMonths = [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Mac', '4' => 'April',
            '5' => 'Mei', '6' => 'Jun', '7' => 'Julai', '8' => 'Ogos',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'
        ];
    
        $reportTitle = '';
        $dateDetails = '';

        function setDateAndTitle(
            &$query, 
            &$dateDetails, 
            &$fileType, 
            &$reportTitle, 
            $dateColumn, 
            $startDate, 
            $endDate, 
            $month, 
            $year, 
            $malayMonths
        ): void {
            if ($startDate && $endDate) {
                $query->where("$dateColumn >=", $startDate)
                      ->where("$dateColumn <=", $endDate);
                $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Mengikut Tarikh (Fail Peribadi)";
                $dateDetails = "Tarikh: $startDate hingga $endDate";
            } elseif ($month && $year) {
                if ($month == 13) {
                    $query->where("YEAR($dateColumn)", $year);
                    $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Tahunan (Fail Peribadi)";
                    $dateDetails = "Tahun: $year (Semua Bulan)";
                } else {
                    $query->where("MONTH($dateColumn)", $month)
                          ->where("YEAR($dateColumn)", $year);
                    $monthName = $malayMonths[$month];
                    $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Bulanan (Fail Peribadi)";
                    $dateDetails = "$monthName $year";
                }
            } else {
                $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Keseluruhan (Fail Peribadi)";
            }
        
            $query->orderBy('NAMAPENGGUNA', 'ASC')
                  ->orderBy('TARIKHPPT', 'ASC');
        }
    
        if ($fileType === 'peminjam') {
            $query = $failPeribadiPinjamModel->where('STATUS2', 'DIPINJAM')
                                             ->where("NAMAPENGGUNA !=",'-')
                                             ->where("$dateColumn IS NOT NULL")
                                             ->where("$dateColumn !=", '-');
                                             
            setDateAndTitle($query, $dateDetails, $fileType, $reportTitle, $dateColumn, $startDate, $endDate, $month, $year, $malayMonths);
    
            $failPeribadiPinjamData = $query->findAll();
        } elseif ($fileType === 'peminjamLewat') {
            $query = $failPeribadiPinjamModel->where('STATUS2', 'DIPINJAM')
                                             ->where("NAMAPENGGUNA !=", '-')
                                             ->where("$dateColumn IS NOT NULL")
                                             ->where("$dateColumn !=", '-');
        
            setDateAndTitle($query, $dateDetails, $fileType, $reportTitle, $dateColumn, $startDate, $endDate, $month, $year, $malayMonths);
        
            // Execute the query to get records with STATUS2 = DIPINJAM
            $failPeribadiPinjamData = $query->findAll();
            $filteredData = [];
        
            foreach ($failPeribadiPinjamData as $borrowedRecord) {
                $borrowedDate = $borrowedRecord['TARIKHPPT'];
                $nokp = $borrowedRecord['NOKP'];
                $nama = $borrowedRecord['NAMA'];
                $jilid = $borrowedRecord['NOJILID'];
                $namapengguna = $borrowedRecord['NAMAPENGGUNA'];
                $phone = $borrowedRecord['phone'];
                $email = $borrowedRecord['email'];
        
                $returnedRecord = $failPeribadiPinjamModel
                    ->where('STATUS2', 'DIPULANG')
                    ->where('NOKP', $nokp)
                    ->where('NAMA', $nama)
                    ->where('NOJILID', $jilid)
                    ->where('NAMAPENGGUNA', $namapengguna)
                    ->where('phone', $phone)
                    ->where('email', $email)
                    ->where('TARIKHPPT >', $borrowedDate)
                    ->orderBy('TARIKHPPT', 'ASC')
                    ->first();
        
                if ($returnedRecord) {
                    $returnedDate = $returnedRecord['TARIKHPPT'];
                    $dateDiff = (new \DateTime($returnedDate))->diff(new \DateTime($borrowedDate))->days;
        
                    if ($dateDiff > 30) {
                        // Store the borrowed date and other relevant details
                        $borrowedRecord['TARIKHPPT'] = $borrowedDate;
                        $filteredData[] = $borrowedRecord;
                    }
                } else {
                    // No returned record, check difference with current date
                    $currentDate = new \DateTime();
                    $dateDiff = $currentDate->diff(new \DateTime($borrowedDate))->days;
        
                    if ($dateDiff > 30) {
                        $borrowedRecord['TARIKHPPT'] = $borrowedDate;
                        $filteredData[] = $borrowedRecord;
                    }
                }
            }
        
            $failPeribadiPinjamData = $filteredData; // Replace with filtered data
        }        
    
        $recordsPerPdfPage = 14; // Adjust based on layout
        $totalPdfPages = ceil(count($failPeribadiPinjamData) / $recordsPerPdfPage);
        
        if (empty($failPeribadiPinjamData)) {
            session()->setFlashdata('statuspmnjmtblfp', 'Tiada data dijumpai');
        }

        return view('/failPeribadi/laporanSttsPmnjmTbl', [
            'failPeribadiPinjamData' => $failPeribadiPinjamData,
            'fileType' => $fileType,
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'totalPdfPages' => $totalPdfPages,
            'recordsPerPdfPage' => $recordsPerPdfPage
        ]);
    }
    
    
}