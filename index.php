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

// Menangani form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = $_POST['class'];
    $task = $_POST['task'];
    $tool = $_POST['tool'];

    // Cek apakah tugas sudah ada di database
    $check_sql = "SELECT * FROM tasks WHERE class = '$class' AND task = '$task' AND tool = '$tool'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $message = "Tugas sudah ada di database!";
    } else {
        $sql = "INSERT INTO tasks (class, task, tool, is_complete) VALUES ('$class', '$task', '$tool', 0)";

        if ($conn->query($sql) === TRUE) {
            $message = "Tugas berhasil ditambahkan!";
            // Redirect ke halaman tabel
            header("Location: tabel.php");
            exit();
        } else {
            $message = "Terjadi kesalahan: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas - Tata Usaha Laboran</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Tambah Tugas - Tata Usaha Laboran</h1>
    </header>
    <main>
        <section>
            <h2>Input Tugas</h2>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <form action="index.php" method="post">
                <label for="class">Class:</label>
                <select name="class" id="class" required>
                    <option value="10 RPL Samsung">10 RPL Samsung</option>
                    <option value="10 RPL 2">10 RPL 2</option>
                    <option value="10 RPL 3">10 RPL 3</option>
                    <option value="11 RPL Samsung">11 RPL Samsung</option>
                    <option value="11 RPL 2">11 RPL 2</option>
                    <option value="11 RPL 3">11 RPL 3</option>
                    <option value="12 RPL Samsung">12 RPL Samsung</option>
                    <option value="12 RPL 2">12 RPL 2</option>
                    <option value="12 RPL 3">12 RPL 3</option>
                </select>
                
                <label for="task">Task:</label>
                <select name="task" id="task" required>
                    <option value="Check lab equipment">Check lab equipment</option>
                    <option value="Update inventory">Update inventory</option>
                    <option value="Clean workspace">Clean workspace</option>
                    <option value="Prepare materials for the next class">Prepare materials for the next class</option>
                    <option value="Record lab activities">Record lab activities</option>
                    <option value="Check and calibrate devices">Check and calibrate devices</option>
                    <option value="Monitor software licenses">Monitor software licenses</option>
                    <option value="Ensure network connectivity">Ensure network connectivity</option>
                </select>
                
                <label for="tool">Laboratory Tool:</label>
                <select name="tool" id="tool" required>
                    <option value="Komputer/Laptop">Komputer/Laptop</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="Router/Modem">Router/Modem</option>
                    <option value="Switch Network">Switch Network</option>
                    <option value="Alat Pengukur (multimeter, oscilloscope)">Alat Pengukur (multimeter, oscilloscope)</option>
                    <option value="Kabel jaringan dan konektor">Kabel jaringan dan konektor</option>
                    <option value="Perangkat server">Perangkat server</option>
                    <option value="Software lisensi (IDE, compiler)">Software lisensi (IDE, compiler)</option>
                    <option value="Alat tulis dan presentasi">Alat tulis dan presentasi</option>
                </select>

                <button type="submit">Add Task</button>
                <a href="tabel.php" class="btn">Lihat Tabel Tugas</a>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Jurusan Rekayasa Perangkat Lunak SMK Negeri 5 Kota Bekasi</p>
    </footer>
</body>
</html>
