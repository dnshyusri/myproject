<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Daftar Fail Am Baru
                        <a href="<?= base_url('failAm') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
                    </h2>
                    <div class="card-body">
                        <form class="row g-3" action="<?= base_url('failAm/add') ?>" method="POST" onsubmit="return validateForm()">
                            <h5>Maklumat Utama Fail Am</h5>
                            <div class="form-group col-md-4">
                                <label>Kategori Mengikut Abjad <span>*</span></label>
                                <select name="Abjad" id="Abjad" class="form-select" required>
                                    <option value="" disabled selected>Pilih Abjad</option>
                                    <?php foreach (range('A', 'Z') as $letter): ?>
                                        <option value="<?= $letter ?>"><?= $letter ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kod Subjek</label>
                                <input type="number" name="KodSubjek" id="KodSubjek" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Bil <span>*</span></label>
                                <input type="number" name="Bil" id="Bil" class="form-control" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Subjek Utama <span>*</span></label>
                                <select name="Subjek" id="Subjek" class="form-select" required>
                                    <option value="" disabled selected>Pilih Subjek</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Tajuk Fail <span>*</span></label>
                                <input type="text" name="TajukFail" class="form-control" required>
                            </div>
                            <h5>Maklumat Fail Am</h5>
                            <div class="form-group col-md-4">
                                <label>Rujukan Fail Lama</label>
                                <input type="text" name="RujukFailLama" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Rujukan Fail Baru <span>*</span></label>
                                <input type="text" name="RujukFailBaru" class="form-control" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Jilid <span>*</span></label>
                                <input type="number" name="Jilid" id="Jilid" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tarikh Buka <span>*</span></label>
                                <div class="input-group">
                                    <input type="date" id = "tkhBuka" name="tkhBuka" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" id="resetDateButton1" >X</button>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tarikh Tutup</label>
                                <div class="input-group">
                                    <input type="date" id = "tkhTutup" name="tkhTutup" class="form-control">
                                    <button type="button" class="btn btn-outline-secondary" id="resetDateButton2" >X</button>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tarikh Kandungan Pertama</label>
                                <div class="input-group">
                                    <input type="date" id = "tkhkandungtama" name="tkhkandungtama" class="form-control">
                                    <button type="button" class="btn btn-outline-secondary" id="resetDateButton3" >X</button>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Tarikh Kandungan Akhir</label>
                                <div class="input-group">
                                    <input type="date" id = "tkhkandungakhir" name="tkhkandungakhir" class="form-control">
                                    <button type="button" class="btn btn-outline-secondary" id="resetDateButton4" >X</button>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label>Lokasi Simpanan Fail <span>*</span></label>
                                <select name="LokasiFail" id="LokasiFail" class="form-select" required>
                                    <option value="" disabled selected>Pilih Lokasi Fail</option>
                                    <?php foreach ($lokasiFail as $lokasi): ?>
                                        <option value="<?= $lokasi['Lokasi_Fail'] ?>"><?= $lokasi['Lokasi_Fail'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Catatan</label>
                                <input type="text" name="Catatan" class="form-control">
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

        $('input[type="text"]').on('input', function(){
            $(this).val($(this).val().toUpperCase());
        });
        
        $('#Abjad').change(function(){
            var abjad = $(this).val();
            $.ajax({
                url: '<?= base_url('failAm/filter') ?>',
                type: 'POST',
                data: {abjad: abjad},
                dataType: 'json',
                success: function(response){
                    $('#Subjek').empty().append('<option value="" disabled selected>Pilih Subjek</option>');
                    $.each(response, function(index, subjek){
                        $('#Subjek').append('<option value="'+subjek.SUBJEK+'">'+subjek.SUBJEK+'</option>');
                    });
                }
            });
        });
        $('#Subjek').change(function(){
            var subjek = $(this).val();
            $.ajax({
                url: '<?= base_url('failAm/getKodSubjek') ?>',
                type: 'POST',
                data: {subjek: subjek},
                dataType: 'json',
                success: function(response){
                    if (response.KodSubjek) {
                        $('#KodSubjek').val(response.KodSubjek);
                    } else {
                        $('#KodSubjek').val('');
                    }
                }
            });
        });
        $('#resetDateButton1').on('click', function() {
            $('#tkhBuka').val('');
        });
        $('#resetDateButton2').on('click', function() {
            $('#tkhTutup').val('');
        });
        $('#resetDateButton3').on('click', function() {
            $('#tkhkandungtama').val('');
        });
        $('#resetDateButton4').on('click', function() {
            $('#tkhkandungakhir').val('');
        });
        $('#Abjad').select2({
            allowClear: true 
        });
        $('#Subjek').select2({
            allowClear: true 
        });
    });

    function validateForm() {
        var bil = document.getElementById("Bil").value;
        var jilid = document.getElementById("Jilid").value;

        if (bil < 0) {
            alert('Bil tidak sah. Bil tidak boleh kurang daripada 0.');
            return false;
        }

        if (jilid < 0) {
            alert('Jilid tidak sah. Jilid tidak boleh kurang daripada 0.');
            return false;
        }

        return true;
    }

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
