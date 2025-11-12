<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statuspinjamfa'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?= session()->getFlashdata('statuspinjamfa'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h2>Pinjam / Pulang Fail Am</h2>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th style="width: 50px;">Abjad</th>
                                        <th style="width: 100px;">Kod Subjek</th>
                                        <th style="width: 150px;">Subjek</th>
                                        <th style="width: 100px;">Bil</th>
                                        <th style="width: 200px;">Tajuk Fail</th>
                                        <th style="width: 150px;">Rujuk Fail Lama</th>
                                        <th style="width: 150px;">Rujuk Fail Baru</th>
                                        <th style="width: 150px;">Rujuk Fail Baru ID</th>
                                        <th style="width: 100px;">Jilid</th>
                                        <th style="width: 140px;">Tarikh Buka</th>
                                        <th style="width: 140px;">Tarikh Tutup</th>
                                        <th style="width: 140px;">Tarikh Kandungan Pertama</th>
                                        <th style="width: 140px;">Tarikh Kandungan Akhir</th>
                                        <th style="width: 100px;">Lokasi Fail</th>
                                        <th style="width: 200px;">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($failAm): ?>
                                        <?php foreach ($failAm as $row): ?>
                                            <tr class="clickable-row" data-id="<?= $row['ID'] ?>" 
                                            data-kodsubjek="<?= $row['KodSubjek'] ?>" 
                                            data-rujukfailbaruid="<?= $row['RujukFailBaruID'] ?>" 
                                            data-jilid="<?= $row['Jilid'] ?>">
                                                <td><?php echo $row['ID']; ?></td>
                                                <td><?php echo $row['Abjad']; ?></td>
                                                <td><?php echo $row['KodSubjek']; ?></td>
                                                <td><?php echo $row['Subjek']; ?></td>
                                                <td><?php echo $row['Bil']; ?></td>
                                                <td><?php echo $row['TajukFail']; ?></td>
                                                <td><?php echo $row['RujukFailLama']; ?></td>
                                                <td><?php echo $row['RujukFailBaru']; ?></td>
                                                <td><?php echo $row['RujukFailBaruID']; ?></td>
                                                <td><?php echo $row['Jilid']; ?></td>
                                                <td><?php echo $row['tkhBuka']; ?></td>
                                                <td><?php echo $row['tkhTutup']; ?></td>
                                                <td><?php echo $row['tkhkandungtama']; ?></td>
                                                <td><?php echo $row['tkhkandungakhir']; ?></td>
                                                <td><?php echo $row['LokasiFail']; ?></td>
                                                <td><?php echo $row['Catatan']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="file-details-container" class="table-responsive mt-4" style="display: none;">
                            <h4>Butiran Fail</h4>
                            <table id="file-details" class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 150px;">Nama</th>
                                        <th style="width: 120px;">Tarikh</th>
                                        <th style="width: 100px;">No. telefon</th>
                                        <th style="width: 200px;">Emel</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows will be inserted here -->
                                </tbody>
                            </table>
                            <a id="pinjam-pulang-fp-btn" class="btn btn-primary" href="#" role="button">Pinjam / Pulang</a>
                        </div>
                        <div id="file-details" class="container mt-4" style="display: none;"></div >
                    </div>
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
    .clickable-row {
        cursor: pointer;
    }
</style>
<?= $this->endSection() ?>