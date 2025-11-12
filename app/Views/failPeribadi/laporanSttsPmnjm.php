<?= $this->extend('layouts/frontend.php') ?>
<?= $this->section('content') ?>
<div class="container custom-margin">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Laporan Status Peminjam Fail Peribadi</h2>
                </div>
                <div class="card-body">
                    <!-- Centered content using Bootstrap classes and custom CSS -->
                    <div class="centered-content mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input file-type" type="radio" name="senarai" id="peminjam">
                            <label class="form-check-label" for="peminjam">Senarai peminjam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input file-type" type="radio" name="senarai" id="peminjamLewat">
                            <label class="form-check-label" for="peminjamLewat">Senarai peminjam lewat</label>
                        </div>
                    </div>

                    <div class="border border-black"></div>

                    <!-- Centered content for Mengikut Tarikh/Bulanan radio buttons -->
                    <div class="centered-content mb-3">
                    <div class="form-check form-check-inline">
                            <input class="form-check-input date-selection" type="radio" name="SP" id="keseluruhan" onchange="toggleDateFields()">
                            <label class="form-check-label" for="keseluruhan">Keseluruhan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input date-selection" type="radio" name="SP" id="mingguan" onchange="toggleDateFields()">
                            <label class="form-check-label" for="mingguan">Mengikut Tarikh</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input date-selection" type="radio" name="SP" id="bulanan" onchange="toggleDateFields()">
                            <label class="form-check-label" for="bulanan">Bulanan</label>
                        </div>
                    </div>

                    <!-- Date fields section, centered, hidden by default -->
                    <div class="centered-content mb-3 hidden" id="date-fields" style="display: flex; align-items: center;">
                        <div style="margin-right: 15px;">
                            <label for="start-date" class="form-label">Tarikh mula:</label>
                            <div class="input-group">
                                <input type="date" id="start-date" name="start-date" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" id="resetDateButton1" >X</button>
                            </div>
                        </div>
                        <div>
                            <label for="end-date" class="form-label">Tarikh tamat:</label>
                            <div class="input-group">
                                <input type="date" id="end-date" name="end-date" class="form-control">
                                <button type="button" class="btn btn-outline-secondary" id="resetDateButton2" >X</button>

                            </div>
                        </div>
                    </div>

                    <!-- Month field section, centered, hidden by default -->
                    <div class="centered-content mb-3 hidden" id="month-field">
                        <div style="margin-right: 15px;">
                            <label for="month" class="form-label">Bulan:</label>
                            <select id="month" name="month" class="form-select mx-2">
                                <option value="" disabled selected>Pilih bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Mac</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Jun</option>
                                <option value="7">Julai</option>
                                <option value="8">Ogos</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Disember</option>
                                <option value="13">Semua bulan</option>
                            </select>
                        </div>
                        <div>
                            <label for="year" class="form-label">Tahun:</label>
                            <select id="year" name="year" class="form-select mx-2">
                                <option value="" disabled selected>Pilih tahun</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center mb-3" id="generate-report-button" style="display: none;"> 
                        <button type="button" id="report-button" class="btn btn-primary">Hasilkan Laporan</button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-check {
        margin-bottom: 15px;
    }

    .border-black {
        margin-bottom: 15px; /* Space below the border */
    }

    .hidden {
        display: none; /* CSS class to hide elements */
    }

    .custom-margin {
        margin-top: 75px;
        margin-bottom: 25px;
    }

    .centered-content {
        display: flex;
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
        flex-wrap: wrap; /* Allow items to wrap in case of overflow */
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Hide the date and month fields and button by default
    document.getElementById('date-fields').style.display = 'none';
    document.getElementById('month-field').style.display = 'none';
    document.getElementById('generate-report-button').style.display = 'none';

    // Function to check if any file type radio button is selected
    function isFileTypeSelected() {
        var fileTypeRadios = document.querySelectorAll('.file-type');
        for (var i = 0; i < fileTypeRadios.length; i++) {
            if (fileTypeRadios[i].checked) {
                return true;
            }
        }
        return false;
    }

    // Function to reset input values and URL parameters when switching between date and month selection
    function resetInputsAndURL() {
        // Clear input fields
        document.getElementById('start-date').value = '';
        document.getElementById('end-date').value = '';
        document.getElementById('month').value = '';

        // Reset URL parameters
        var url = new URL(window.location.href);
        url.searchParams.delete('start-date');
        url.searchParams.delete('end-date');
        url.searchParams.delete('month');
        window.history.replaceState({}, '', url);
    }

    // Function to toggle date fields and month field based on selections
    function toggleDateFields() {
        var keseluruhan = document.getElementById('keseluruhan');
        var mingguan = document.getElementById('mingguan');
        var bulanan = document.getElementById('bulanan');
        var dateFields = document.getElementById('date-fields');
        var monthField = document.getElementById('month-field');
        var reportButton = document.getElementById('generate-report-button');

        // Check if any file type radio button is selected
        if (isFileTypeSelected()) {
            // Show or hide fields based on selected date option
            if (keseluruhan.checked) {
                dateFields.style.display = 'none'; // Show date fields
                monthField.style.display = 'none'; // Hide month fields
                reportButton.style.display = 'block';

                resetInputsAndURL();
            } else if (mingguan.checked) {
                dateFields.style.display = 'flex'; // Show date fields
                monthField.style.display = 'none'; // Hide month fields
                reportButton.style.display = 'block'; // Show generate report button

                // Clear previous month selection and reset URL
                resetInputsAndURL();
            } else if (bulanan.checked) {
                dateFields.style.display = 'none'; // Hide date fields
                monthField.style.display = 'flex'; // Show month fields
                reportButton.style.display = 'block'; // Show generate report button

                // Clear previous date selection and reset URL
                resetInputsAndURL();
                updateYearDropdown(); // Load years based on file type
            } else {
                dateFields.style.display = 'none';
                monthField.style.display = 'none';
                reportButton.style.display = 'none'; // Hide generate report button
            }
        } else {
            // Hide all fields if no file type is selected
            dateFields.style.display = 'none';
            monthField.style.display = 'none';
            reportButton.style.display = 'none';
        }
    }

    // Function to update the year dropdown based on file type selection
    function updateYearDropdown() {
        var fileType = document.querySelector('input[name="senarai"]:checked')?.id;

        if (fileType) {
            // Fetch available years for the selected file type using AJAX
            $.ajax({
                url: "<?= base_url('/failPeribadi/getAvailableYears') ?>",
                type: "GET",
                data: { fileType: fileType },
                success: function (data) {
                    var yearSelect = document.getElementById('year');
                    yearSelect.innerHTML = '<option value="" disabled selected>Pilih tahun</option>'; // Reset year options
                    data.forEach(function (year) {
                        var option = document.createElement('option');
                        option.value = year.year;
                        option.text = year.year;
                        yearSelect.appendChild(option);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Failed to fetch years: ", error);
                }
            });
        }
    }

    // Event listener to toggle fields when file type is selected
    var fileTypeRadios = document.querySelectorAll('.file-type');
    fileTypeRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            resetInputsAndURL(); // Reset inputs and URL on file type change
            toggleDateFields();
        });
    });

    // Event listener to hide fields if no date selection is made
    var dateSelectionRadios = document.querySelectorAll('.date-selection');
    dateSelectionRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            resetInputsAndURL(); // Reset inputs and URL on date option change
            toggleDateFields();
        });
    });

    document.getElementById('report-button').addEventListener('click', function (event) {
        // Prevent form submission or page change
        event.preventDefault();

        // Get selected file type
        var fileType = document.querySelector('input[name="senarai"]:checked')?.id;

        // Validate that a file type is selected
        if (!fileType) {
            alert("Sila pilih jenis senarai (peminjam atau peminjam lewat).");
            return;
        }

        // Get selected dates or month and year
        var startDate = document.getElementById('start-date').value;
        var endDate = document.getElementById('end-date').value;
        var month = document.getElementById('month').value;
        var year = document.getElementById('year').value;

        // Check selected date option
        var keseluruhan = document.getElementById('keseluruhan');
        var mingguan = document.getElementById('mingguan');
        var bulanan = document.getElementById('bulanan');

        // Construct the base URL
        var url = "<?= base_url('/failPeribadi/laporanSttsPmnjmTbl') ?>?fileType=" + fileType;

        // Handle "Keseluruhan"
        if (keseluruhan.checked) {
            // Navigate to the URL with no additional parameters
            window.location.href = url;
            return;
        }

        // Handle "Mengikut Tarikh" (Mingguan)
        if (mingguan.checked) {
            if (!startDate || !endDate) {
                alert("Sila pilih tarikh mula dan tarikh tamat.");
                return;
            }
            url += "&start-date=" + startDate + "&end-date=" + endDate;
        }

        // Handle "Bulanan"
        if (bulanan.checked) {
            if (!month || !year) {
                alert("Sila pilih bulan dan tahun.");
                return;
            }
            url += "&month=" + month + "&year=" + year;
        }

        // Navigate to the constructed URL
        window.location.href = url;
    });


    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');

    startDateInput.addEventListener('change', function () {
        const startDate = this.value;

        if (startDate) {
            const startDateObj = new Date(startDate);
            startDateObj.setDate(startDateObj.getDate() + 1); // Add 1 day

            const minDate = startDateObj.toISOString().split('T')[0];
            endDateInput.min = minDate;
        }
    });

    endDateInput.addEventListener('change', function () {
        const endDate = this.value;

        if (endDate) {
            const endDateObj = new Date(endDate);
            endDateObj.setDate(endDateObj.getDate() - 1); // Subtract 1 day

            const maxDate = endDateObj.toISOString().split('T')[0];
            startDateInput.max = maxDate;
        }
    });

    $(document).ready(function(){
        $('#resetDateButton1').on('click', function() {
            $('#start-date').val('');
            endDateInput.min = ''; // Reset min date for end date
            startDateInput.max = ''; // Reset max date for start date
        });
        $('#resetDateButton2').on('click', function() {
            $('#end-date').val('');
            endDateInput.min = ''; // Reset min date for end date
            startDateInput.max = ''; // Reset max date for start date
        });
    });

    
</script>

<?= $this->endSection() ?>