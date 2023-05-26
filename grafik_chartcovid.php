<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="barChart"></canvas>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_covid";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Mendapatkan data Total Cases dari tabel tb_case dan nama negara dari tabel tb_negara
    $sql = "SELECT tb_case.total_case, tb_negara.nama FROM tb_case INNER JOIN tb_negara ON tb_case.id_negara = tb_negara.id_negara";
    $result = $conn->query($sql);

    $countries = array();
    $totalCases = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($countries, $row['nama']);
            array_push($totalCases, $row['total_case']);
        }
    }

    $conn->close();
    ?>

    <script>
        var countries = <?php echo json_encode($countries); ?>;
        var totalCases = <?php echo json_encode($totalCases); ?>;

        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: countries,
                datasets: [{
                    label: 'Total Cases',
                    data: totalCases,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Cases in Ten Countries'
                    }
                }
            }
        });
    </script>
</body>
</html>

