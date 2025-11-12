<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2><?php if ($failPeribadiPinjam != null) { ?>
                        <?php if ($failPeribadiPinjam['STATUS2'] == 'DIPINJAM') { ?>
                            Pulang Fail Peribadi
                        <?php } else if ($failPeribadiPinjam['STATUS2'] == 'DIPULANG') { ?>
                            Pinjam / Tutup Fail Peribadi
                        <?php } else { ?>
                            Pinjam Fail Peribadi
                        <?php } ?>
                    <?php } else { ?>
                        Pinjam / Tutup Fail Peribadi
                    <?php } ?><a href="<?= base_url('failPeribadi/pinjam') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
                </h2>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <strong>Nama Fail:</strong> <?= $failPeribadiPinjam['NAMA'] ?>
                        </div>
                        <div class="col-md-4">
                            <strong>No. Fail:</strong> <?= $failPeribadiPinjam['NOFAIL'] ?>
                        </div>
                        <div class="col-md-4">
                            <strong>No. Jilid:</strong> <?= $failPeribadiPinjam['NOJILID'] ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="row g-3" action="<?= base_url('failPeribadi/updatePinjamPulang/'.$failPeribadiPinjam['id']) ?>" method="POST">
                    <input type="hidden" name="_method" value="PUT"/>
                        <?php if ($failPeribadiPinjam != null) { ?>
                            <input type="hidden" name="NOKP" value="<?= $failPeribadiPinjam['NOKP'] ?>">
                            <input type="hidden" name="NOFAIL" value="<?= $failPeribadiPinjam['NOFAIL'] ?>">
                            <input type="hidden" name="NOJILID" value="<?= $failPeribadiPinjam['NOJILID'] ?>">
                        <?php } else { ?>
                            <input type="hidden" name="NOKP" value="<?= $NOKP ?>">
                            <input type="hidden" name="NOFAIL" value="<?= $NOFAIL ?>">
                            <input type="hidden" name="NOJILID" value="<?= $NOJILID ?>">
                        <?php } ?>
                        <div class="form-group mb-2">
                            <label>Nama</label>
                            <select name="NAMAPENGGUNA" id="NAMAPENGGUNA" class="form-select">
                                <option value="" disabled selected>Pilih Nama Peminjam</option>
                                <?php
                                usort($peminjam, function($a, $b) {
                                    return strcasecmp($a['user'], $b['user']);
                                });
                                foreach ($peminjam as $NamaPeminjam) { ?>
                                    <option value="<?= $NamaPeminjam['user'] ?>" <?= ($failPeribadiPinjam != null && $failPeribadiPinjam['NAMAPENGGUNA'] == $NamaPeminjam['user']) ? 'selected' : '' ?>>
                                        <?= $NamaPeminjam['user'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tarikh Pinjam / Pulang <span>*</span></label>
                            <div class="input-group">
                                <?php if ($failPeribadiPinjam != null) { ?>
                                    <input type="date" name="TARIKHPPT" id="TARIKHPPT" class="form-control" value="<?= $failPeribadiPinjam['TARIKHPPT'] ?>" required>
                                <?php } else { ?>
                                    <input type="date" name="TARIKHPPT" id="TARIKHPPT" class="form-control" required>
                                <?php } ?>
                                <button type="button" class="btn btn-outline-secondary" id="resetDateButton" >X</button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status <span>*</span></label>
                            <select name="STATUS2" id="STATUS2" class="form-select" onchange="updateNamaOptions()" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <?php if ($failPeribadiPinjam != null) { ?>
                                    <option value="DIPINJAM" <?= ($failPeribadiPinjam['STATUS2'] == 'DIPINJAM') ? 'selected' : '' ?>>DIPINJAM</option>
                                    <option value="DITUTUP" <?= ($failPeribadiPinjam['STATUS2'] == 'DITUTUP') ? 'selected' : '' ?>>DITUTUP</option>
                                    <option value="DIPULANG" <?= ($failPeribadiPinjam['STATUS2'] == 'DIPULANG') ? 'selected' : '' ?>>DIPULANG</option>
                                    <option value="DILUPUS" <?= ($failPeribadiPinjam['STATUS2'] == 'DILUPUS') ? 'selected' : '' ?>>DILUPUS</option>
                                <?php } else { ?>
                                    <option value="DIPINJAM">DIPINJAM</option>
                                    <option value="DITUTUP">DITUTUP</option>
                                <?php } ?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var originalOptions = $('#NAMAPENGGUNA').html();
    var lastSelectedNama = '';

    $(document).ready(function(){

        $('#NAMAPENGGUNA').change(function() {
            lastSelectedNama = $(this).val();
        });

        $('#resetDateButton').on('click', function() {
            $('#TARIKHPPT').val('');
        });
        $('#NAMAPENGGUNA').select2({
            allowClear: true 
        });
    });

    function updateNamaOptions() {
        var status = document.getElementById('STATUS2').value;
        var namaPengguna = document.getElementById('NAMAPENGGUNA');

        if (status === 'DITUTUP' || status === 'DILUPUS') {
            namaPengguna.innerHTML = '<option value="" disabled selected></option>';
        } else {
            namaPengguna.innerHTML = originalOptions;
            if (lastSelectedNama !== '') {
                $('#NAMAPENGGUNA').val(lastSelectedNama);
            }
        }
    }
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
