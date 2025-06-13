<?php
require_once 'config/database.php';

class Users
{
    public $id;
    public $full_name;
    public $email;
    public $phone;
    public $password;
    public $address;
    public $role;
    public $created_at;
    public $gender;

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
        $stmt = $conn->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function where($role)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE role = :role");
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($id, $full_name, $email, $phone, $address, $gender)
    {
        global $conn;

        // Kiểm tra dữ liệu đầu vào
        if (!$id || !$full_name || !$email || !$phone || !$address || $gender === null) {
            return false;  // Nếu có trường nào không hợp lệ, trả về false
        }

        // Cập nhật thông tin người dùng
        $stmt = $conn->prepare("UPDATE users SET full_name = :full_name, email = :email, phone = :phone, address = :address, gender = :gender WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'gender' => $gender
        ]);

        return true;
    }

    public static function delete($userId)
    {
        global $conn;

        // Kiểm tra xem người dùng có dữ liệu liên quan không
        if (self::hasRelations($userId)) {
            return false; // Không thể xóa nếu có dữ liệu liên quan
        }

        // Xóa người dùng khỏi cơ sở dữ liệu
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);

        return $stmt->rowCount(); // trả về số dòng bị xóa (1 nếu thành công)
    }

    public static function login($email, $password)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

public static function register($name, $email, $password, $phone, $address, $gender)
{
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Chuyển đổi giới tính thành 0 (Nữ) hoặc 1 (Nam)
    $gender = ($gender === 'male') ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, address, role, gender) VALUES (:full_name, :email, :phone, :password, :address, :role, :gender)");
    $stmt->execute([
        'full_name' => $name,
        'email' => $email,
        'phone' => $phone,
        'password' => $hashedPassword,
        'address' => $address,
        'role' => 'customer',
        'gender' => $gender
    ]);
    return $conn->lastInsertId();
}

    public static function findByEmail($email)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($id, $hashedPassword)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashedPassword, $id]);
    }

    public static function updateByEmail($email, $hashedPassword)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }

    public static function isPhoneRegistered($phone)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE phone = :phone");
        $stmt->execute(['phone' => $phone]);
        $count = $stmt->fetchColumn();
        return $count > 0; // true nếu đã có, false nếu chưa
    }

public static function getUserIdByPhone($phone)
{
    global $conn;  // Đảm bảo sử dụng $conn thay vì $db
    $query = "SELECT TOP 1 id FROM users WHERE phone = :phone";  // Sử dụng TOP 1 thay cho LIMIT 1
    $stmt = $conn->prepare($query);  // Sử dụng $conn thay vì $db
    $stmt->bindParam(':phone', $phone);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['id'] : null;
}

    public static function updateRole($id, $role)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET role = :role WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'role' => $role
        ]);
        return $stmt->rowCount();
    }

    public static function count()
    {
        global $conn;
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public static function hasRelations($user_id)
    {
        global $conn;

        // Các bảng có liên kết với user
        $tables = [
            'orders' => 'user_id',
            'reviews' => 'user_id',
            'cart' => 'user_id',
            'favorites' => 'user_id',
            'ServiceOrders' => 'user_id',
            'TestDriveRegistration' => 'user_id',
            'HistoryViewCar' => 'user_id'
        ];

        foreach ($tables as $table => $column) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE $column = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            if ($stmt->fetchColumn() > 0) {
                return true; // Có liên kết
            }
        }

        return false; // Không có dữ liệu liên quan
    }
}
