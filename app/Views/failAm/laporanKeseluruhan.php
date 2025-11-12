<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
        <h1 class="text-center">Sistem Pengurusan Fail (SPF)</h1>
        <h2 class="text-center margin-top-bottom">Laporan keseluruhan fail am</h2>
            <div class="table-responsive">
                <table class="table table-striped" id="table1">
                    <thead class="table">
                        <tr>
                            <th>Bulan</th>
                            <th>Fail Baru</th>
                            <th>Fail Tutup</th>
                            <th>Fail Dipinjamkan</th>
                            <th>Fail Dipulangkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $months = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Mac', 4 => 'April', 
                            5 => 'Mei', 6 => 'Jun', 7 => 'Julai', 8 => 'Ogos', 
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Disember'
                        ];

                        foreach ($months as $index => $month): ?>
                        <tr>
                            <td><?= $month ?></td>
                            <td><?= $failBaru[$index] ?></td>
                            <td><?= $failTutup[$index] ?></td>
                            <td><?= $failPinjam[$index] ?></td>
                            <td><?= $failPulang[$index] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="export-button-container">
                    <button id="export-pdf" class="btn btn-danger" onclick="window.location='<?= site_url('/failAm/laporanKeseluruhanPDF') ?>'" aria-label="Export to PDF">
                        <i class="fas fa-file-pdf"></i> Eksport ke PDF
                    </button>
                    <button id="export-excel" class="btn btn-success" onclick="window.location='<?= site_url('/failAm/laporanKeseluruhanExcel') ?>'" aria-label="Export to Excel">
                        <i class="fas fa-file-excel"></i> Eksport ke Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    table th, td {
        vertical-align: top;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .custom-margin {
        margin-top: 75px;
        margin-bottom: 25px;
    }
    .text-center {
        text-align: center;
    }
    .margin-top-bottom {
        margin: 0 0 20px; /* Adjust the values as needed */
    }
    .print-button-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px; /* Adjust spacing as needed */
    }
    h1 {
        text-decoration: underline;
    }
    @media print {
        /* Hide the print button when printing */
        #print-btn {
            display: none;
        }

        .navbar {
            display: none;
        }

        /* Ensure the table fits the width of the page */
        .table-responsive {
            overflow: visible;
        }
    }

    .export-button-container {
        display: flex;
        justify-content: center; /* Center aligns the buttons */
        gap: 10px; /* Optional: Adds space between buttons */
    }
</style>

<?= $this->endSection() ?>
