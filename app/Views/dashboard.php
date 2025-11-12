<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <?php 
        if(session()->getFlashdata('success'))
        {
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
        }
    ?>
    <div class="row mb-4">
        <!-- Combined Fail Baru Card for Fail Am and Fail Peribadi -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Fail Baru (<?= $currentMonth ?>)</h5>
                    <p class="card-text">Fail Am = <?= $failBukaFailAm ?> &nbsp;&nbsp; Fail Peribadi = <?= $failBukaFailPeribadi ?></p>
                    <canvas id="combinedFailBaruGraph" width="300" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Fail Tutup (<?= $currentMonth ?>)</h5>
                    <p class="card-text">Fail Am = <?= $failTutupFailAm ?> &nbsp;&nbsp; Fail Peribadi = <?= $failTutupFailPeribadi ?></p>
                    <canvas id="combinedFailTutupGraph" width="300" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Combined Fail Pinjam Card for Fail Am and Fail Peribadi -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Fail Pinjam (<?= $currentMonth ?>)</h5>
                    <p class="card-text">Fail Am = <?= $failAmPinjam ?> &nbsp;&nbsp; Fail Peribadi = <?= $failPeribadiPinjam ?></p>
                    <canvas id="combinedFailPinjamGraph" width="300" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Combined Fail Pulang Card for Fail Am and Fail Peribadi -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Fail Pulang (<?= $currentMonth ?>)</h5>
                    <p class="card-text">Fail Am = <?= $failAmPulang ?> &nbsp;&nbsp; Fail Peribadi = <?= $failPeribadiPulang ?></p>
                    <canvas id="combinedFailPulangGraph" width="300" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 d-flex">
        <div class="col-md-6">
            <div class="card text-center h-100"> <!-- Add h-100 to make the card fill the height -->
                <div class="card-body">
                    <h5 class="card-title">Aktiviti Terkini Fail Am</h5>
                    <h6>Fail Am Buka</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No Fail</th>
                                <th>No Jilid</th>
                                <th>Tajuk Fail</th>
                                <th>Tarikh Buka</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestFailAm as $failAm): ?>
                                <tr>
                                    <td><?= $failAm['RujukFailBaru']; ?></td>
                                    <td><?= $failAm['Jilid']; ?></td>
                                    <td><?= $failAm['TajukFail']; ?></td>
                                    <td><?= $failAm['tkhBuka']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h6>Fail Am Pinjam, Pulang, Tutup</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No Fail</th>
                                <th>No Jilid</th>
                                <th>Tajuk Fail</th>
                                <th>Status</th>
                                <th>Tarikh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestFailAmPinjam as $failAmPinjam): ?>
                                <tr>
                                    <td><?= $failAmPinjam['RujukFailBaru']; ?></td>
                                    <td><?= $failAmPinjam['Jilid']; ?></td>
                                    <td><?= $failAmPinjam ['TajukFail']; ?></td>
                                    <td><?= $failAmPinjam['Status']; ?></td>
                                    <td><?= $failAmPinjam['TARIKHPPT']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center h-100"> <!-- Add h-100 to make the card fill the height -->
                <div class="card-body">
                    <h5 class="card-title">Aktiviti Terkini Fail Peribadi</h5>
                    <h6>Fail Peribadi Buka</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No Fail</th>
                                <th>No Jilid</th>
                                <th>Nama Fail</th>
                                <th>Tarikh Buka</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestFailPeribadi as $failPeribadi): ?>
                                <tr>
                                    <td><?= $failPeribadi['NOFAIL']; ?></td>
                                    <td><?= $failPeribadi['NOJILID']; ?></td>
                                    <td><?= $failPeribadi['NAMA']; ?></td>
                                    <td><?= $failPeribadi['TARIKH']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <h6>Fail Peribadi Pinjam, Pulang, Tutup</h6>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No Fail</th>
                                <th>No Jilid</th>
                                <th>Nama Fail</th>
                                <th>Status</th>
                                <th>Tarikh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestFailPeribadiPinjam as $failPeribadiPinjam): ?>
                                <tr>
                                    <td><?= $failPeribadiPinjam['NOFAIL']; ?></td>
                                    <td><?= $failPeribadiPinjam['NOJILID']; ?></td>
                                    <td><?= $failPeribadiPinjam['NAMA']; ?></td>
                                    <td><?= $failPeribadiPinjam['STATUS2']; ?></td>
                                    <td><?= $failPeribadiPinjam['TARIKHPPT']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
    .card {
        height: auto; /* Allows the card to grow with the content */
    }
    table.table-striped th,
    table.table-striped td {
        text-align: left;
    }
</style>

<script src="<?= base_url('assets/js/Chart.min.js') ?>"></script>
<script>
    const currentYear = new Date().getFullYear();

    // Data for Combined Fail Baru Graph
    const combinedFailBaruCtx = document.getElementById('combinedFailBaruGraph').getContext('2d');
    const combinedFailBaruData = {
        labels: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
        datasets: [
            {
                label: 'Fail Am',
                data: <?= json_encode($monthlyBukaFailAmCounts) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            },
            {
                label: 'Fail Peribadi',
                data: <?= json_encode($monthlyBukaFailPeribadiCounts) ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
            }
        ]
    };

    // Config for Combined Fail Baru Graph
    const combinedFailBaruConfig = {
        type: 'line',
        data: combinedFailBaruData,
        options: {
            scales: {
                x: { title: { display: true, text: currentYear } },
                y: { title: { display: true, text: 'Jumlah' }, beginAtZero: true }
            }
        }
    };

    // Render Combined Fail Baru Graph
    new Chart(combinedFailBaruCtx, combinedFailBaruConfig);

    const combinedFailTutupCtx = document.getElementById('combinedFailTutupGraph').getContext('2d');
    const combinedFailTutupData = {
        labels: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
        datasets: [
            {
                label: 'Fail Am',
                data: <?= json_encode($monthlyTutupFailAmCounts) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            },
            {
                label: 'Fail Peribadi',
                data: <?= json_encode($monthlyTutupFailPeribadiCounts) ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
            }
        ]
    };

    // Config for Combined Fail Tutup Graph
    const combinedFailTutupConfig = {
        type: 'line',
        data: combinedFailTutupData,
        options: {
            scales: {
                x: { title: { display: true, text: currentYear } },
                y: { title: { display: true, text: 'Jumlah' }, beginAtZero: true }
            }
        }
    };

    // Render Combined Fail Tutup Graph
    new Chart(combinedFailTutupCtx, combinedFailTutupConfig);

    // Data for Combined Fail Pinjam Graph
    const combinedFailPinjamCtx = document.getElementById('combinedFailPinjamGraph').getContext('2d');
    const combinedFailPinjamData = {
        labels: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
        datasets: [
            {
                label: 'Fail Am',
                data: <?= json_encode($monthlyFailAmPinjamCounts) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            },
            {
                label: 'Fail Peribadi',
                data: <?= json_encode($monthlyFailPeribadiPinjamCounts) ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
            }
        ]
    };

    // Config for Combined Fail Pinjam Graph
    const combinedFailPinjamConfig = {
        type: 'line',
        data: combinedFailPinjamData,
        options: {
            scales: {
                x: { title: { display: true, text: currentYear } },
                y: { title: { display: true, text: 'Jumlah' }, beginAtZero: true }
            }
        }
    };

    // Render Combined Fail Pinjam Graph
    new Chart(combinedFailPinjamCtx, combinedFailPinjamConfig);

    const combinedFailPulangCtx = document.getElementById('combinedFailPulangGraph').getContext('2d');
    const combinedFailPulangData = {
        labels: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
        datasets: [
            {
                label: 'Fail Am',
                data: <?= json_encode($monthlyFailAmPulangCounts) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            },
            {
                label: 'Fail Peribadi',
                data: <?= json_encode($monthlyFailPeribadiPulangCounts) ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderWidth: 1
            }
        ]
    };

    // Config for Combined Fail Pulang Graph
    const combinedFailPulangConfig = {
        type: 'line',
        data: combinedFailPulangData,
        options: {
            scales: {
                x: { title: { display: true, text: currentYear } },
                y: { title: { display: true, text: 'Jumlah' }, beginAtZero: true }
            }
        }
    };

    // Render Combined Fail Pulang Graph
    new Chart(combinedFailPulangCtx, combinedFailPulangConfig);
</script>

<?= $this->endSection() ?>
