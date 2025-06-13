<?php
require_once 'config/database.php';

class Banner
{
    public $id;
    public $image_url;
    public $created_at;
    public $type;
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
        $stmt = $conn->query("SELECT * FROM banners ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM banners WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 📌 1️⃣ Lấy danh sách tất cả banner
    public static function getAllBanners()
    {
        global $conn;
        $stmt = $conn->query("SELECT * FROM banners WHERE type = 'slide' AND is_active = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function banner_left()
    {
        global $conn;
        $stmt = $conn->query("SELECT TOP 1 * FROM banners WHERE type = 'left' AND is_active = 1 ORDER BY created_at DESC");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function banner_right()
    {
        global $conn;
        $stmt = $conn->query("SELECT TOP 1 * FROM banners WHERE type = 'right' AND is_active = 1 ORDER BY created_at DESC");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public static function updateBannerStatus($banner_id, $new_status)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE banners SET is_active = :new_status WHERE id = :id");
        $stmt->execute([
            'new_status' => $new_status,
            'id' => $banner_id
        ]);
        return true;
    }
    
    public static function deleteBanner($banner_id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM banners WHERE id = :id");
        $stmt->execute(['id' => $banner_id]);
    }

    public static function createBanner($data)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO banners (image_url, created_at, type, is_active) VALUES (:image_url, :created_at, :type, :is_active)");
        $stmt->execute([
            'image_url' => $data['image_url'],
            'created_at' => $data['created_at'],
            'type' => $data['type'],
            'is_active' => isset($data['is_active']) ? 1 : 0
        ]);
        return true;
    }

    public static function updateBanner($id, $data)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE banners SET image_url = :image_url, type = :type, is_active = :is_active WHERE id = :id");
        $stmt->execute([
            'image_url' => $data['image_url'],
            'type' => $data['type'],
            'is_active' => isset($data['is_active']) ? 1 : 0,
            'id' => $id
        ]);
        return true;
    }
}
