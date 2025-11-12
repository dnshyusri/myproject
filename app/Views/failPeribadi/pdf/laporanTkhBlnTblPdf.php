<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $reportTitle ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 4px; /* Reduced padding for better fit */
            border: 1px solid black;
            font-size: 10px; /* Adjust font size */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        h1, h2, h3 {
            text-align: center;
            font-size: 14px; /* Adjust heading font sizes */
        }

        /* Add specific widths to columns */
        th:nth-child(1), td:nth-child(1) { width: 5%; } /* No. */
        th:nth-child(2), td:nth-child(2) { width: 20%; } /* Nama */
        th:nth-child(3), td:nth-child(3) { width: 15%; } /* No. KP */
        th:nth-child(4), td:nth-child(4) { width: 15%; } /* Jawatan */
        th:nth-child(5), td:nth-child(5) { width: 15%; } /* Bahagian / Cawangan */
        th:nth-child(6), td:nth-child(6) { width: 10%; } /* No. Fail */
        th:nth-child(7), td:nth-child(7) { width: 10%; } /* No. Jilid */
        th:nth-child(8), td:nth-child(8) { width: 10%; } /* Status */
        th:nth-child(9), td:nth-child(9) { width: 10%; } /* Lokasi Fail */
        th:nth-child(10), td:nth-child(10) { width: 10%; } /* Tarikh Buka/Tutup or Pinjam/Pulang */
        th:nth-child(11), td:nth-child(11) { width: 15%; } /* Nama Peminjam */
        th:nth-child(12), td:nth-child(12) { width: 15%; } /* Telefon */
        th:nth-child(13), td:nth-child(13) { width: 15%; } /* Email */
        th:nth-child(14), td:nth-child(14) { width: 10%; } /* Tarikh Pinjam/Pulang */
    </style>
</head>
<body>
    <h1>Sistem Pengurusan Fail (SPF)</h1>
    <h2><?= $reportTitle ?></h2>
    <?php if (!empty($dateDetails)): ?>
        <h3><?= $dateDetails ?></h3>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>No. KP</th>
                <th>Jawatan</th>
                <th>Bahagian / Cawangan</th>
                <th>No. Fail</th>
                <th>No. Jilid</th>
                <th>Status</th>
                <th>Lokasi Fail</th>
                <?php if ($fileType === 'baru' || $fileType === 'tutup'): ?>
                    <th>Tarikh <?= $fileType === 'baru' ? 'Buka' : 'Tutup' ?></th>
                <?php elseif ($fileType === 'pinjam' || $fileType === 'pulang'): ?>
                    <th>Nama Peminjam</th>
                    <th>Telefon</th>
                    <th>Email</th>
                    <th>Tarikh <?= $fileType === 'pinjam' ? 'Pinjam' : 'Pulang' ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($failPeribadiData)): ?>
                <?php foreach ($failPeribadiData as $index => $fail): ?>
                    <tr>
                        <td><?= $startingNumber + $index ?></td>
                        <td><?= $fail['NAMA'] ?? '-' ?></td>
                        <td><?= $fail['NOKP'] ?? '-' ?></td>
                        <td><?= $fail['JAWATAN'] ?? '-' ?></td>
                        <td><?= $fail['BAHAGIAN_CAWANGAN'] ?? '-' ?></td>
                        <td><?= $fail['NOFAIL'] ?? '-' ?></td>
                        <td><?= $fail['NOJILID'] ?? '-' ?></td>
                        <td><?= $fail['STATUS'] ?? '-' ?></td>
                        <td><?= $fail['LOKASI_FAIL'] ?? '-' ?></td>
                        <?php if ($fileType === 'baru' || $fileType === 'tutup'): ?>
                            <td><?= $fileType === 'baru' ? ($fail['TARIKH'] ?? '-') : ($fail['TARIKHPPT'] ?? '-') ?></td>
                        <?php elseif ($fileType === 'pinjam' || $fileType === 'pulang'): ?>
                            <td><?= $fail['NAMAPENGGUNA'] ?? '-' ?></td>
                            <td><?= $fail['phone'] ?? '-' ?></td>
                            <td><?= $fail['email'] ?? '-' ?></td>
                            <td><?= $fail['TARIKHPPT'] ?? '-' ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="15" class="text-center">Tiada data dijumpai.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
