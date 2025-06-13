<?php
require_once 'config/database.php';

class Brands
{
    public $id;
    public $name;
    public $country;
    public $logo;

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
        $stmt = $conn->query("SELECT * FROM brands ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function hasCars($brandId)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cars WHERE brand_id = :id");
        $stmt->execute(['id' => $brandId]);
        return $stmt->fetchColumn() > 0;
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM brands WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($name, $country, $logo_url)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO brands (name, country, logo) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $country, $logo_url]);
    }

    public static function getByMostOrders()
{
    global $conn;
    $stmt = $conn->query("SELECT brands.id, brands.name, brands.country, brands.logo, COUNT(order_details.id) AS order_count
                          FROM brands
                          JOIN cars ON brands.id = cars.brand_id
                          JOIN order_details ON cars.id = order_details.car_id
                          JOIN orders ON order_details.order_id = orders.id  -- Liên kết bảng orders với order_details
                          GROUP BY brands.id, brands.name, brands.country, brands.logo
                          ORDER BY order_count DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public static function update($id, $name, $country, $logo_url)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE brands SET name = ?, country = ?, logo= ? WHERE id = ?");
        return $stmt->execute([$name, $country, $logo_url, $id]);
    }

    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM brands WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return true;
    }
}
