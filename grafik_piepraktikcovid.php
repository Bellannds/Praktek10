<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="pieChart"></canvas>

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
                'rgba(159, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)'
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
        },
        elements: {
            arc: {
                borderWidth: 0
            }
        },
        radius: '40%', // Mengatur ukuran lingkaran menjadi 40% dari default
        layout: {
            padding: {
                top: 10,
                bottom: 10,
                left: 10,
                right: 10
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (context) {
                        var label = context.label || '';

                        if (label) {
                            label += ': ';
                        }
                        label += context.formattedValue.toLocaleString();
                        return label;
                    }
                }
            }
        },
        elements: {
            arc: {
                borderWidth: 0
            }
        },
        radius: '50%',
        distance: 5 // Mengatur jarak antara lingkaran
    }
});



    </script>
</
