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

        table {
            width: 100%;
            background-color: #f0f0f0;
            border-collapse: collapse;
            border: 1px solid #333;
        }

        th,
        td {
            padding: 12px 8px;
            text-align: center;
            border: 1px solid #333;
        }

        th {
            text-align: center;
        }

        td.angka-col {
            text-align: center;
            width: 20%;
            font-weight: bold;
        }

        .highlight-kelipatan {
            background-color: lightgreen !important;
        }

        .kelipatan-col {
            width: 80%;
            padding-left: 15px;
            background-color: #ffffff;
        }

        .warning {
            color: #d9534f;
            font-weight: bold;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        tr:nth-child(even) .highlight-kelipatan {
            background-color: #90EE90 !important;
        }

        tr:nth-child(even) td.kelipatan-col:not(.highlight-kelipatan) {
            background-color: #ffffff !important;
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

        <table>
            <thead>
                <tr>
                    <th>Angka</th>
                    <th>Kelipatan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 1; $i <= 40; $i++):
                    $is_multiple = ($current_kelipatan_factor > 0 && $i % $current_kelipatan_factor == 0);

                    if ($is_multiple) {
                        $kelipatan_text = $i . " (kelipatan dari " . htmlspecialchars($current_kelipatan_factor) . ")";
                        $class_kelipatan = "highlight-kelipatan";
                    } else {
                        $kelipatan_text = $i;
                        $class_kelipatan = "";
                    }
                ?>
                    <tr>
                        <td class="angka-col"><?php echo $i; ?></td>
                        <td class="kelipatan-col <?php echo $class_kelipatan; ?>">
                            <?php echo htmlspecialchars($kelipatan_text); ?>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

</body>

</html>