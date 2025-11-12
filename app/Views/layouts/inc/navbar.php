<style>
    .custom-navbar {
    background-color: #15818D;
    }
</style>
<nav class="navbar bg custom-navbar fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">Sistem Pengurusan Fail (SPF)</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Sistem Pengurusan Fail (SPF)</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('/dashboard') ?>">Papan Pemuka</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Fail Peribadi
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= base_url('/failPeribadi') ?>">Daftar Baru / Kemaskini</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/failPeribadi/pinjam') ?>">Pinjam / Pulang Fail</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Fail Am
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= base_url('/failAm') ?>">Daftar Baru / Kemaskini</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/failAm/pinjam') ?>">Pinjam / Pulang Fail</a></li>
                
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Laporan Fail Peribadi
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('/failPeribadi/laporanKeseluruhan') ?>">Laporan Keseluruhan</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('/failPeribadi/laporanTkhBln') ?>">Laporan Mengikut Tarikh / Bulanan</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('/failPeribadi/laporanSttsPmnjm') ?>">Laporan Status Peminjam Fail Peribadi</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Laporan Fail Am
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('/failAm/laporanKeseluruhan') ?>">Laporan Keseluruhan</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/failAm/laporanTkhBln') ?>">Laporan Mengikut Tarikh / Bulanan</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/failAm/laporanSttsPmnjm') ?>">Laporan Status Peminjam Fail Am</a></li>
                    </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('/addLookup/tablePeminjam') ?>">Senarai Peminjam</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Tambah
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= base_url('/addLookup/addSubjek') ?>">Subjek</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/addLookup/addLokasi') ?>">Lokasi Fail</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/addLookup/addBhgnCwgn') ?>">Bahagian / Cawangan</a></li>
                </ul>
            </li>

            <?php if (session()->get('is_admin')): ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('/registerUser') ?>">Daftar Pengguna</a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= base_url('/logout') ?>">Log Keluar</a>
            </li>
            </ul>
        </div>
        </div>
    </div>
</nav>

