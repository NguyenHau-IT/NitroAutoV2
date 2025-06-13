<?php
require_once 'config/database.php';

class Accessories
{
    public $id;
    public $name;
    public $price;
    public $stock;
    public $description;
public $status;


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
        $stmt = $conn->query("SELECT * FROM accessories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

public static function allbystock()
{
    global $conn;
    $stmt = $conn->query("
        SELECT accessories.id, accessories.name, accessories.description, accessories.price, accessories.stock 
        FROM accessories
        WHERE accessories.stock > 0 AND accessories.status = 1
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function create($data)
{
     global $conn;
    $stmt = $conn->prepare("INSERT INTO accessories (name, price, stock, description) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$data['name'], $data['price'], $data['stock'], $data['description']]);
}

public static function update($id, $data)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE accessories SET name = ?, price = ?, stock = ?, description = ? WHERE id = ?");
    return $stmt->execute([$data['name'], $data['price'], $data['stock'], $data['description'], $id]);
}

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM accessories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public static function delete($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM accessories WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->rowCount() > 0; // ✅ Trả về true nếu có dòng bị xóa
}

    public static function topSelling()
{
    global $conn;
    $stmt = $conn->query("
        SELECT a.name, SUM(od.accessory_quantity) AS sold
        FROM order_details od
        JOIN accessories a ON a.id = od.accessory_id
        WHERE od.accessory_id IS NOT NULL
        GROUP BY a.name
        ORDER BY sold DESC
        OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function updateStatus($id, $status)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE accessories SET status = :status WHERE id = :id");
    return $stmt->execute([
        'status' => $status,
        'id' => $id
    ]);
}

}
