<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.dataTables.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="app">
        <?= $this->include('layouts/inc/navbar.php') ?>
        <?= $this->renderSection('content') ?>
    </div>

    <script src="<?= base_url('assets/js/jquery-3.7.1.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <?= $this->renderSection('scripts') ?>

    <script>
        $(document).ready(function() {
            // Initialize DataTable for the main table
            $('#table').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "order": [],
                "language": {
                    "lengthMenu": "_MENU_",
                    "search": "",
                    "info": "_START_ - _END_ / _TOTAL_",
                    "infoEmpty": "Tiada rekod tersedia",
                    "infoFiltered": "(ditapis daripada _MAX_ rekod keseluruhan)",
                    "zeroRecords": "Tiada rekod dijumpai",
                    "emptyTable": "Tiada data tersedia dalam jadual"
                }
            });

            $('#tableReport').DataTable({
                "pageLength": 10,
                "order": [],
                "language": {
                    "infoEmpty": "Tiada rekod tersedia",
                    "infoFiltered": "(ditapis daripada _MAX_ rekod keseluruhan)",
                    "zeroRecords": "Tiada rekod dijumpai",
                    "emptyTable": "Tiada data tersedia dalam jadual"
                },
                "dom": 'rt<"bottom"p><"clear">', // Exclude search, info, and length menu
            });

            // Event handler for row clicks in the DataTable
            $(document).on('click', '#table .clickable-row', function() {
                const kodsubjek = $(this).data('kodsubjek');
                const rujukfailbaruid = $(this).data('rujukfailbaruid');
                const jilid = $(this).data('jilid');

                // Fetch file details from the server
                fetch(`<?= base_url('failAm/getDetails') ?>/${kodsubjek}/${rujukfailbaruid}/${jilid}`)
                    .then(response => response.json())
                    .then(data => {
                        const table = $('#file-details').DataTable({
                            "pageLength": 5,
                            "lengthMenu": [5, 10, 25],
                            "order": [],
                            "destroy": true, // Allows re-initialization
                            "language": {
                                "lengthMenu": "_MENU_",
                                "search": "",
                                "info": "_START_ - _END_ / _TOTAL_",
                                "infoEmpty": "Tiada rekod tersedia",
                                "infoFiltered": "(ditapis daripada _MAX_ rekod keseluruhan)",
                                "zeroRecords": "Tiada rekod dijumpai",
                                "emptyTable": "Tiada data tersedia dalam jadual"
                            }
                        });
                        table.clear(); // Clear previous data from DataTable

                        let hideButton = false; // Track whether the button should be hidden

                        if (data.error || data.length === 0) {
                            // Insert default values if no data or error
                            const defaultRow = [
                                'ADA', // Status
                                '-',         // Name
                                '-',         // Date
                                '-',         // Phone
                                '-',         // Email
                                '-', // Update button (disabled)
                                '-' // Delete button (disabled)
                            ];
                            table.row.add(defaultRow).draw(); // Add the default row and redraw the table
                        } else {
                            // Populate table with file details if data is present
                            data.forEach(function(fileDetail) {
                                if (fileDetail.Status === 'DILUPUS') {
                                    hideButton = true; // Set to true if any status is DILUPUS
                                }
                                const rowId = fileDetail.ID || ''; // Assuming there is an `id` field in the data for the row
                                const row = [
                                    fileDetail.Status || 'ADA',  // Status
                                    fileDetail.NamaPinjamPulang || '-', // Name
                                    fileDetail.TARIKHPPT || '-',        // Date
                                    fileDetail.phone || '-',            // Phone
                                    fileDetail.email || '-',             // Email
                                    `<button class="btn btn-primary btn-sm update-row" data-rowid="${rowId}">Kemaskini</button>`, // Update button
                                    `<button class="delete_btn btn btn-danger btn-sm" data-rowid="${rowId}">Hapus</button>` // Delete button
                                ];
                                table.row.add(row).draw(); // Add the new row and redraw the table
                            });
                        }

                        // Show or hide the file details section
                        $('#file-details-container').show();

                        // Show or hide the #pinjam-pulang-fp-btn button based on the Status
                        if (hideButton) {
                            $('#pinjam-pulang-fp-btn').hide();
                        } else {
                            $('#pinjam-pulang-fp-btn').show();
                        }

                        // Attach the click event for redirection
                        $('#pinjam-pulang-fp-btn').off('click').on('click', function() {
                            window.location.href = `<?= base_url('failAm/pinjamPulang/') ?>${kodsubjek}/${rujukfailbaruid}/${jilid}`;
                        });

                        // Attach event to the update button
                        $('#file-details').off('click', '.update-row').on('click', '.update-row', function() {
                            const rowId = $(this).data('rowid');
                            if (rowId) {
                                window.location.href = `<?= base_url('failAm/editPinjamPulang/') ?>${rowId}`;
                            }
                        });

                        // Attach event to the delete button
                        $('#file-details').off('click', '.delete_btn').on('click', '.delete_btn', function() {
                            const rowId = $(this).data('rowid');
                            if (rowId) {
                                if (confirm('Are you sure you want to delete this record?')) {
                                    // Call the delete function
                                    fetch(`<?= base_url('failAm/deletePinjamPulang/') ?>${rowId}`, {
                                        method: 'DELETE'
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Record deleted successfully');
                                            table.row($(this).parents('tr')).remove().draw();
                                        } else {
                                            alert('Error deleting record');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Error deleting record');
                                    });
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching file details:', error);
                        $('#file-details').html('<p>Error fetching file details. Please try again.</p>');
                        $('#file-details').show();
                    });
            });


            $('#tableFP').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "order": [],
                "language": {
                    "lengthMenu": "_MENU_",
                    "search": "",
                    "info": "_START_ - _END_ / _TOTAL_",
                    "infoEmpty": "Tiada rekod tersedia",
                    "infoFiltered": "(ditapis daripada _MAX_ rekod keseluruhan)",
                    "zeroRecords": "Tiada rekod dijumpai",
                    "emptyTable": "Tiada data tersedia dalam jadual"
                }
            });

            // Event handler for row clicks in the DataTable
            $(document).on('click', '#tableFP .clickable-row', function() {
                const NOKP = $(this).data('nokp');
                const NOFAIL = $(this).data('nofail');
                const NOJILID = $(this).data('nojilid');

                // Fetch file details from the server
                fetch(`<?= base_url('failPeribadi/getDetails') ?>/${NOKP}/${NOFAIL}/${NOJILID}`)
                    .then(response => response.json())
                    .then(data => {
                        const table = $('#file-detailsFP').DataTable({
                            "pageLength": 5,
                            "lengthMenu": [5, 10, 25],
                            "order": [],
                            "destroy": true, // Allows re-initialization
                            "language": {
                                "lengthMenu": "_MENU_",
                                "search": "",
                                "info": "_START_ - _END_ / _TOTAL_",
                                "infoEmpty": "Tiada rekod tersedia",
                                "infoFiltered": "(ditapis daripada _MAX_ rekod keseluruhan)",
                                "zeroRecords": "Tiada rekod dijumpai",
                                "emptyTable": "Tiada data tersedia dalam jadual"
                            }
                        });
                        table.clear(); // Clear previous data from DataTable

                        let hideButton = false; // Track whether the button should be hidden

                        if (data.error || data.length === 0) {
                            // Insert default values if no data or error
                            const defaultRow = [
                                'ADA', // Status
                                '-',     // Name
                                '-',     // Date
                                '-',     // Phone
                                '-',     // Email
                                '-', // Update button (disabled)
                                '-' // Delete button (disabled)
                            ];
                            table.row.add(defaultRow).draw(); // Add the default row and redraw the table
                        } else {
                            // Populate table with file details if data is present
                            data.forEach(function(fileDetailFP) {
                                if (fileDetailFP.STATUS2 === 'DILUPUS') {
                                    hideButton = true; // Set to true if any STATUS2 is DILUPUS
                                }
                                const rowId = fileDetailFP.id || ''; // Assuming there is an `id` field in the data for the row
                                const row = [
                                    fileDetailFP.STATUS2 || 'ADA',  // Status
                                    fileDetailFP.NAMAPENGGUNA || '-',  // Name
                                    fileDetailFP.TARIKHPPT || '-',    // Date
                                    fileDetailFP.phone || '-',        // Phone
                                    fileDetailFP.email || '-',        // Email
                                    `<button class="btn btn-primary btn-sm update-row" data-rowid="${rowId}">Kemaskini</button>`, // Update button
                                    `<button class="delete_btn btn btn-danger btn-sm" data-rowid="${rowId}">Hapus</button>` // Delete button
                                ];
                                table.row.add(row).draw(); // Add the new row and redraw the table
                            });
                        }

                        // Show or hide the file details section
                        $('#file-detailsFP-container').show();

                        // Show or hide the #pinjam-pulang-fp-btn button based on the STATUS2
                        if (hideButton) {
                            $('#pinjam-pulang-fp-btn').hide();
                        } else {
                            $('#pinjam-pulang-fp-btn').show();
                        }

                        // Attach the click event for redirection
                        $('#pinjam-pulang-fp-btn').off('click').on('click', function() {
                            window.location.href = `<?= base_url('failPeribadi/pinjamPulang/') ?>${NOKP}/${NOFAIL}/${NOJILID}`;
                        });

                        // Attach event to the update button
                        $('#file-detailsFP').off('click', '.update-row').on('click', '.update-row', function() {
                            const rowId = $(this).data('rowid');
                            if (rowId) {
                                window.location.href = `<?= base_url('failPeribadi/editPinjamPulang/') ?>${rowId}`;
                            }
                        });

                        // Attach event to the delete button
                        $('#file-detailsFP').off('click', '.delete_btn').on('click', '.delete_btn', function() {
                            const rowId = $(this).data('rowid');
                            if (rowId) {
                                if (confirm('Are you sure you want to delete this record?')) {
                                    // Call the delete function
                                    fetch(`<?= base_url('failPeribadi/deletePinjamPulang/') ?>${rowId}`, {
                                        method: 'DELETE'
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert('Record deleted successfully');
                                            table.row($(this).parents('tr')).remove().draw();
                                        } else {
                                            alert('Error deleting record');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Error deleting record');
                                    });
                                }
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching file details:', error);
                        $('#file-detailsFP-container').html('<p>Error fetching file details. Please try again.</p>');
                        $('#file-detailsFP-container').show();
                    });
            });

        });
    </script>
</body>
</html>
