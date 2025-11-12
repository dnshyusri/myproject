<!-- File: app/Views/failam_pdf.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $reportTitle ?></title>
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
    <h2><?= $reportTitle ?></h2>
    <?php if (!empty($dateDetails)): ?>
        <h3><?= $dateDetails ?></h3>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Fail</th>
                <th>Subjek Utama</th>
                <th>Bil.</th>
                <th>Tajuk Fail</th>
                <th>Rujukan Fail Lama</th>
                <th>Rujukan Fail Baru</th>
                <th>No. Jilid</th>
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
            <?php if (!empty($failAmData)): ?>
                <?php foreach ($failAmData as $index => $fail): ?>
                    <tr>
                        <td><?= $startingNumber + $index ?></td>
                        <td><?= $fail['NoFail'] ?? '-' ?></td>
                        <td><?= $fail['Subjek'] ?? '-' ?></td>
                        <td><?= $fail['Bil'] ?? '-' ?></td>
                        <td><?= $fail['TajukFail'] ?? '-' ?></td>
                        <td><?= $fail['RujukFailLama'] ?? '-' ?></td>
                        <td><?= $fail['RujukFailBaru'] ?? '-' ?></td>
                        <td><?= $fail['Jilid'] ?? '-' ?></td>
                        <td><?= $fail['LokasiFail'] ?? '-' ?></td>
                        <?php if ($fileType === 'baru' || $fileType === 'tutup'): ?>
                            <td><?= $fileType === 'baru' ? ($fail['tkhBuka'] ?? '-') : ($fail['tkhTutup'] ?? '-') ?></td>
                        <?php elseif ($fileType === 'pinjam' || $fileType === 'pulang'): ?>
                            <td><?= $fail['NamaPinjamPulang'] ?? '-' ?></td>
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
