<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_checklist";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mencari data tugas berdasarkan pencarian
$search_term = '';
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
}

$sql = "SELECT id, class, task, tool, is_complete FROM tasks WHERE class LIKE '%$search_term%' OR task LIKE '%$search_term%' OR tool LIKE '%$search_term%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas - Tata Usaha Laboran</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            text-decoration: none;
            padding: 8px 16px;
            margin: 5px;
            display: inline-block;
            background-color: #007acc;
            color: white;
            text-align: center;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #fff;
        }
        .search-container {
            margin: 20px 0;
            text-align: right;
        }
        .search-container input[type="text"] {
            padding: 8px;
            font-size: 16px;
        }
        .search-container button {
            padding: 8px;
            background-color: #007acc;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #007acc;
        }
    </style>
</head>
<body>
    <header>
        <h1>Daftar Tugas - Tata Usaha Laboran</h1>
    </header>
    <main>
        <section>
            <h2>Tugas untuk Hari Ini</h2>

            <!-- Search Form -->
            <div class="search-container">
                <form action="" method="get">
                    <input type="text" name="search" placeholder="Cari tugas..." value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit">Cari</button>
                </form>
            </div>

            <?php if ($result->num_rows > 0) { ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class</th>
                            <th>Task</th>
                            <th>Tool</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["class"] . "</td>";
                            echo "<td>";
                            if ($row["is_complete"]) {
                                echo "<strike>" . $row["task"] . "</strike>";
                            } else {
                                echo $row["task"];
                            }
                            echo "</td>";
                            echo "<td>" . $row["tool"] . "</td>";
                            echo "<td>" . ($row["is_complete"] ? "Complete" : "Incomplete") . "</td>";
                            echo "<td>";
                            echo "<a href='complete_task.php?id=" . $row["id"] . "' class='btn'>Complete</a> ";
                            echo "<a href='delete_task.php?id=" . $row["id"] . "' class='btn'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>Tidak ada tugas yang tersedia</p>
            <?php } ?>
            <a href="index.php" class="btn">Kembali ke Halaman Utama</a>
        </section>
    </main>
    <footer>
    <p>&copy; 2024 Jurusan Rekayasa Perangkat Lunak SMK Negeri 5 Kota Bekasi</p>
    </footer>
</body>
</html>
