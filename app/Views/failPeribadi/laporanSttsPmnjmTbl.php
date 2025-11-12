<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="d-flex justify-content-end">
        <a href="<?= base_url('failPeribadi/laporanSttsPmnjm') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statuspmnjmtblfp'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('statuspmnjmtblfp'); ?>
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
            <?php if (!empty($failPeribadiPinjamData)): ?>
            <div class = "export-button-wrapper">
                <form method="post" action="<?= site_url('/failPeribadi/laporanSttsPmnjmTblPDF') ?>" id="export-form">
                    <input type="hidden" name="reportTitle" value="<?= $reportTitle ?>">
                    <input type="hidden" name="dateDetails" value="<?= $dateDetails ?>">
                    <input type="hidden" name="fileType" value="<?= $fileType ?>">

                    <!-- Pass the table data in JSON format -->
                    <textarea name="failPeribadiPinjamData" hidden><?= json_encode($failPeribadiPinjamData) ?></textarea>

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
                <!-- Export to Excel form -->
                <form method="post" action="<?= site_url('/failPeribadi/laporanSttsPmnjmTblExcel') ?>" id="export-form">
                    <input type="hidden" name="reportTitle" value="<?= $reportTitle ?>">
                    <input type="hidden" name="dateDetails" value="<?= $dateDetails ?>">
                    <input type="hidden" name="fileType" value="<?= $fileType ?>">

                    <!-- Pass the table data in JSON format -->
                    <textarea name="failPeribadiPinjamData" hidden><?= json_encode($failPeribadiPinjamData) ?></textarea>

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
                            <th>Nama Peminjam</th>
                            <th>Telefon</th>
                            <th>Email</th>
                            <th>Nama Fail</th>
                            <th>No. KP</th>
                            <th>No. Fail</th>
                            <th>No. Jilid</th>
                            <th>Tarikh Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($failPeribadiPinjamData)): ?>
                            <?php foreach ($failPeribadiPinjamData as $index => $fail): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $fail['NAMAPENGGUNA'] ?? '-' ?></td>
                                    <td><?= $fail['phone'] ?? '-' ?></td>
                                    <td><?= $fail['email'] ?? '-' ?></td>
                                    <td><?= $fail['NAMA'] ?? '-' ?></td>
                                    <td><?= $fail['NOKP'] ?? '-' ?></td>
                                    <td><?= $fail['NOFAIL'] ?? '-' ?></td>
                                    <td><?= $fail['NOJILID'] ?? '-' ?></td>
                                    <td><?= $fail['TARIKHPPT'] ?? '-' ?></td>
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
