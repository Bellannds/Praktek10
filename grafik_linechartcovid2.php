<!DOCTYPE html>
<html>
<head>
    <title>Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="lineChart"></canvas>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_covid2";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Mendapatkan data Total Cases dan Nama Negara dari tabel tb_totalpopulation dan tb_negara
    $sql = "SELECT tb_totalpopulation.total_case, tb_negara.nama FROM tb_totalpopulation INNER JOIN tb_negara ON tb_totalpopulation.id_negara = tb_negara.id_negara";
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

        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: countries,
                datasets: [{
                    label: 'Total Cases',
                    data: totalCases,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
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
