<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Pengguna Sistem</h2>
                    <div class="card-body">
                    <form class="row g-3" action="<?= base_url('/registerUser') ?>" method="post">
                    <div class="form-group col-md-6">
                        <label>ID</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Katalaluan</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Emel</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jenis</label>
                        <select name="jenis" id="jenis" class="form-select" required>
                            <option value="" disabled selected>Pilih jenis</option>
                            <option value="Pengguna">Pengguna</option>
                            <option value="Pentadbir (Administrator)">Pentadbir (Administrator)</option>
                        </select>
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