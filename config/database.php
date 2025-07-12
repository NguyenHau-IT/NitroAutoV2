<?php
$serverName = "10.244.54.185,1433";
$database = "carsale";
$username = "hau";
$password = "haunvh";

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
