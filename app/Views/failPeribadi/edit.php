<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Kemaskini Fail Peribadi
                        <a href="<?= base_url('failPeribadi') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
                    </h2>
                    <div class="card-body">
                        <form class="row g-3" action="<?= base_url('failPeribadi/update/'.$failPeribadi['id']) ?>" method="POST">
                            <input type="hidden" name="_method" value="PUT"/>
                            <div class="form-group mb-2">
                                <label>Nama <span>*</span></label>
                                <input type="text" name="NAMA" value="<?= $failPeribadi['NAMA']?>" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>No. Kad Pengenalan <span>*</span></label>
                                <input type="text" name="NOKP" value="<?= $failPeribadi['NOKP']?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label>Jawatan (<?= $failPeribadi['JAWATAN'] ?>)<span>*</span></label>
                                <select name="JAWATAN" id="JAWATAN" class="form-select" required>
                                    <option value="" disabled selected></option>
                                    <?php foreach ($jawatan as $jwtn): ?>
                                        <option value="<?= $jwtn['jawatan'] ?>" <?= ($failPeribadi['JAWATAN'] == $jwtn['jawatan']) ? 'selected' : '' ?>>
                                            <?= $jwtn['jawatan'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label>Bahagian / Cawangan (<?= $failPeribadi['BAHAGIAN_CAWANGAN'] ?>)<span>*</span></label>
                                <select name="BAHAGIAN_CAWANGAN" id="BAHAGIAN_CAWANGAN" class="form-select" required>
                                    <option value="" disabled selected></option>
                                    <?php foreach ($bhgnCwgn as $bhgn): ?>
                                        <option value="<?= $bhgn['Bhgn_cwgn'] ?>" <?= ($failPeribadi['BAHAGIAN_CAWANGAN'] == $bhgn['Bhgn_cwgn']) ? 'selected' : '' ?>>
                                            <?= $bhgn['Bhgn_cwgn'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>No. Fail <span>*</span></label>
                                <input type="text" name="NOFAIL" value="<?= $failPeribadi['NOFAIL']?>" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>No. Jilid <span>*</span></label>
                                <input type="text" name="NOJILID" value="<?= $failPeribadi['NOJILID']?>" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tarikh <span>*</span></label>
                                <div class="input-group">
                                    <input type="date" name="TARIKH" id="TARIKH" value="<?= $failPeribadi['TARIKH']?>" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" id="resetDateButton" >X</button>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Status Aktif <span>*</span></label>
                                <select name="STATUS" id="STATUS" class="form-select" required>
                                    <option value="T/AKTIF" <?= ($failPeribadi['STATUS'] == 'T/AKTIF') ? 'selected' : '' ?>>T/AKTIF</option>
                                    <option value="AKTIF" <?= ($failPeribadi['STATUS'] == 'AKTIF') ? 'selected' : '' ?>>AKTIF</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Lokasi Simpanan Fail <span>*</span></label>
                                <select name="LOKASI_FAIL" id="LOKASI_FAIL" class="form-select" required>
                                    <?php foreach ($lokasiFail as $lokasi) { ?>
                                        <option value="<?= $lokasi['Lokasi_Fail'] ?>" <?= ($failPeribadi['LOKASI_FAIL'] == $lokasi['Lokasi_Fail']) ? 'selected' : '' ?>>
                                            <?= $lokasi['Lokasi_Fail'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Catatan</label>
                                <input type="text" name="CATITAN" value="<?= $failPeribadi['CATITAN']?>" class="form-control">
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
