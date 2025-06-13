<?php
$serverName = "SQL1003.site4now.net";
$database = "db_ab8bdc_carsale";
$username = "db_ab8bdc_carsale_admin";
$password = "Admin123";

try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$database;Encrypt=1;TrustServerCertificate=1",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Lỗi kết nối SQL Server: " . $e->getMessage());
}
?>
