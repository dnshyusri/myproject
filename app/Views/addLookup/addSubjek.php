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
                    <h2>Tambah Subjek</h2>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="<?= base_url('addLookup/addSubjek') ?>" method="POST">
                        <div class="form-group col-md-4">
                            <label>Kod Subjek</label>
                            <input type="number" name="KodSubjek" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Subjek</label>
                            <input type="text" name="SUBJEK" class="form-control" id="subjekInput">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Abjad</label>
                            <input type="text" name="ABJAD" class="form-control" id="abjadInput" readonly>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get references to the input fields
        const subjekInput = document.getElementById('subjekInput');
        const abjadInput = document.getElementById('abjadInput');

        // Add event listener to the Subjek input to update Abjad automatically
        subjekInput.addEventListener('input', function() {
            const subjekValue = subjekInput.value.trim();
            // If the Subjek input has a value, set Abjad to the first character
            if (subjekValue.length > 0) {
                abjadInput.value = subjekValue.charAt(0).toUpperCase();
            } else {
                abjadInput.value = ''; // Reset Abjad if Subjek is empty
            }
        });
    });
</script>
<?= $this->endSection() ?>
