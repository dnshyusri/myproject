<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Kemaskini Peminjam</h2>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="<?= base_url('addLookup/updatePeminjam/'.$peminjam['ID']) ?>" method="POST">
                        <input type="hidden" name="_method" value="PUT"/>
                        <div class="form-group col-md-12">
                            <label>Nama</label>
                            <input type="text" name="user" value="<?= $peminjam['user']?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>No. Tel.</label>
                            <input type="number" name="phone" value="<?= $peminjam['phone']?>" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Emel</label>
                            <input type="text" name="email" value="<?= $peminjam['email']?>" class="form-control">
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
