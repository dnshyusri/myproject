<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="d-flex justify-content-end">
        <a href="<?= base_url('failAm/laporanTkhBln') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statustkhblnfa'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('statustkhblnfa'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <h1 class="text-center">Sistem Pengurusan Fail (SPF)</h1>
            <!-- Display the dynamic report title based on fileType and date selection -->
            <h2 class="text-center margin-top-bottom"><?= $reportTitle ?></h2>
            <!-- Display start/end date or month/year details based on the user's selection -->
            <?php if (!empty($dateDetails)): ?>
                <h5 class="text-center"><?= $dateDetails ?></h5>
            <?php endif; ?>
            <?php if (!empty($failAmData)): ?>
                
            <div class="export-button-wrapper">
                <form method="post" action="<?= site_url('/failAm/laporanTkhBlnTblPDF') ?>" id="export-form">
                    <input type="hidden" name="reportTitle" value="<?= $reportTitle ?>">
                    <input type="hidden" name="dateDetails" value="<?= $dateDetails ?>">
                    <input type="hidden" name="fileType" value="<?= $fileType ?>">

                    <!-- Pass the table data in JSON format -->
                    <textarea name="failAmData" hidden><?= json_encode($failAmData) ?></textarea>

                    <!-- Flex container for button and export options -->
                    <div class="export-button-options-container">
                        <div class="export-button-container">
                            <button id="export-pdf" class="btn btn-danger" aria-label="Export to PDF">
                                <i class="fas fa-file-pdf"></i> Eksport ke PDF
                            </button>
                        </div>
                        <div class="export-options">
                            <label for="pdfPageRange">Pilih Halaman PDF:</label>
                            <select name="pdfPageRange" id="pdfPageRange">
                                <?php for ($i = 1; $i <= $totalPdfPages; $i += 25): ?>
                                    <?php 
                                        $endPage = min($i + 24, $totalPdfPages); 
                                        $pageRange = "$i-$endPage";
                                    ?>
                                    <option value="<?= $pageRange ?>">Halaman <?= $pageRange ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </form>
                <form method="post" action="<?= site_url('/failAm/laporanTkhBlnTblExcel') ?>" id="export-form">
                    <input type="hidden" name="reportTitle" value="<?= $reportTitle ?>">
                    <input type="hidden" name="dateDetails" value="<?= $dateDetails ?>">
                    <input type="hidden" name="fileType" value="<?= $fileType ?>">

                    <!-- Pass the table data in JSON format -->
                    <textarea name="failAmData" hidden><?= json_encode($failAmData) ?></textarea>

                    <div class="export-button-container">
                        <button id="export-excel" class="btn btn-success" aria-label="Export to Excel">
                            <i class="fas fa-file-excel"></i> Eksport ke Excel
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead class="table">
                        <tr>
                            <th>No.</th>
                            <th>Kod Subjek</th>
                            <th>Subjek Utama</th>
                            <th>Bil.</th>
                            <th>Tajuk Fail</th>
                            <th>Rujukan Fail Lama</th>
                            <th>Rujukan Fail Baru</th>
                            <th>No. Jilid</th>
                            <th>Lokasi Fail</th>
                            <!-- Display additional columns based on fileType -->
                            <?php if ($fileType === 'baru' || $fileType === 'tutup'): ?>
                                <th>Tarikh <?= $fileType === 'baru' ? 'Buka' : 'Tutup' ?></th>
                            <?php elseif ($fileType === 'pinjam' || $fileType === 'pulang'): ?>
                                <th>Nama Peminjam</th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Tarikh <?= $fileType === 'pinjam' ? 'Pinjam' : 'Pulang' ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($failAmData)): ?>
                            <?php foreach ($failAmData as $index => $fail): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $fail['KodSubjek'] ?? '-' ?></td>
                                    <td><?= $fail['Subjek'] ?? '-' ?></td>
                                    <td><?= $fail['Bil'] ?? '-' ?></td>
                                    <td><?= $fail['TajukFail'] ?? '-' ?></td>
                                    <td><?= $fail['RujukFailLama'] ?? '-' ?></td>
                                    <td><?= $fail['RujukFailBaru'] ?? '-' ?></td>
                                    <td><?= $fail['Jilid'] ?? '-' ?></td>
                                    <td><?= $fail['LokasiFail'] ?? '-' ?></td>
                                    <!-- Render columns based on fileType -->
                                    <?php if ($fileType === 'baru' || $fileType === 'tutup'): ?>
                                        <td><?= $fileType === 'baru' ? ($fail['tkhBuka'] ?? '-') : ($fail['tkhTutup'] ?? '-') ?></td>
                                    <?php elseif ($fileType === 'pinjam' || $fileType === 'pulang'): ?>
                                        <td><?= $fail['NamaPinjamPulang'] ?? '-' ?></td>
                                        <td><?= $fail['phone'] ?? '-' ?></td>
                                        <td><?= $fail['email'] ?? '-' ?></td>
                                        <td><?= $fail['TARIKHPPT'] ?? '-' ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <?php if ($fileType === 'baru' || $fileType === 'tutup'): ?>
                                    <td></td>
                                <?php elseif ($fileType === 'pinjam' || $fileType === 'pulang'): ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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

    .container {
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .table-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    /* Print Styles */
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
        @page {
            size: A4 landscape; /* Set page size to A4 landscape */
            margin: 10mm; /* Adjust margins as needed */
        }
    }
    .export-button-wrapper {
        display: flex;
        justify-content: center; /* Center-aligns the buttons */
        gap: 10px; /* Space between buttons */
    }

    .export-button-wrapper form {
        display: inline-block; /* Keeps each form inline */
        margin: 0; /* Removes any default margin */
    }
    .export-button-options-container {
        display: flex;
        align-items: center;
    }

    .export-button-container, .export-options {
        margin-right: 10px;
    }

</style>

<?= $this->endSection() ?>
