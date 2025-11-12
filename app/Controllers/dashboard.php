<?php

namespace App\Controllers;

use App\Models\failAmModel;
use App\Models\failPeribadiModel;
use App\Models\failAmPinjamModel;
use App\Models\failPeribadiPinjamModel;

class dashboard extends BaseController
{
    public function index()
    {
        $failAmModel = new failAmModel();
        $failPeribadiModel = new failPeribadiModel();
        $failAmPinjamModel = new failAmPinjamModel();
        $failPeribadiPinjamModel = new failPeribadiPinjamModel();
        $monthsMalay = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Mac',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Jun',
            'July' => 'Julai',
            'August' => 'Ogos',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Disember'
        ];
        $currentYear = date('Y');
    
        $monthlyBukaFailAmCounts = [];
        $monthlyBukaFailPeribadiCounts = [];
        $monthlyFailAmPinjamCounts = [];
        $monthlyFailPeribadiPinjamCounts = [];
        $monthlyTutupFailAmCounts = [];
        $monthlyTutupFailPeribadiCounts = [];
        $monthlyFailAmPulangCounts = [];
        $monthlyFailPeribadiPulangCounts = [];
    
        for ($month = 1; $month <= 12; $month++) {
            $monthlyBukaFailAmCounts[] = $failAmModel->where('MONTH(tkhBuka)', $month)
                                                 ->where('YEAR(tkhBuka)', $currentYear)
                                                 ->countAllResults();
    
            $monthlyBukaFailPeribadiCounts[] = $failPeribadiModel->where('MONTH(TARIKH)', $month)
                                                             ->where('YEAR(TARIKH)', $currentYear)
                                                             ->countAllResults();
                                                             
            $monthlyFailAmPinjamCounts[] = $failAmPinjamModel->where('MONTH(TARIKHPPT)', $month)
                                                             ->where('YEAR(TARIKHPPT)', $currentYear)
                                                             ->where('Status', 'DIPINJAM')
                                                             ->countAllResults();
    
            $monthlyFailPeribadiPinjamCounts[] = $failPeribadiPinjamModel->where('MONTH(TARIKHPPT)', $month)
                                                                         ->where('YEAR(TARIKHPPT)', $currentYear)
                                                                         ->where('STATUS2', 'DIPINJAM')
                                                                         ->countAllResults();
            
            $monthlyTutupFailAmCounts[] = $failAmModel->where('MONTH(tkhTutup)', $month)
                                                     ->where('YEAR(tkhTutup)', $currentYear)
                                                     ->countAllResults();
                            
            $monthlyTutupFailPeribadiCounts[] = $failPeribadiPinjamModel->where('MONTH(TARIKHPPT)', $month)
                                                                 ->where('YEAR(TARIKHPPT)', $currentYear)
                                                                 ->where('STATUS2', 'TUTUP')
                                                                 ->countAllResults();

            $monthlyFailAmPulangCounts[] = $failAmPinjamModel->where('MONTH(TARIKHPPT)', $month)
                                                                         ->where('YEAR(TARIKHPPT)', $currentYear)
                                                                         ->where('Status', 'DIPULANG')
                                                                         ->countAllResults();
                                                                         
            $monthlyFailPeribadiPulangCounts[] = $failPeribadiPinjamModel->where('MONTH(TARIKHPPT)', $month)
                                                                         ->where('YEAR(TARIKHPPT)', $currentYear)
                                                                         ->where('STATUS2', 'DIPULANG')
                                                                         ->countAllResults();
        }

        $latestFailAm = $failAmModel->orderBy('ID', 'DESC')->findAll(5);
        $latestFailAmPinjam = $failAmPinjamModel->orderBy('ID', 'DESC')->findAll(5);

        $latestFailPeribadi = $failPeribadiModel->orderBy('id', 'DESC')->findAll(5);
        $latestFailPeribadiPinjam = $failPeribadiPinjamModel->orderBy('id', 'DESC')->findAll(5);
    
        $currentMonth = $monthsMalay[date('F')];

        return view('dashboard', [
            'failBukaFailAm' => end($monthlyBukaFailAmCounts),
            'failBukaFailPeribadi' => end($monthlyBukaFailPeribadiCounts),
            'failTutupFailAm' => end($monthlyTutupFailAmCounts),
            'failTutupFailPeribadi' => end($monthlyTutupFailPeribadiCounts),
            'failAmPinjam' => end($monthlyFailAmPinjamCounts), 
            'failPeribadiPinjam' => end($monthlyFailPeribadiPinjamCounts),  
            'failAmPulang' => end($monthlyFailAmPulangCounts),
            'failPeribadiPulang' => end($monthlyFailPeribadiPulangCounts),
            'currentMonth' => $currentMonth,
            'monthlyBukaFailAmCounts' => $monthlyBukaFailAmCounts,
            'monthlyBukaFailPeribadiCounts' => $monthlyBukaFailPeribadiCounts,
            'monthlyTutupFailAmCounts' => $monthlyTutupFailAmCounts,
            'monthlyTutupFailPeribadiCounts' => $monthlyTutupFailPeribadiCounts,
            'monthlyFailAmPinjamCounts' => $monthlyFailAmPinjamCounts,
            'monthlyFailPeribadiPinjamCounts' => $monthlyFailPeribadiPinjamCounts,
            'monthlyFailAmPulangCounts' => $monthlyFailAmPulangCounts,
            'monthlyFailPeribadiPulangCounts' => $monthlyFailPeribadiPulangCounts,
            'latestFailAm' => $latestFailAm,
            'latestFailAmPinjam' => $latestFailAmPinjam,
            'latestFailPeribadi' => $latestFailPeribadi,
            'latestFailPeribadiPinjam' => $latestFailPeribadiPinjam,
        ]);
    }
}
?>