<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keseluruhan Fail Peribadi</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
        }
        
        .text-center { 
            text-align: center; 
        }

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
    </style>
</head>
<body>
    <h1>Sistem Pengurusan Fail (SPF)</h1>
    <h2>Laporan Keseluruhan Fail Peribadi</h2>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Fail Baru</th>
                <th>Fail Tutup</th>
                <th>Fail Dipinjamkan</th>
                <th>Fail Dipulangkan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($months as $index => $month): ?>
            <tr>
                <td><?= $month ?></td>
                <td><?= $failBaru[$index] ?></td>
                <td><?= $failTutup[$index] ?></td>
                <td><?= $failPinjam[$index] ?></td>
                <td><?= $failPulang[$index] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>