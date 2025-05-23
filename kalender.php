<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .calendar-canvas {
            width: 450px;
            padding: 20px;
            background-color: #fff;
            text-align: center;
            position: relative;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1px;
        }

        .calendar-header a {
            text-decoration: none;
            color: #6666ff;
            padding: 2px 5px;
            background-color: transparent;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
            border: none;
            text-decoration: underline;
        }

        .calendar-header h2 {
            margin: 0;
            font-size: 19px;
            font-weight: normal;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            height: 35px;
            font-size: 14px;
            vertical-align: middle;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        td {
            background-color: #fff;
            color: #333;
        }

        td.current-day-highlight {
            background-color: red !important;
            color: white !important;
            font-weight: bold;
        }

        td.empty-cell {
            background-color: #f9f9f9;
        }

        td:not(.empty-cell):hover {
            background-color: #e9ecef;
            cursor: pointer;
        }

        td.current-day-highlight:hover {
            background-color: #cc0000 !important;
        }
    </style>
</head>

<body>

    <div class="calendar-canvas">
        <!-- Header kalender dengan navigasi -->
        <div class="calendar-header">
            <a id="prevMonth">&lt;&lt; Bulan Sebelumnya</a>
            <h2 id="monthYear"></h2>
            <a id="nextMonth">Bulan Berikutnya &gt;&gt;</a>
        </div>

        <!-- Tabel kalender -->
        <table>
            <thead>
                <tr id="dayHeaders"></tr>
            </thead>
            <tbody id="calendarBody">
            </tbody>
        </table>
    </div>

    <script>
        // Hari dalam bahasa Indonesia (Minggu di kolom kiri)
        const indonesianDays = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

        // Nama bulan dalam bahasa Inggris
        const Months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        // Variabel untuk bulan dan tahun saat ini
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        // Fungsi untuk membuat header hari
        function createDayHeaders() {
            const headerRow = document.getElementById('dayHeaders');
            headerRow.innerHTML = '';

            indonesianDays.forEach(day => {
                const th = document.createElement('th');
                th.textContent = day;
                headerRow.appendChild(th);
            });
        }

        // Fungsi untuk menghasilkan kalender
        function generateCalendar(month, year) {
            const today = new Date();
            const todayDate = today.getDate(); // Hanya ambil tanggal, bukan bulan/tahun

            // Update header bulan dan tahun
            document.getElementById('monthYear').textContent = `${Months[month]} ${year}`;

            // Mendapatkan informasi bulan
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const daysInMonth = lastDay.getDate();
            const firstDayOfWeek = firstDay.getDay(); // 0 = Minggu

            // Clear calendar body
            const calendarBody = document.getElementById('calendarBody');
            calendarBody.innerHTML = '';

            let currentDate = 1;

            // Hitung jumlah minggu yang diperlukan
            const totalCells = firstDayOfWeek + daysInMonth;
            const totalWeeks = Math.ceil(totalCells / 7);

            for (let week = 0; week < totalWeeks; week++) {
                const row = document.createElement('tr');

                for (let dayOfWeek = 0; dayOfWeek < 7; dayOfWeek++) {
                    const cell = document.createElement('td');
                    const cellPosition = (week * 7) + dayOfWeek;

                    if (cellPosition < firstDayOfWeek || currentDate > daysInMonth) {
                        // Sel kosong untuk hari sebelum tanggal 1 atau setelah akhir bulan
                        cell.className = 'empty-cell';
                        cell.innerHTML = '';
                    } else {
                        // Cek apakah tanggal ini sama dengan tanggal hari ini (tanpa peduli bulan/tahun)
                        const isSameDate = (currentDate === todayDate);

                        if (isSameDate) {
                            cell.className = 'current-day-highlight';
                        }

                        cell.textContent = currentDate;
                        currentDate++;
                    }

                    row.appendChild(cell);
                }

                calendarBody.appendChild(row);
            }
        }

        // Event listeners untuk navigasi
        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });

        // Inisialisasi kalender
        createDayHeaders();
        generateCalendar(currentMonth, currentYear);
    </script>

</body>

</html>