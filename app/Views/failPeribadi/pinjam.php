<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('statuspinjamfp'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?= session()->getFlashdata('statuspinjamfp'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h2>Pinjam / Pulang Fail Peribadi</h2>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableFP">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th style="width: 150px;">Nama</th>
                                        <th style="width: 120px;">No. KP</th>
                                        <th style="width: 150px;">Jawatan</th>
                                        <th style="width: 150px;">Bahagian / Cawangan</th>
                                        <th style="width: 100px;">No. Fail</th>
                                        <th style="width: 100px;">No. Jilid</th>
                                        <th style="width: 120px;">Tarikh</th>
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 200px;">Catatan</th>
                                        <th style="width: 150px;">Lokasi Fail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($failPeribadi): ?>
                                        <?php foreach ($failPeribadi as $row): ?>
                                            <tr class="clickable-row" data-id="<?= $row['id'] ?>" data-nokp="<?= $row['NOKP'] ?>" data-nofail="<?= $row['NOFAIL'] ?>" data-nojilid="<?= $row['NOJILID'] ?>">
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['NAMA']; ?></td>
                                                <td><?php echo $row['NOKP']; ?></td>
                                                <td><?php echo $row['JAWATAN']; ?></td>
                                                <td><?php echo $row['BAHAGIAN_CAWANGAN']; ?></td>
                                                <td><?php echo $row['NOFAIL']; ?></td>
                                                <td><?php echo $row['NOJILID']; ?></td>
                                                <td><?php echo $row['TARIKH']; ?></td>
                                                <td><?php echo $row['STATUS']; ?></td>
                                                <td><?php echo $row['CATITAN']; ?></td>
                                                <td><?php echo $row['LOKASI_FAIL']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="file-detailsFP-container" class="table-responsive mt-4" style="display: none;">
                            <h4>Butiran Fail</h4>
                            <table id="file-detailsFP" class="table table-hover table-striped">
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
                        <div id="file-detailsFP" class="container mt-4" style="display: none;"></div >
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