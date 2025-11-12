<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Fail Peribadi Baru
                        <a href="<?= base_url('failPeribadi') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
                    </h2>
                    <div class="card-body">
                        <form class="row g-3" action="<?= base_url('failPeribadi/add') ?>" method="POST">
                            <div class="form-group mb-2">
                                <label>Nama <span>*</span></label>
                                <input type="text" name="NAMA" class="form-control text-uppercase" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>No. Kad Pengenalan <span>*</span></label>
                                <input type="text" name="NOKP" class="form-control text-uppercase" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Jawatan <span>*</span></label>
                                <select name="JAWATAN" id="JAWATAN" class="form-select" required>
                                    <option value="" disabled selected></option>
                                    <?php foreach ($jawatan as $jwtn): ?>
                                        <option value="<?= $jwtn['jawatan'] ?>"><?= $jwtn['jawatan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label>Bahagian / Cawangan <span>*</span></label>
                                <select name="BAHAGIAN_CAWANGAN" id="BAHAGIAN_CAWANGAN" class="form-select" required>
                                    <option value="" disabled selected></option>
                                    <?php foreach ($bhgnCwgn as $bhgn): ?>
                                        <option value="<?= $bhgn['Bhgn_cwgn'] ?>"><?= $bhgn['Bhgn_cwgn'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>No. Fail <span>*</span></label>
                                <input type="text" name="NOFAIL" class="form-control text-uppercase" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>No. Jilid<span>*</span></label>
                                <input type="text" name="NOJILID" class="form-control text-uppercase" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tarikh <span>*</span></label>
                                <div class="input-group">
                                    <input type="date" name="TARIKH" id="TARIKH" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" id="resetDateButton" >X</button>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Status Aktif <span>*</span></label>
                                <select name="STATUS" id="STATUS" class="form-select" required>
                                    <option value="" disabled selected></option>
                                    <option value="T/AKTIF">T/AKTIF</option>
                                    <option value="AKTIF">AKTIF</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Lokasi Simpanan Fail <span>*</span></label>
                                <select name="LOKASI_FAIL" id="LOKASI_FAIL" class="form-select" required>
                                    <option value="" disabled selected></option>
                                    <?php foreach ($lokasiFail as $lokasi): ?>
                                        <option value="<?= $lokasi['Lokasi_Fail'] ?>"><?= $lokasi['Lokasi_Fail'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Catatan</label>
                                <input type="text" name="CATITAN" class="form-control text-uppercase">
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
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        // Automatically capitalize letters as user types
        $('input[type="text"]').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        });
        $('#resetDateButton').on('click', function() {
            $('#TARIKH').val('');
        });
        $('#JAWATAN').select2({
            allowClear: true 
        });
        $('#BAHAGIAN_CAWANGAN').select2({
            allowClear: true 
        });
    });

    <?php if (session()->getFlashdata('error')): ?>
        alert('<?= session()->getFlashdata('error') ?>');
    <?php endif; ?>
</script>
<style>
    .custom-margin {
        margin-top: 75px;
        margin-bottom: 25px;
    }
    label span {
        color: red;
    }
</style>
<?= $this->endSection() ?>
