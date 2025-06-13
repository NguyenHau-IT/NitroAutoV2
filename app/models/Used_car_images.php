<?php
require_once 'config/database.php';

class Used_car_images {
    public $id;
    public $used_car_id;
    public $image_url;
    public $image_type;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM used_car_images");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM used_car_images WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>