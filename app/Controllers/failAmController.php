<?php namespace App\Controllers;

use App\Models\failAmModel;
use App\Models\subjekFailAmModel;
use App\Models\lokasiModel;
use App\Models\failAmPinjamModel;
use App\Models\peminjamModel;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;

class failAmController extends BaseController{
    public function index()
    {
        $model = new failAmModel();
        $data['failAm'] = $model->findAll();
        return view('failAm/index', $data);
    }

    public function add()
    {
        $model = new lokasiModel();
        $data['lokasiFail'] = $model->findAll();
        return view('failAm/add', $data);
    }

    public function store()
    {
        $model = new failAmModel();
    
        $rujukFailBaru = trim($this->request->getPost('RujukFailBaru'));
        $kodSubjek = $this->request->getPost('KodSubjek');
        $jilid = $this->request->getPost('Jilid');
    
        // Check for existing combination of KodSubjek, RujukFailBaru, and Jilid
        $existingRecord = $model->where([
            'KodSubjek' => $kodSubjek,
            'RujukFailBaru' => $rujukFailBaru,
            'Jilid' => $jilid
        ])->first();
    
        if ($existingRecord) {
            // Pass the error message back to the view
            return redirect()->back()->withInput()->with('error', 'Maklumat fail tidak sah kerana mempunyai kod subjek, rujuk fail baru dan jilid yang sama.');
        }
    
        // Get or generate RujukFailBaruID
        $existingData = $model->where('RujukFailBaru', $rujukFailBaru)->first();
        if ($existingData) {
            $rujukFailBaruID = $existingData['RujukFailBaruID'];
        } else {
            $lastEntry = $model->orderBy('RujukFailBaruID', 'DESC')->first();
            $lastID = $lastEntry ? intval($lastEntry['RujukFailBaruID']) : 0;
            $rujukFailBaruID = $lastID + 1;
        }
    
        $data = [
            'Abjad' => $this->request->getPost('Abjad'),
            'KodSubjek' => $kodSubjek,
            'Subjek' => $this->request->getPost('Subjek'),
            'Bil' => $this->request->getPost('Bil'),
            'TajukFail' => $this->request->getPost('TajukFail'),
            'RujukFailLama' => $this->request->getPost('RujukFailLama') ?? '-',
            'RujukFailBaru' => $rujukFailBaru,
            'RujukFailBaruID' => $rujukFailBaruID,
            'Jilid' => $jilid,
            'tkhBuka' => $this->request->getPost('tkhBuka'),
            'tkhTutup' => $this->request->getPost('tkhTutup') ?? date('0000-00-00'),
            'tkhkandungtama' => $this->request->getPost('tkhkandungtama') ?? date('0000-00-00'),
            'tkhkandungakhir' => $this->request->getPost('tkhkandungakhir') ?? date('0000-00-00'),
            'LokasiFail' => $this->request->getPost('LokasiFail'),
            'Catatan' => $this->request->getPost('Catatan') ?? '-',
        ];
    
        // Save the data
        $model->save($data);
    
        return redirect()->to('failAm')->with('statusindexfa', 'Fail am berjaya dimasukkan');
    }

    public function filter()
    {
        $abjad = $this->request->getPost('abjad');
        $model = new subjekFailAmModel();
        $subjects = $model->where('ABJAD', $abjad)->findAll();

        return $this->response->setJSON($subjects);
    }

    public function getKodSubjek()
    {
        $subjek = $this->request->getPost('subjek');
        $model = new subjekFailAmModel();
        $result = $model->getKodSubjekBySubjek($subjek);

        if ($result) {
            return $this->response->setJSON(['KodSubjek' => $result['KodSubjek']]);
        }

        return $this->response->setJSON(['error' => 'No data found'])->setStatusCode(404);
    }

    public function edit($id)
    {
        $failAmModel = new failAmModel();
        $lokasiModel = new lokasiModel();

        $data['failAm'] = $failAmModel->find($id);
        $data['lokasiFail'] = $lokasiModel->findAll();

        return view('failAm/edit', $data);
    }

    public function update($id)
    {
        $failAmModel = new failAmModel();
    
        // Get the form inputs
        $kodSubjek = $this->request->getPost('KodSubjek');
        $rujukFailBaru = trim($this->request->getPost('RujukFailBaru'));
        $jilid = $this->request->getPost('Jilid');
    
        // Check for duplicate combination of KodSubjek, RujukFailBaru, and Jilid
        $existingRecord = $failAmModel->where([
            'KodSubjek' => $kodSubjek,
            'RujukFailBaru' => $rujukFailBaru,
            'Jilid' => $jilid,
        ])
        ->where('id !=', $id) // Exclude the current record from the check
        ->first();
    
        if ($existingRecord) {
            // Redirect back with error message
            return redirect()->back()->withInput()->with('error', 'Maklumat fail tidak sah kerana mempunyai kod subjek, rujuk fail baru dan jilid yang sama.');
        }
    
        // Determine RujukFailBaruID logic
        $existingOriginalRecord = $failAmModel->find($id);
        if ($existingOriginalRecord['RujukFailBaru'] != $rujukFailBaru) {
            $existingData = $failAmModel->where('RujukFailBaru', $rujukFailBaru)->first();
            if ($existingData) {
                $rujukFailBaruID = $existingData['RujukFailBaruID'];
            } else {
                $lastEntry = $failAmModel->orderBy('RujukFailBaruID', 'DESC')->first();
                $lastID = $lastEntry ? intval($lastEntry['RujukFailBaruID']) : 0;
                $rujukFailBaruID = $lastID + 1;
            }
        } else {
            $rujukFailBaruID = $existingOriginalRecord['RujukFailBaruID'];
        }
    
        // Prepare the data for update
        $data = [
            'Abjad' => $this->request->getPost('Abjad'),
            'KodSubjek' => $kodSubjek,
            'Subjek' => $this->request->getPost('Subjek'),
            'Bil' => $this->request->getPost('Bil'),
            'TajukFail' => $this->request->getPost('TajukFail'),
            'RujukFailLama' => $this->request->getPost('RujukFailLama') ?? '-',
            'RujukFailBaru' => $rujukFailBaru,
            'RujukFailBaruID' => $rujukFailBaruID,
            'Jilid' => $jilid,
            'tkhBuka' => $this->request->getPost('tkhBuka'),
            'tkhTutup' => $this->request->getPost('tkhTutup') ?? date('0000-00-00'),
            'tkhkandungtama' => $this->request->getPost('tkhkandungtama') ?? date('0000-00-00'),
            'tkhkandungakhir' => $this->request->getPost('tkhkandungakhir') ?? date('0000-00-00'),
            'LokasiFail' => $this->request->getPost('LokasiFail'),
            'Catatan' => $this->request->getPost('Catatan') ?? '-',
        ];
    
        // Update the record in the database
        $failAmModel->update($id, $data);
    
        // Redirect with success message
        return redirect()->to(base_url('failAm'))->with('statusindexfa', 'Fail am berjaya dikemaskini!');
    }

    public function delete($id)
    {
        $failAmModel = new failAmModel();
        $failAmModel->delete($id);
        return;
    }

    public function pinjam()
    {
        $model = new failAmModel();
        $data['failAm'] = $model->findAll();
        return view('/failAm/pinjam', $data);
    }

    public function getDetails($kodsubjek, $rujukfailbaruid, $jilid)
    {
        
        $model = new failAmPinjamModel();

        // Find all records based on KodSubjek, Bil, and Jilid, ordered by TARIKHPPT in descending order
        $fileDetails = $model->where([
            'KodSubjek' => $kodsubjek,
            'RujukFailBaruID' => $rujukfailbaruid,
            'Jilid' => $jilid
        ])
        ->orderBy("STR_TO_DATE(TARIKHPPT, '%d/%m/%Y') DESC")
        ->findAll(); // Return all records instead of just the first one

        if ($fileDetails) {
            return $this->response->setJSON($fileDetails); // Return all file details
        }

        // Return error if no data is found
        return $this->response->setJSON(['error' => 'No data found'])->setStatusCode(404);
    }
    
    public function pinjamPulang($kodsubjek, $rujukfailbaruid, $jilid)
    {
        
        $failAmModel = new failAmModel();
        $failAmPinjamModel = new failAmPinjamModel();
        $peminjamModel = new peminjamModel();

        // Fetch specific record based on KodSubjek, RujukFailBaruID, and Jilid
        $data['failAm'] = $failAmModel->where([
            'KodSubjek' => $kodsubjek,
            'RujukFailBaruID' => $rujukfailbaruid,
            'Jilid' => $jilid
        ])->first();  // Fetch one record based on filters

        // Fetch the latest borrowing record based on the highest ID (the latest entry)
        $data['failAmPinjam'] = $failAmPinjamModel->where([
            'KodSubjek' => $kodsubjek,
            'RujukFailBaruID' => $rujukfailbaruid,
            'Jilid' => $jilid
        ])->orderBy('ID', 'DESC')->first();  // Order by ID to get the latest entry

        // Fetch all the borrowers (for the dropdown list)
        $data['peminjam'] = $peminjamModel->findAll();

        // Pass the KodSubjek, rujukfailbaruid, and jilid for future use in the form
        $data['kodsubjek'] = $kodsubjek;
        $data['rujukfailbaruid'] = $rujukfailbaruid;
        $data['jilid'] = $jilid;

        return view('failAm/pinjamPulang', $data);
    }

    public function editPinjamPulang($id)
    {
        $failAmPinjamModel = new failAmPinjamModel();
        $peminjamModel = new peminjamModel();

        $data['failAmPinjam'] = $failAmPinjamModel->find($id);
        $data['peminjam'] = $peminjamModel->findAll();

        return view('failAm/editPinjamPulang', $data);
    }

    public function updatePinjamPulang($id)
    {
        $failAmPinjamModel = new failAmPinjamModel();
        $data = [
            'NamaPinjamPulang'=> $this->request->getPost('NamaPinjamPulang'),
            'TARIKHPPT'=> $this->request->getPost('TARIKHPPT'),
            'Status'=> $this->request->getPost('Status'),
        ];
        $failAmPinjamModel->update($id, $data);
        return redirect()->to(base_url('failAm/pinjam'))->with('statuspinjamfa','Data pinjam fail am berjaya dikemaskini!');
    }

    public function deletePinjamPulang($id)
    {
        $failAmPinjamModel = new failAmPinjamModel();
        $result = $failAmPinjamModel->delete($id);

        if ($result) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }


    public function addPinjamPulang()
    {
        $failAmModel = new failAmModel();
        $failAmPinjamModel = new failAmPinjamModel();
        $peminjamModel = new peminjamModel();
    
        // Retrieve POST data
        $kodsubjek = $this->request->getPost('kodsubjek');
        $rujukfailbaruid = $this->request->getPost('rujukfailbaruid');
        $jilid = $this->request->getPost('jilid');
        $NamaPinjamPulang = $this->request->getPost('NamaPinjamPulang');
        $TARIKHPPT = $this->request->getPost('TARIKHPPT');
        $Status = $this->request->getPost('Status');
    
        // Fetch borrower details
        $namaPeminjam = $peminjamModel->where('user', $NamaPinjamPulang)->first();
        $phone = $namaPeminjam['phone'] ?? '';
        $email = $namaPeminjam['email'] ?? '';
    
        // Retrieve existing data
        $existingData = $failAmModel->where(['KodSubjek' => $kodsubjek, 'RujukFailBaruID' => $rujukfailbaruid, 'Jilid' => $jilid])->first();
    
        if ($existingData) {
            // Merge POST data with existing data
            $data = array_merge($existingData, [
                'NamaPinjamPulang' => $NamaPinjamPulang,
                'TARIKHPPT' => $TARIKHPPT,
                'Status' => $Status,
                'phone' => $phone,
                'email' => $email,
            ]);
    
            // Insert updated data
            $failAmPinjamModel->insert($data);
    
            // Set status message
            $message = match ($Status) {
                'DIPINJAM' => 'Fail berjaya dipinjam',
                'DIPULANG' => 'Fail berjaya dipulang',
                'DITUTUP' => 'Fail berjaya ditutup',
                'DILUPUS' => 'Fail berjaya dilupus',
                default => 'Status tidak dikenali',
            };
    
            // Redirect to the appropriate page with the status message
            return redirect()->to('/failAm/pinjam/')->with('statuspinjamfa', $message);
        } else {
            // Handle case where existing data is not found
            return redirect()->to('/failAm/pinjam/')->with('statuspinjamfa', 'Data tidak dijumpai');
        }
    }
    
    public function laporanKeseluruhanData()
    {
        $failAmModel = new failAmModel();
        $failAmPinjamModel = new failAmPinjamModel();
    
        // Query for Fail Baru (new files opened)
        $failBaru = $failAmModel->select("MONTH(tkhBuka) as bulan, COUNT(*) as jumlah_baru")
                                ->where("tkhBuka IS NOT NULL")
                                ->groupBy("MONTH(tkhBuka)")
                                ->findAll();
    
        // Query for Fail Tutup (files closed)
        $failTutup = $failAmModel->select("MONTH(tkhTutup) as bulan, COUNT(*) as jumlah_tutup")
                                 ->where("tkhTutup IS NOT NULL")
                                 ->groupBy("MONTH(tkhTutup)")
                                 ->findAll();

        $failPinjam = $failAmPinjamModel->select("MONTH(TARIKHPPT) as bulan, COUNT(*) as jumlah_pinjam")
                                        ->where("TARIKHPPT IS NOT NULL")
                                        ->where("Status", "DIPINJAM")
                                        ->groupBy("MONTH(TARIKHPPT)")
                                        ->findAll();
        
        $failPulang = $failAmPinjamModel->select("MONTH(TARIKHPPT) as bulan, COUNT(*) as jumlah_pulang")
                                        ->where("TARIKHPPT IS NOT NULL")
                                        ->where("Status", "DIPULANG")
                                        ->groupBy("MONTH(TARIKHPPT)")
                                        ->findAll();
    
        // Initialize arrays to hold data for all months (1 to 12)
        $failBaruCounts = array_fill(1, 12, 0);
        $failTutupCounts = array_fill(1, 12, 0);
        $failPinjamCounts = array_fill(1, 12, 0);
        $failPulangCounts = array_fill(1, 12, 0);
    
        // Fill the arrays with the counts from the queries
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
    
        // Pass the data to the view
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
        $html = view('failAm/pdf/laporanKeseluruhanPdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Laporan Keseluruhan Fail Am.pdf", ["Attachment" => true]);
    }
    
    public function laporanKeseluruhanExcel()
    {
        $data = $this->laporanKeseluruhanData();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()->setTitle('Laporan Keseluruhan Fail Am');

        // Add a title
        $sheet->setCellValue('A1', 'Laporan Keseluruhan Fail Am');

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
        $filename = 'Laporan Keseluruhan Fail Am.xlsx';
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

        return view('failAm/laporanKeseluruhan', $data);
    }
    
    public function laporanTkhBln()
    {
        return view('/failAm/laporanTkhBln');
    }

    public function getAvailableYears()
    {
        $failAmModel = new failAmModel();
        $failAmPinjamModel = new failAmPinjamModel();
        $fileType = $this->request->getGet('fileType'); // Get file type parameter from AJAX request
    
        $years = [];
        if ($fileType == 'baru') {
            $years = $failAmModel->select("YEAR(tkhBuka) as year")
                ->where('tkhBuka IS NOT NULL')
                ->where('YEAR(tkhBuka) !=', 0) // Exclude year = 0
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        } elseif ($fileType == 'tutup') {
            $years = $failAmModel->select("YEAR(tkhTutup) as year")
                ->where('tkhTutup IS NOT NULL')
                ->where('YEAR(tkhTutup) !=', 0) // Exclude year = 0
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        } elseif ($fileType == 'pinjam' || $fileType == 'peminjam' || $fileType == 'peminjamLewat') {
            $years = $failAmPinjamModel->select("YEAR(TARIKHPPT) as year")
                ->where('TARIKHPPT IS NOT NULL')
                ->where('YEAR(TARIKHPPT) !=', 0) // Exclude year = 0
                ->where('Status', 'DIPINJAM')
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        } elseif ($fileType == 'pulang') {
            $years = $failAmPinjamModel->select("YEAR(TARIKHPPT) as year")
                ->where('TARIKHPPT IS NOT NULL')
                ->where('YEAR(TARIKHPPT) !=', 0) // Exclude year = 0
                ->where('Status', 'DIPULANG')
                ->groupBy('year')
                ->orderBy('year', 'ASC')
                ->findAll();
        }
    
        // Return a JSON response containing the available years
        return $this->response->setJSON($years);
    }    

    public function laporanTkhBlnTbl()
    {
        // Get the values from GET parameters (passed from frontend)
        $fileType = $this->request->getGet('fileType');
        $startDate = $this->request->getGet('start-date');
        $endDate = $this->request->getGet('end-date');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');
    
        // Initialize the model
        $failAmModel = new FailAmModel();
        $failAmPinjamModel = new FailAmPinjamModel();
    
        // Initialize the query based on fileType
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
    
        // Define failAmData array to store query results
        if ($fileType === 'baru') {
            $dateColumn = 'tkhBuka';
            $query = $failAmModel->where("$dateColumn IS NOT NULL")
                                 ->where("$dateColumn !=", '-');
        } elseif ($fileType === 'tutup') {
            $dateColumn = 'tkhTutup';
            $query = $failAmModel->where("$dateColumn IS NOT NULL")
                                 ->where("$dateColumn !=", '-');
        } elseif ($fileType === 'pinjam') {
            $dateColumn = 'TARIKHPPT';
            $query = $failAmPinjamModel->where('Status', 'DIPINJAM')
                                       ->where("$dateColumn IS NOT NULL")
                                       ->where("$dateColumn !=", '-');
        } elseif ($fileType === 'pulang') {
            $dateColumn = 'TARIKHPPT';
            $query = $failAmPinjamModel->where('Status', 'DIPULANG')
                                       ->where("$dateColumn IS NOT NULL")
                                       ->where("$dateColumn !=", '-');
        }
        
    
        // Apply the date or month and year filter to the query
        if ($query) {
            if ($startDate && $endDate) {
                // Filter based on start date and end date
                $query = $query->where("$dateColumn >=", $startDate)
                               ->where("$dateColumn <=", $endDate);
                // Set the title for the report based on date range
                $reportTitle = "Laporan Mengikut Tarikh Fail " . ucfirst($fileType) . " (Fail Am)";
                $dateDetails = "Tarikh: $startDate hingga $endDate";
            } elseif ($month && $year) {
                if ($month == 13) {
                    // Filter only based on the year
                    $query = $query->where("YEAR($dateColumn)", $year);
                    // Set the title for the report based on the year only
                    $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Tahunan (Fail Am)";
                    $dateDetails = "$year (Semua Bulan)";
                } else {
                // Filter based on the month and year
                    $query = $query->where("MONTH($dateColumn)", $month)
                                ->where("YEAR($dateColumn)", $year);
                    $monthName = $malayMonths[$month];
                    // Set the title for the report based on month and year
                    $reportTitle = "Laporan Bulanan Fail " . ucfirst($fileType) . " (Fail Am)";
                    $dateDetails = "$monthName $year";
                }
            } else {
                // Default title if no date or month/year is selected
                $reportTitle = "Laporan Fail " . ucfirst($fileType) . " (Fail Am)";
                $dateDetails = '';
            }
    
            // Sort by the date column
            $query = $query->orderBy($dateColumn, 'ASC');
        }
    
        // Fetch the filtered and sorted results
        $failAmData = $query ? $query->findAll() : [];

        $recordsPerPdfPage = 14; // Adjust based on layout
        $totalPdfPages = ceil(count($failAmData) / $recordsPerPdfPage);

        if (empty($failAmData)) {
            session()->setFlashdata('statustkhblnfa', 'Tiada data dijumpai');
        }

        // Pass the filtered and sorted data, reportTitle, and dateDetails to the view
        return view('/failAm/laporanTkhBlnTbl', [
            'failAmData' => $failAmData,
            'fileType' => $fileType,
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'totalPdfPages' => $totalPdfPages,
            'recordsPerPdfPage' => $recordsPerPdfPage
        ]);
    }

    public function laporanTkhBlnTblPDF()
    {
        // Load the required library for PDF generation
        $dompdf = new Dompdf();
    
        // Get the data passed via POST
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
        $failAmData = json_decode($this->request->getPost('failAmData'), true);
        $pdfPageRange = $this->request->getPost('pdfPageRange');
        $recordsPerPdfPage = 14;

        // Parse the selected page range (e.g., "1-50")
        list($startPage, $endPage) = explode('-', $pdfPageRange);
        $startRecord = ($startPage - 1) * $recordsPerPdfPage;
        $endRecord = $endPage * $recordsPerPdfPage;

        // Slice the data to the selected range
        $failAmData = array_slice($failAmData, $startRecord, $endRecord - $startRecord + 1);
    
        $startingNumber = $startRecord + 1;
        // Load the PDF view and pass data to it
        $html = view('failAm/pdf/laporanTkhBlnTblPdf', [
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'fileType' => $fileType,
            'failAmData' => $failAmData,
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
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
        $failAmData = json_decode($this->request->getPost('failAmData'), true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getProperties()->setTitle($reportTitle);
        $sheet->setCellValue('A1', $reportTitle);
        $sheet->setCellValue('A2', $dateDetails);

        $headers = [
            'No.', 'No. Fail', 'Subjek Utama', 'Bil.', 'Tajuk Fail',
            'Rujukan Fail Lama', 'Rujukan Fail Baru', 'No. Jilid', 'Lokasi Fail',
        ];

        if ($fileType === 'baru' || $fileType === 'tutup') {
            $headers[] = 'Tarikh ' . ($fileType === 'baru' ? 'Buka' : 'Tutup');
        } elseif ($fileType === 'pinjam' || $fileType === 'pulang') {
            array_push($headers, 'Nama Peminjam', 'Telefon', 'Email', 'Tarikh ' . ($fileType === 'pinjam' ? 'Pinjam' : 'Pulang'));
        }

        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '4', $header);
            $column++;
        }

        $row = 5;
        if (!empty($failAmData)) {
            foreach ($failAmData as $index => $fail) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $fail['KodSubjek'] ?? '-');
                $sheet->setCellValue('C' . $row, $fail['Subjek'] ?? '-');
                $sheet->setCellValue('D' . $row, $fail['Bil'] ?? '-');
                $sheet->setCellValue('E' . $row, $fail['TajukFail'] ?? '-');
                $sheet->setCellValue('F' . $row, $fail['RujukFailLama'] ?? '-');
                $sheet->setCellValue('G' . $row, $fail['RujukFailBaru'] ?? '-');
                $sheet->setCellValue('H' . $row, $fail['Jilid'] ?? '-');
                $sheet->setCellValue('I' . $row, $fail['LokasiFail'] ?? '-');
                if ($fileType === 'baru' || $fileType === 'tutup') {
                    $sheet->setCellValue('J' . $row, $fileType === 'baru' ? ($fail['tkhBuka'] ?? '-') : ($fail['tkhTutup'] ?? '-'));
                } elseif ($fileType === 'pinjam' || $fileType === 'pulang') {
                    $sheet->setCellValue('J' . $row, $fail['NamaPinjamPulang'] ?? '-');
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

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $reportTitle . '.xlsx"');
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

    public function laporanSttsPmnjm()
    {
        return view ('/failAm/laporanSttsPmnjm');
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
        $failAmPinjamModel = new failAmPinjamModel();
        $failAmPinjamData = [];  // Initialize variable
    
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
                $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Mengikut Tarikh (Fail Am)";
                $dateDetails = "Tarikh: $startDate hingga $endDate";
            } elseif ($month && $year) {
                if ($month == 13) {
                    $query->where("YEAR($dateColumn)", $year);
                    $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Tahunan (Fail Am)";
                    $dateDetails = "Tahun: $year (Semua Bulan)";
                } else {
                    $query->where("MONTH($dateColumn)", $month)
                          ->where("YEAR($dateColumn)", $year);
                    $monthName = $malayMonths[$month];
                    $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Bulanan (Fail Am)";
                    $dateDetails = "$monthName $year";
                }
            } else {
                $reportTitle = "Laporan Senarai " . ucfirst($fileType) . " Keseluruhan (Fail Am)";
            }
        
            $query->orderBy('NamaPinjamPulang', 'ASC')
                  ->orderBy('TARIKHPPT', 'ASC');
        }
        
    
        if ($fileType === 'peminjam') {
            $query = $failAmPinjamModel->where('Status', 'DIPINJAM')
                                       ->where("NamaPinjamPulang !=", '-')
                                       ->where("$dateColumn IS NOT NULL")
                                       ->where("$dateColumn !=", '-');

            setDateAndTitle($query, $dateDetails, $fileType, $reportTitle, $dateColumn, $startDate, $endDate, $month, $year, $malayMonths);
    
            $failAmPinjamData = $query->findAll();
        } elseif ($fileType === 'peminjamLewat') {
            $query = $failAmPinjamModel->where('Status', 'DIPINJAM')
                                       ->where("NamaPinjamPulang !=", '-')
                                       ->where("$dateColumn IS NOT NULL")
                                       ->where("$dateColumn !=", '-');
        
            setDateAndTitle($query, $dateDetails, $fileType, $reportTitle, $dateColumn, $startDate, $endDate, $month, $year, $malayMonths);
        
            // Execute the query to get records with Status = DIPINJAM
            $failAmPinjamData = $query->findAll();
            $filteredData = [];
        
            foreach ($failAmPinjamData as $borrowedRecord) {
                $borrowedDate = $borrowedRecord['TARIKHPPT'];
                $bil = $borrowedRecord['Bil'];
                $tajukFail = $borrowedRecord['TajukFail'];
                $jilid = $borrowedRecord['Jilid'];
                $nama = $borrowedRecord['NamaPinjamPulang'];
                $phone = $borrowedRecord['phone'];
                $email = $borrowedRecord['email'];
        
                $returnedRecord = $failAmPinjamModel
                    ->where('Status', 'DIPULANG')
                    ->where('Bil', $bil)
                    ->where('TajukFail', $tajukFail)
                    ->where('Jilid', $jilid)
                    ->where('NamaPinjamPulang', $nama)
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
        
            $failAmPinjamData = $filteredData; // Replace with filtered data
        }        
    
        $recordsPerPdfPage = 14; // Adjust based on layout
        $totalPdfPages = ceil(count($failAmPinjamData) / $recordsPerPdfPage);

        if (empty($failAmPinjamData)) {
            session()->setFlashdata('statuspmnjmtblfa', 'Tiada data dijumpai');
        }
    
        return view('/failAm/laporanSttsPmnjmTbl', [
            'failAmPinjamData' => $failAmPinjamData,
            'fileType' => $fileType,
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'totalPdfPages' => $totalPdfPages,
            'recordsPerPdfPage' => $recordsPerPdfPage
        ]);
    }
    
    public function laporanSttsPmnjmTblPDF()
    {
        $dompdf = new Dompdf();
    
        // Get the data passed via POST
        $reportTitle = $this->request->getPost('reportTitle');
        $dateDetails = $this->request->getPost('dateDetails');
        $fileType = $this->request->getPost('fileType');
        $failAmPinjamData = json_decode($this->request->getPost('failAmPinjamData'), true);
        $pdfPageRange = $this->request->getPost('pdfPageRange');
        $recordsPerPdfPage = 14;

        // Parse the selected page range (e.g., "1-50")
        list($startPage, $endPage) = explode('-', $pdfPageRange);
        $startRecord = ($startPage - 1) * $recordsPerPdfPage;
        $endRecord = $endPage * $recordsPerPdfPage;

        // Slice the data to the selected range
        $failAmPinjamData = array_slice($failAmPinjamData, $startRecord, $endRecord - $startRecord + 1);
    
        $startingNumber = $startRecord + 1;
        // Load the PDF view and pass data to it
        $html = view('failAm/pdf/laporanSttsPmnjmTblPdf', [
            'reportTitle' => $reportTitle,
            'dateDetails' => $dateDetails,
            'fileType' => $fileType,
            'failAmPinjamData' => $failAmPinjamData,
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
        $failAmPinjamData = json_decode($this->request->getPost('failAmPinjamData'), true);

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
        $sheet->setCellValue('E5', 'Tajuk Fail');
        $sheet->setCellValue('F5', 'No. Fail');
        $sheet->setCellValue('G5', 'No. Jilid');
        $sheet->setCellValue('H5', 'Tarikh Pinjam');

        // Populate the data rows
        if (!empty($failAmPinjamData)) {
            $row = 6; // Starting row for data
            foreach ($failAmPinjamData as $index => $fail) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $fail['NamaPinjamPulang'] ?? '-');
                $sheet->setCellValue('C' . $row, $fail['phone'] ?? '-');
                $sheet->setCellValue('D' . $row, $fail['email'] ?? '-');
                $sheet->setCellValue('E' . $row, $fail['TajukFail'] ?? '-');
                $sheet->setCellValue('F' . $row, $fail['KodSubjek'] ?? '-');
                $sheet->setCellValue('G' . $row, $fail['Jilid'] ?? '-');
                $sheet->setCellValue('H' . $row, $fail['TARIKHPPT'] ?? '-');
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

}
?>
