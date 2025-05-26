<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$kelipatan_input_value = '';
$current_kelipatan_factor = 1;
$warning_message = "";

if (!isset($_SESSION['last_valid_kelipatan_factor'])) {
    $_SESSION['last_valid_kelipatan_factor'] = 1;
}
$current_kelipatan_factor = $_SESSION['last_valid_kelipatan_factor'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_str = $_POST['kelipatan'];
    $kelipatan_input_value = $input_str;

    if ($input_str === '') {
        $current_kelipatan_factor = 1;
        $_SESSION['last_valid_kelipatan_factor'] = $current_kelipatan_factor;
        $kelipatan_input_value = '';
    } else {
        $current_kelipatan_factor = (int)$input_str;
        $_SESSION['last_valid_kelipatan_factor'] = $current_kelipatan_factor;
    }
} else {
    $current_kelipatan_factor = $_SESSION['last_valid_kelipatan_factor'];
    if ($current_kelipatan_factor == 1 && !isset($_POST['kelipatan'])) {
        $kelipatan_input_value = '';
    } else {
        $kelipatan_input_value = (string)$current_kelipatan_factor;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelipatan Angka</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px 0;
        }

        .multiplication-canvas {
            width: 700px;
            margin: 0 auto;
            padding: 30px;
            background-color: #f0f0f0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-container label {
            font-weight: normal;
            color: #333;
        }

        .form-container input[type="text"]:focus {
            border-color: #5cb85c;
            outline: none;
        }

        .title {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: left;
        }

        canvas {
            width: 100%;
            border: 1px solid #333;
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>

    <div class="multiplication-canvas">
        <div class="form-container">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="kelipatan">Masukan Kelipatan :</label>
                <input type="text" id="kelipatan" name="kelipatan" value="<?php echo htmlspecialchars($kelipatan_input_value); ?>" pattern="[1-9]*" placeholder="Masukkan angka" oninvalid="this.setCustomValidity('Value must be greater than or equal to 1.')" oninput="this.setCustomValidity('')">
                <input type="submit" value="Kirim">
            </form>
        </div>

        <div class="title">Kelipatan dari <?php echo htmlspecialchars($current_kelipatan_factor); ?></div>

        <canvas id="kelipatanCanvas" width="640" height="1300"></canvas>
    </div>

    <script>
        const canvas = document.getElementById('kelipatanCanvas');
        const ctx = canvas.getContext('2d');

        const kelipatanFactor = <?php echo $current_kelipatan_factor; ?>;

        // Ukuran sel
        const cellWidth = canvas.width / 2; // 2 kolom: Angka dan Kelipatan
        const headerHeight = 40;
        const rowHeight = 30;

        function drawTable() {
            // Clear canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw header
            ctx.fillStyle = '#f0f0f0';
            ctx.fillRect(0, 0, canvas.width, headerHeight);

            // Header border
            ctx.strokeStyle = '#333';
            ctx.lineWidth = 0.5;
            ctx.strokeRect(0, 0, canvas.width, headerHeight);
            ctx.strokeRect(0, 0, cellWidth * 0.4, headerHeight); // Kolom Angka
            ctx.strokeRect(cellWidth * 0.4, 0, cellWidth * 1.6, headerHeight); // Kolom Kelipatan

            // Header text
            ctx.fillStyle = '#333';
            ctx.font = 'bold 14px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            ctx.fillText('Angka', (cellWidth * 0.4) / 2, headerHeight / 2);
            ctx.fillText('Kelipatan', cellWidth * 0.4 + (cellWidth * 1.6) / 2, headerHeight / 2);

            // Draw rows
            for (let i = 1; i <= 40; i++) {
                const y = headerHeight + ((i - 1) * rowHeight);
                const isMultiple = (kelipatanFactor > 0 && i % kelipatanFactor == 0);

                // Row background - kolom angka dengan warna header
                ctx.fillStyle = '#f0f0f0';
                ctx.fillRect(0, y, cellWidth * 0.4, rowHeight);

                if (isMultiple) {
                    if (i % 2 === 0) {
                        ctx.fillStyle = '#90EE90';
                    } else {
                        ctx.fillStyle = 'lightgreen';
                    }
                    ctx.fillRect(cellWidth * 0.4, y, cellWidth * 1.6, rowHeight);
                } else {
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(cellWidth * 0.4, y, cellWidth * 1.6, rowHeight);
                }

                // Cell borders - lebih tipis
                ctx.strokeStyle = '#333';
                ctx.lineWidth = 0.5;
                ctx.strokeRect(0, y, cellWidth * 0.4, rowHeight); // Angka column
                ctx.strokeRect(cellWidth * 0.4, y, cellWidth * 1.6, rowHeight); // Kelipatan column

                // Draw numbers
                ctx.fillStyle = '#333';
                ctx.font = 'bold 14px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                // Angka column - tetap di tengah
                ctx.fillText(i.toString(), (cellWidth * 0.4) / 2, y + rowHeight / 2);

                // Kelipatan column - ubah ke tengah
                if (isMultiple) {
                    const text = i + " (kelipatan dari " + kelipatanFactor + ")";
                    ctx.fillText(text, cellWidth * 0.4 + (cellWidth * 1.6) / 2, y + rowHeight / 2);
                } else {
                    ctx.fillText(i.toString(), cellWidth * 0.4 + (cellWidth * 1.6) / 2, y + rowHeight / 2);
                }
            }
        }

        // Draw the table
        drawTable();
    </script>

</body>

</html>