<?php
require_once 'config/database.php';

class Promotions
{
    public $id;
    public $name;
    public $discount_percent;
    public $discount_amount;
    public $start_date;
    public $end_date;
    public $is_active;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT * FROM promotions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM promotions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO promotions (name, discount_percent, discount_amount, start_date, end_date, code, is_active)
                                VALUES (:name, :discount_percent, :discount_amount, :start_date, :end_date, :code, :is_active)");
        $stmt->execute([
            'name' => $data['name'],
            ':discount_percent' => (float)$data['discount_percent'],
            ':discount_amount' => (float)$data['discount_amount'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'code' => $data['code'],
            'is_active' => $data['is_active']
        ]);
        return true;
    }

    public static function update($id, $data)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE promotions SET name = :name, discount_percent = :discount_percent, discount_amount = :discount_amount, start_date = :start_date, end_date = :end_date, code = :code, is_active = :is_active WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'discount_percent' => is_numeric($data['discount_percent']) ? (float)$data['discount_percent'] : 0,
            'discount_amount' => is_numeric($data['discount_amount']) ? (float)$data['discount_amount'] : 0,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'code' => $data['code'],
            'is_active' => $data['is_active']
        ]);
        return true;
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM promotions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return true;
    }

    public static function updateStatus($id, $status)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE promotions SET is_active = :is_active WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'is_active' => $status
        ]);
        return true;
    }
}
