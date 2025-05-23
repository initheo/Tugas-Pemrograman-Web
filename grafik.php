<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .main-content-wrapper {
            width: 700px;
            height: 400px;
            background-color: #f0f0f0;
            padding: 20px;
            border: 1px solid #c0c0c0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-input-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            width: auto;
        }

        .form-input-container input[type="text"] {
            width: 180px;
            padding: 6px 8px;
            border: 1px solid #a9a9a9;
            border-radius: 2px;
            font-size: 0.9em;
        }

        .form-input-container input[type="number"] {
            width: 180px;
            font-size: 0.9em;
        }

        .form-input-container button {
            padding: 6px 12px;
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #a9a9a9;
            border-radius: 2px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .form-input-container button:hover {
            background-color: #e0e0e0;
        }

        .chart-canvas-area {
            width: 100%;
            height: 380px;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            padding: 10px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>

    <div class="main-content-wrapper">
        <form class="form-input-container" onsubmit="handleSubmit(event)">
            <input
                type="text"
                id="newLabel"
                placeholder="Label"
                required>
            <input
                type="number"
                id="newValue"
                placeholder="Value"
                required>
            <button type="submit">Add Data</button>
        </form>

        <div class="chart-canvas-area">
            <canvas id="myDynamicChart"></canvas>
        </div>
    </div>

    <script>
        const initialLabels = ["January", "February", "March", "April", "May"];
        const initialDataValues = [10, 20, 15, 25, 30];

        const chartContext = document.getElementById('myDynamicChart').getContext('2d');
        const dynamicChart = new Chart(chartContext, {
            type: 'line',
            data: {
                labels: [...initialLabels],
                datasets: [{
                    data: [...initialDataValues],
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0)',
                    tension: 0.1,
                    borderWidth: 2,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'blue',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 35,
                        right: 150,
                        bottom: 15,
                        left: 15
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        border: {
                            display: true,
                            color: '#cccccc'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            stepSize: 5,
                            font: {
                                size: 9
                            },
                            color: '#666666',
                            padding: 5
                        }
                    },
                    x: {
                        border: {
                            display: true,
                            color: '#cccccc'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 9
                            },
                            color: '#666666',
                            padding: 5
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.75)',
                        titleFont: {
                            size: 11
                        },
                        bodyFont: {
                            size: 10
                        },
                        padding: 6,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y !== null ? '' + context.parsed.y : '';
                            }
                        }
                    }
                },
                animation: {
                    duration: 400
                }
            }
        });

        const newLabelInputElement = document.getElementById('newLabel');
        const newValueInputElement = document.getElementById('newValue');

        function handleSubmit(event) {
            event.preventDefault();

            const label = newLabelInputElement.value.trim();
            const valueStr = newValueInputElement.value.trim();
            const value = parseFloat(valueStr);

            // Validasi input
            if (!label || !valueStr) {
                return;
            }

            dynamicChart.data.labels.push(label);
            dynamicChart.data.datasets.forEach((dataset) => {
                dataset.data.push(value);
            });
            dynamicChart.update();

            // Reset form
            newLabelInputElement.value = '';
            newValueInputElement.value = '';
            newLabelInputElement.focus();
        }
    </script>

</body>

</html>