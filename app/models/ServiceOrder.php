<?php
require_once 'config/database.php'; // Kết nối cơ sở dữ liệu

class ServiceOrder
{
    public $ServiceOrderID;
    public $user_id;
    public $ServiceID;
    public $OrderDate;
    public $Note;
    public $Status;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Lấy tất cả đơn đặt dịch vụ
    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT *, ServiceOrders.Status,
                                Users.full_name AS UserFullName, 
                                CarServices.ServiceName AS ServiceName
                                FROM ServiceOrders 
                                JOIN Users ON ServiceOrders.user_id = Users.ID 
                                JOIN CarServices ON ServiceOrders.ServiceID = CarServices.ServiceID 
                                ORDER BY OrderDate DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm đơn đặt dịch vụ
    public static function create($serviceId, $userId, $date, $status = 'Pending', $note = null)
    {
        global $conn;

        $date = (new DateTime($date))->format('Y-m-d H:i:s');

        $query = "INSERT INTO ServiceOrders (user_id, ServiceID, Note, OrderDate, Status)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        return $stmt->execute([
            $userId,
            $serviceId,
            $note,
            $date,
            $status ?: 'Pending'
        ]);
    }

    // Lấy tất cả đơn đặt dịch vụ của 1 người dùng
    public static function getByUser($userID)
    {
        global $conn;
        $query = "SELECT 
                    so.ServiceOrderID AS order_id,
                    so.OrderDate AS order_date,
                    so.Note AS note,
                    so.Status AS status,
                    cs.ServiceName AS car_name,
                    cs.Price AS total_price
                  FROM ServiceOrders so
                  JOIN CarServices cs ON so.ServiceID = cs.ServiceID
                  WHERE so.user_id = ?
                  ORDER BY so.OrderDate DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy toàn bộ đơn đặt dịch vụ (cho admin)
    public function getAll()
    {
        global $conn;
        $query = "SELECT so.*, u.full_name, cs.ServiceName
                  FROM ServiceOrders so
                  JOIN Users u ON so.UserID = u.ID
                  JOIN CarServices cs ON so.ServiceID = cs.ServiceID
                  ORDER BY so.OrderDate DESC";

        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn
    public static function updateStatus($orderID, $status)
    {
        global $conn;
        $query = "UPDATE ServiceOrders SET Status = ? WHERE ServiceOrderID = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$status, $orderID]);
        return $stmt->rowCount();
    }

    // Xoá đơn
    public static function delete($orderID)
    {
        global $conn;
        $query = "DELETE FROM ServiceOrders WHERE ServiceOrderID = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$orderID]);
    }

    //tìm theo id
    public static function find($orderID)
    {
        global $conn;
        $query = "SELECT so.*, u.full_name AS UserFullName, 
              cs.ServiceName AS ServiceName
              FROM ServiceOrders so
              JOIN Users u ON so.UserID = u.ID
              JOIN CarServices cs ON so.ServiceID = cs.ServiceID
              WHERE so.ServiceOrderID = ?";

        $stmt = $conn->prepare($query);
        $stmt->execute([$orderID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateServiceStatus($orderID, $status)
    {
        global $conn;
        $query = "UPDATE ServiceOrders SET Status = ? WHERE ServiceOrderID = ?";
        $stmt = $conn->prepare($query);
        return $stmt->execute([$status, $orderID]);
    }
}
