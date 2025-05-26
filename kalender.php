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

        canvas {
            width: 100%;
            height: auto;
            border: 1px solid #333;
            margin-top: 10px;
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

        <!-- Canvas kalender -->
        <canvas id="calendarCanvas" width="450" height="350"></canvas>
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

        // Canvas dan context
        const canvas = document.getElementById('calendarCanvas');
        const ctx = canvas.getContext('2d');

        // Ukuran sel kalender
        const cellWidth = canvas.width / 7; // 450 / 7 ≈ 64.3
        const headerHeight = 50;
        const cellHeight = 60;

        function drawCalendar() {
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Update header
            document.getElementById('monthYear').textContent = `${Months[currentMonth]} ${currentYear}`;

            // Draw header hari
            ctx.fillStyle = '#f8f9fa';
            ctx.fillRect(0, 0, canvas.width, headerHeight);

            // Draw border untuk header
            ctx.strokeStyle = '#333';
            ctx.lineWidth = 1;
            ctx.strokeRect(0, 0, canvas.width, headerHeight);

            // Draw vertical lines untuk header
            for (let i = 1; i < 7; i++) {
                ctx.beginPath();
                ctx.moveTo(i * cellWidth, 0);
                ctx.lineTo(i * cellWidth, headerHeight);
                ctx.stroke();
            }

            // Draw text header hari
            ctx.fillStyle = '#333';
            ctx.font = 'bold 14px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            for (let i = 0; i < 7; i++) {
                ctx.fillText(indonesianDays[i], (i * cellWidth) + (cellWidth / 2), headerHeight / 2);
            }

            // Get first day of month and number of days
            const today = new Date();
            const todayDate = today.getDate();
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            let date = 1;
            const totalCells = firstDay + daysInMonth;
            const totalWeeks = Math.ceil(totalCells / 7);

            // Draw calendar grid and dates
            for (let week = 0; week < totalWeeks; week++) {
                for (let day = 0; day < 7; day++) {
                    const x = day * cellWidth;
                    const y = headerHeight + (week * cellHeight);
                    const cellPosition = (week * 7) + day;

                    // Draw cell border
                    ctx.strokeStyle = '#333';
                    ctx.lineWidth = 1;
                    ctx.strokeRect(x, y, cellWidth, cellHeight);

                    if (cellPosition < firstDay || date > daysInMonth) {
                        ctx.fillStyle = '#f9f9f9';
                        ctx.fillRect(x + 1, y + 1, cellWidth - 2, cellHeight - 2);
                    } else {
                        ctx.fillStyle = '#fff';
                        ctx.fillRect(x + 1, y + 1, cellWidth - 2, cellHeight - 2);

                        // Check if this is today's date (only date, not month/year)
                        const isSameDate = (date === todayDate);

                        if (isSameDate) {
                            // Highlight today
                            ctx.fillStyle = 'red';
                            ctx.fillRect(x + 1, y + 1, cellWidth - 2, cellHeight - 2);
                        }

                        // Draw date number
                        ctx.font = '14px Arial';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';

                        if (isSameDate) {
                            ctx.fillStyle = 'white';
                            ctx.font = 'bold 14px Arial';
                        } else {
                            ctx.fillStyle = '#333';
                            ctx.font = '14px Arial';
                        }

                        ctx.fillText(date, x + (cellWidth / 2), y + (cellHeight / 2));
                        date++;
                    }
                }

                if (date > daysInMonth) break;
            }
        }

        // Event listeners untuk navigasi
        document.getElementById('prevMonth').addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            drawCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            drawCalendar();
        });

        // Inisialisasi kalender
        drawCalendar();
    </script>

</body>

</html>