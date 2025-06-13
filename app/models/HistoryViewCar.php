<?php
class HistoryViewCar
{
    // Thuộc tính
    public $id;
    public $user_id;
    public $car_id;
    public $view_time;
    public $ip_address;
    public $user_agent;

    public static function create($data)
    {
        global $conn;

        $checkQuery = "SELECT COUNT(*) FROM HistoryViewCar WHERE user_id = :user_id AND car_id = :car_id";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
        $checkStmt->bindValue(":car_id", $data["car_id"], PDO::PARAM_INT);
        $checkStmt->execute();

        $exists = $checkStmt->fetchColumn(); // Lấy số lượng bản ghi tìm thấy

        if ($exists > 0) {
            $updateQuery = "UPDATE HistoryViewCar 
                            SET view_time = GETDATE(), ip_address = :ip_address, user_agent = :user_agent
                            WHERE user_id = :user_id AND car_id = :car_id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
            $updateStmt->bindValue(":car_id", $data["car_id"], PDO::PARAM_INT);
            $updateStmt->bindValue(":ip_address", $data["ip_address"], PDO::PARAM_STR);
            $updateStmt->bindValue(":user_agent", $data["user_agent"], PDO::PARAM_STR);

            return $updateStmt->execute();
        }

        // Nếu chưa tồn tại, thêm mới
        $insertQuery = "INSERT INTO HistoryViewCar (user_id, car_id, view_time, ip_address, user_agent) 
                        VALUES (:user_id, :car_id, GETDATE(), :ip_address, :user_agent)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindValue(":user_id", $data["user_id"], PDO::PARAM_INT);
        $insertStmt->bindValue(":car_id", $data["car_id"], PDO::PARAM_INT);
        $insertStmt->bindValue(":ip_address", $data["ip_address"], PDO::PARAM_STR);
        $insertStmt->bindValue(":user_agent", $data["user_agent"], PDO::PARAM_STR);

        return $insertStmt->execute();
    }

    public static function getHistoryByUser($user_id)
    {
        global $conn;

        $stmt = $conn->prepare("SELECT hvc.id AS hvc_id,c.stock AS stock, c.id AS car_id, ci.image_url AS image_url, c.name AS car_name, hvc.view_time, hvc.ip_address, hvc.user_agent 
                  FROM HistoryViewCar hvc
                  JOIN cars c ON hvc.car_id = c.id
                  JOIN car_images ci ON c.id = ci.car_id AND ci.image_type = 'normal'
                  WHERE hvc.user_id = ?
                  ORDER BY hvc.view_time DESC");
        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xoá lịch sử xem xe theo ID
    public static function delete($id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM HistoryViewCar WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    //xoá tất cả lịch sử xem xe của user
    public static function deleteAllByUser($user_id)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM HistoryViewCar WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $user_id]);
    }
}
