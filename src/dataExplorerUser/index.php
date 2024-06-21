<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoPark Smart Explorer</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400&family=Tilt+Neon&display=swap" rel="stylesheet">
    <style>
        .dropdown-menu {
            display: none;
        }

        .show {
            display: block;
        }
    </style>
    <script>
        function showDropdown(type) {
            document.getElementById('fileType').dataset.type = type;
            document.getElementById('fileTypeDropdown').classList.add('show');
        }

        function selectFileType() {
            const type = document.getElementById('fileType').dataset.type;
            document.getElementById(type).click();
        }

        function hideDropdown() {
            document.getElementById('fileTypeDropdown').classList.remove('show');
        }
    </script>
</head>

<body>
    <?php include '../common/navBar.php'; ?>
    <div id="wrap">
        <div class="container">
            <form class="form-horizontal" action="functions.php" method="post" name="upload_excel" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="file" id="file" class="input-large">

                    <button type="button" class="btn btn-success" onclick="showDropdown('Export')">Export As</button>
                    <div id="fileTypeDropdown" class="dropdown-menu">
                        <select name="fileType" id="fileType" class="input-large" onchange="selectFileType()">
                            <option value="">Select file type</option>
                            <option value="csv">CSV</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>
                    <button type="submit" id="Import" name="Import" class="btn btn-primary" style="display:none;"></button>
                    <button type="submit" id="Export" name="Export" class="btn btn-success" style="display:none;"></button>
                </div>
            </form>
            <?php
            require_once "getrecords.php"; // Include the PHP file where your functions are defined

            // Get the current page number
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            // Define pagination parameters
            $rowsPerPage = 15; // Number of rows per page

            // Calculate total pages
            $totalPages = calculate_total_pages($rowsPerPage);

            // Display records with pagination
            get_all_records($currentPage, $rowsPerPage);
            ?>

            <!-- Pagination -->
            <div class="pagination">
                <?php if ($currentPage > 1) : ?>
                    <a href="?page=<?php echo ($currentPage - 1); ?>">Previous</a>
                <?php endif; ?>

                <select id="pageDropdown" onchange="window.location.href = '?page=' + this.value;">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php if ($i == $currentPage) echo 'selected'; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>

                <?php if ($currentPage < $totalPages) : ?>
                    <a href="?page=<?php echo ($currentPage + 1); ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 style="color: white" ;>Chart of <?php echo htmlspecialchars($tableName); ?></h1>
        <?php if (!empty($data)) : ?>
            <canvas id="myChart" width="400" height="200"></canvas>
        <?php else : ?>
            <p>No data available in this table.</p>
        <?php endif; ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let myChart = null;
            const chartData = <?php echo $jsonData; ?>;
            if (chartData.length > 0) {
                // Assuming we are plotting 'Total_Vehicule' against some categorical data
                const labels = ["Judet","Categorie_Nationala","Marca"]; // Change 'Judet' to the desired column for x-axis
                const data = chartData.map(item => item.Total_Vehicule); // Change 'Total_Vehicule' to the desired column for y-axis

                const ctx = document.getElementById('myChart').getContext('2d');
                if (myChart) {
                    myChart.destroy(); // Destroy existing chart if it exists
                }
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Vehicles',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>