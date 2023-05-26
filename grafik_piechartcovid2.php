<!DOCTYPE html>
<html>
<head>
    <title>Pie Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="pieChart"></canvas>

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

        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: countries,
                datasets: [{
                    label: 'Total Cases',
                    data: totalCases,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)',
                        'rgba(255, 0, 0, 0.5)',
                        'rgba(0, 255, 0, 0.5)',
                        'rgba(0, 0, 255, 0.5)',
                        'rgba(128, 128, 128, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 0, 0, 1)',
                        'rgba(0, 255, 0, 1)',
                        'rgba(0, 0, 255, 1)',
                        'rgba(128, 128, 128, 1)'
                    ],
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
