<?php
// Include header.php
include '../profil/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart View</title>
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;

            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .chart-container {
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 16px;
            width: 95%;
            max-width: 1200px;
            margin: 20px;
            transition: transform 0.3s ease-in-out;
        }
        .chart-container:hover {
            transform: scale(1.02);
        }
        h2 {
            margin-bottom: 20px;
            color: #009688;
            font-weight: 700;
            text-align: center;
        }
        .canvas {
            
            width: 100% !important;
            height: 400px !important;
        }
        .footer {
            
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <h2>Jumlah Inputan Buku</h2>
        <div class="canvas">
        <canvas id="inputChart"></canvas>
        </div>
    </div>

    <?php
    require_once __DIR__ . '/../../controllers/kurvabukuc.php';
    require_once __DIR__ . '/../../core/db.php';

    $kurvabukuc = new kurvabukuc($pdo);
    $inputCounts = $kurvabukuc->getInputCountByTitle();

    $titles = [];
    $counts = [];

    foreach ($inputCounts as $inputCount) {
        $titles[] = $inputCount['buku_judul'];
        $counts[] = $inputCount['input_count'];
    }
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('inputChart').getContext('2d');
            var inputChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($titles); ?>,
                    datasets: [{
                        label: 'Jumlah Inputan',
                        data: <?php echo json_encode($counts); ?>,
                        backgroundColor: 'rgba(0, 150, 136, 0.2)',
                        borderColor: 'rgba(0, 150, 136, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: "rgba(0, 0, 0, 0.1)"
                            }
                        },
                        x: {
                            grid: {
                                color: "rgba(0, 0, 0, 0.1)"
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 150, 136, 0.8)',
                            titleFont: { family: 'Roboto', weight: 'bold' },
                            bodyFont: { family: 'Roboto' },
                            borderColor: 'rgba(0, 150, 136, 1)',
                            borderWidth: 1
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
<?php
include '../profil/footer.php';
?>
