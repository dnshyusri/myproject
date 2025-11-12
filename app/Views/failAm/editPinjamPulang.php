<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <h2><?php if ($failAmPinjam != null) { ?>
                        <?php if ($failAmPinjam['Status'] == 'DIPINJAM') { ?>
                            Pulang Fail Am
                        <?php } else if ($failAmPinjam['Status'] == 'DIPULANG') { ?>
                            Pinjam / Tutup Fail Am
                        <?php } else { ?>
                            Pinjam Fail Am
                        <?php } ?>
                    <?php } else { ?>
                        Pinjam / Tutup Fail Am
                    <?php } ?><a href="<?= base_url('failAm/pinjam') ?>" class="btn btn-danger btn-sm float-end">Kembali</a>
                </h2>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <strong>Tajuk Fail:</strong> <?= $failAmPinjam['TajukFail'] ?>
                        </div>
                        <div class="col-md-4">
                            <strong>No. Fail:</strong> <?= $failAmPinjam['RujukFailBaruID'] ?>
                        </div>
                        <div class="col-md-4">
                            <strong>No. Jilid:</strong> <?= $failAmPinjam['Jilid'] ?>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="row g-3" action="<?= base_url('failAm/updatePinjamPulang/'.$failAmPinjam['ID']) ?>" method="POST">
                    <input type="hidden" name="_method" value="PUT"/>
                        <?php if ($failAmPinjam != null) { ?>
                            <input type="hidden" name="kodSubjek" value="<?= $failAmPinjam['KodSubjek'] ?>">
                            <input type="hidden" name="rujukfailbaruid" value="<?= $failAmPinjam['RujukFailBaruID'] ?>">
                            <input type="hidden" name="jilid" value="<?= $failAmPinjam['Jilid'] ?>">
                        <?php } else { ?>
                            <input type="hidden" name="kodSubjek" value="<?= $kodSubjek ?>">
                            <input type="hidden" name="rujukfailbaruid" value="<?= $rujukfailbaruid ?>">
                            <input type="hidden" name="jilid" value="<?= $jilid ?>">
                        <?php } ?>
                        <div class="form-group mb-2">
                            <label>Nama</label>
                            <select name="NamaPinjamPulang" id="NamaPinjamPulang" class="form-select">
                                <?php
                                usort($peminjam, function($a, $b) {
                                    return strcasecmp($a['user'], $b['user']);
                                });
                                foreach ($peminjam as $NamaPeminjam) { ?>
                                    <option value="<?= $NamaPeminjam['user'] ?>" <?= ($failAmPinjam != null && $failAmPinjam['NamaPinjamPulang'] == $NamaPeminjam['user']) ? 'selected' : '' ?>>
                                        <?= $NamaPeminjam['user'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tarikh Pinjam / Pulang <span>*</span></label>
                            <div class="input-group">
                                <?php if ($failAmPinjam != null) { ?>
                                    <input type="date" name="TARIKHPPT" id="TARIKHPPT" class="form-control" value="<?= $failAmPinjam['TARIKHPPT'] ?>" required>
                                <?php } else { ?>
                                    <input type="date" name="TARIKHPPT" id="TARIKHPPT" class="form-control" required>
                                <?php } ?>
                                <button type="button" class="btn btn-outline-secondary" id="resetDateButton" >X</button>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status <span>*</span></label>
                            <select name="Status" id="Status" class="form-select" onchange="updateNamaOptions()" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <?php if ($failAmPinjam != null) { ?>
                                    <option value="DIPINJAM" <?= ($failAmPinjam['Status'] == 'DIPINJAM') ? 'selected' : '' ?>>DIPINJAM</option>
                                    <option value="DITUTUP" <?= ($failAmPinjam['Status'] == 'DITUTUP') ? 'selected' : '' ?>>DITUTUP</option>
                                    <option value="DIPULANG" <?= ($failAmPinjam['Status'] == 'DIPULANG') ? 'selected' : '' ?>>DIPULANG</option>
                                    <option value="DILUPUS" <?= ($failAmPinjam['Status'] == 'DILUPUS') ? 'selected' : '' ?>>DILUPUS</option>
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
    var originalOptions = $('#NamaPinjamPulang').html();
    var lastSelectedNama = '';

    $(document).ready(function(){
        $('#NamaPinjamPulang').change(function() {
            lastSelectedNama = $(this).val();
        });
        $('#resetDateButton').on('click', function() {
            $('#TARIKHPPT').val('');
        });
        $('#NamaPinjamPulang').select2({
            allowClear: true 
        });
    });

    function updateNamaOptions() {
        var status = document.getElementById('Status').value;
        var namaPengguna = document.getElementById('NamaPinjamPulang');

        if (status === 'DITUTUP' || status === 'DILUPUS') {
            namaPengguna.innerHTML = '<option value="" disabled selected></option>';
        } else {
            namaPengguna.innerHTML = originalOptions;
            if (lastSelectedNama !== '') {
                $('#NamaPinjamPulang').val(lastSelectedNama);
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
