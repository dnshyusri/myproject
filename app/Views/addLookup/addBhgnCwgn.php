<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <?php 
                if(session()->getFlashdata('status'))
                {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?= session()->getFlashdata('status'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                }
            ?>
            <div class="card">
                <div class="card-header">
                    <h2>Tambah Bahagian / Cawangan</h2>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="<?= base_url('addLookup/addBhgnCwgn') ?>" method="POST">
                        <div class="form-group col-md-12">
                            <label>Bahagian / Cawangan</label>
                            <input type="text" name="Bhgn_cwgn" class="form-control" id="bhgnCwgnInput">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>
<style>
    .custom-margin {
        margin-top: 75px;
        margin-bottom: 25px;
    }
</style>
<?= $this->endSection() ?>
