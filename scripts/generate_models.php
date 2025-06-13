<?php
require_once 'config/database.php';

// Lấy danh sách bảng trong database
$queryTables = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
$stmt = $conn->query($queryTables);
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    // Lấy danh sách cột của bảng
    $queryColumns = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
    $stmt = $conn->prepare($queryColumns);
    $stmt->execute([$table]);
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Tạo thuộc tính cho Model
    $properties = "";
    $fillable = [];

    foreach ($columns as $column) {
        $properties .= "    public $$column;\n";
        $fillable[] = "'$column'";
    }

    $fillableStr = implode(", ", $fillable);

    // Nội dung Model
    $modelContent = "<?php
require_once '../config/database.php';

class " . ucfirst($table) . " {
$properties
    public function __construct(\$data = []) {
        foreach (\$data as \$key => \$value) {
            if (property_exists(\$this, \$key)) {
                \$this->\$key = \$value;
            }
        }
    }

    public static function all() {
        global \$conn;
        \$stmt = \$conn->query(\"SELECT * FROM $table\");
        return \$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(\$id) {
        global \$conn;
        \$stmt = \$conn->prepare(\"SELECT * FROM $table WHERE id = :id\");
        \$stmt->execute(['id' => \$id]);
        return \$stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>";

    // Lưu file Model vào thư mục models
    file_put_contents("app/models/" . ucfirst($table) . ".php", $modelContent);
    echo "Tạo Model thành công: " . ucfirst($table) . ".php\n";
}
?>
