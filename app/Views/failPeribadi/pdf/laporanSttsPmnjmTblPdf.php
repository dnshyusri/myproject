<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $reportTitle ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h1, h2, h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
        }

        .report-header {
            margin-top: 20px;
            text-align: center;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Display the dynamic report title based on fileType and date selection -->
    <h1>Sistem Pengurusan Fail (SPF)</h1>
    <h2><?= $reportTitle ?></h2>

    <!-- Display start/end date or month/year details based on the user's selection -->
    <?php if (!empty($dateDetails)): ?>
        <h3><?= $dateDetails ?></h3>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Peminjam</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Nama Fail</th>
                <th>No. KP</th>
                <th>No. Fail</th>
                <th>No. Jilid</th>
                <th>Tarikh Pinjam</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($failPeribadiPinjamData)): ?>
                <?php foreach ($failPeribadiPinjamData as $index => $fail): ?>
                    <tr>
                        <td><?= $startingNumber + $index ?></td>
                        <td><?= $fail['NAMAPENGGUNA'] ?? '-' ?></td>
                        <td><?= $fail['phone'] ?? '-' ?></td>
                        <td><?= $fail['email'] ?? '-' ?></td>
                        <td><?= $fail['NAMA'] ?? '-' ?></td>
                        <td><?= $fail['NOKP'] ?? '-' ?></td>
                        <td><?= $fail['NOFAIL'] ?? '-' ?></td>
                        <td><?= $fail['NOJILID'] ?? '-' ?></td>
                        <td><?= $fail['TARIKHPPT'] ?? '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">Tiada data dijumpai.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
