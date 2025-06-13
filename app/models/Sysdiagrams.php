<?php
require_once '../config/database.php';

class Sysdiagrams {
    public $name;
    public $principal_id;
    public $diagram_id;
    public $version;
    public $definition;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all() {
        global $conn;
        $stmt = $conn->query("SELECT * FROM sysdiagrams");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM sysdiagrams WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>