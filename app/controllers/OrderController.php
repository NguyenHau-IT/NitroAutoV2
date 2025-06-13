<?php
require_once 'app/core/BaseController.php';
require_once 'config/database.php';
require_once 'app/models/Orders.php';
require_once 'app/models/Cars.php';
require_once 'app/models/Accessories.php';
require_once 'app/models/Users.php';
require_once 'app/models/Order_details.php';
require_once 'app/services/MailService.php';

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function OrderForm()
    {
        $this->requireLogin();
        $cars = Cars::allbystock();
        $accessories = Accessories::allbystock();
        require_once 'app/views/orders/order.php';
    }

    public function Order()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->requireLogin();
            $user_id = $_SESSION['user']['id'];

            $car_id = $_POST['car_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            $accessory_id = $_POST['accessory_id'] ?? null;
            $accessory_quantity = $_POST['accessory_quantity'] ?? null;
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $total = $_POST['total_price'] ?? 0;

            $hasCar = $car_id && $quantity > 0 || $quantity != null;
            $hasAccessory = $accessory_id && $accessory_quantity > 0 || $accessory_quantity != null;

            if (!$hasCar && !$hasAccessory) {
                header("Location: /OrderForm?status=error&message=" . urlencode("Vui lòng chọn xe hoặc phụ kiện!"));
                exit();
            }

            $user = Users::find($user_id);
            if (!$user) {
                header("Location: /error?status=error&message=" . urlencode("Tài khoản không tồn tại!"));
                exit();
            }

            if (empty($address)) $address = $user['address'] ?? '';
            if (empty($phone)) $phone = $user['phone'] ?? '';
            $email = $user['email'] ?? '';

            $car = $hasCar ? Cars::find($car_id) : null;
            $accessory = $hasAccessory ? Accessories::find($accessory_id) : null;

            $result = Orders::create($user_id, $car_id, $quantity, $accessory_id, $accessory_quantity, $address, $phone, $total);

            if ($result) {
                $orderDetails = [
                    'date' => date('d/m/Y'),
                    'customer' => $user['full_name'] ?? 'Khách hàng',
                    'total' => number_format($total, 0, ',', '.') . 'đ',
                    'car' => $car ? [
                        'name' => $car['name'],
                        'quantity' => $quantity,
                        'price' => number_format($car['price'], 0, ',', '.') . 'đ'
                    ] : null,
                    'accessory' => $accessory ? [
                        'name' => $accessory['name'],
                        'quantity' => $accessory_quantity,
                        'price' => number_format($accessory['price'], 0, ',', '.') . 'đ'
                    ] : null
                ];

                if (!empty($email)) {
                    MailService::sendOrderConfirmation($email, $orderDetails);
                }

                header("Location: /home?status=success&message=" . urlencode("Bạn đã đặt mua thành công!"));
            } else {
                header("Location: /OrderForm?status=error&message=" . urlencode("Bạn đã đặt mua thất bại!"));
            }
            exit();
        }
    }

    public function getUserOrders()
    {
        $this->requireLogin();
        global $conn;

        $user_id = $_SESSION["user"]["id"];
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';

        $query = "
            SELECT 
                o.id AS order_id, o.order_date, o.status, o.total_amount AS total_price,
                u.full_name AS user_name,
                od.car_id, c.name AS car_name, od.quantity,
                od.accessory_id, a.name AS accessory_name, od.accessory_quantity,
                a.price AS accessory_price, od.accessory_total, od.subtotal
            FROM orders o
            JOIN users u ON o.user_id = u.id
            JOIN order_details od ON o.id = od.order_id
            LEFT JOIN cars c ON od.car_id = c.id
            LEFT JOIN accessories a ON od.accessory_id = a.id
            WHERE o.user_id = :user_id
        ";

        if ($startDate) $query .= " AND o.order_date >= :startDate";
        if ($endDate) $query .= " AND o.order_date <= :endDate";
        $query .= " ORDER BY o.order_date DESC";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        if ($startDate) $stmt->bindParam(':startDate', $startDate);
        if ($endDate) $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        $orders = $stmt->fetchAll();

        $groupedOrders = [];
        foreach ($orders as $order) {
            $orderId = $order['order_id'];
            if (!isset($groupedOrders[$orderId])) {
                $groupedOrders[$orderId] = [
                    'order_id' => $order['order_id'],
                    'order_date' => $order['order_date'],
                    'status' => $order['status'],
                    'total_price' => $order['total_price'],
                    'items' => [],
                ];
            }
            $groupedOrders[$orderId]['items'][] = [
                'car_name' => $order['car_name'],
                'quantity' => $order['quantity'],
                'accessory_name' => $order['accessory_name'],
                'accessory_quantity' => $order['accessory_quantity'],
            ];
        }

        require_once 'app/views/orders/order_list.php';
    }

    public function orderDetail($id)
    {
        $order = Orders::getOrderById($id);
        if (!$order) {
            header("Location: /user_orders?status=error&message=" . urlencode("Không tìm thấy đơn hàng!"));
            exit();
        }
        require_once 'app/views/orders/order_detail.php';
    }

    public function order_edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['order_id'];
            $status = $_POST['order_status'];

            if (Orders::updateStatus($id, $status)) {
                header("Location: /admindashbroad?status=success&message=" . urlencode("Cập nhật trạng thái đơn hàng thành công!") . "#orders");
            } else {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Cập nhật đơn hàng thất bại!") . "#orders");
            }
            exit();
        }

        $order = Orders::getOrderById($id);
        if (!$order) {
            header("Location: /admindashbroad?status=error&message=" . urlencode("Không tìm thấy đơn hàng!") . "#orders");
            exit();
        }

        require_once 'app/views/orders/order_edit.php';
    }

    public function deleteOrder($id)
    {
        $success = Orders::delete($id);
        $status = $success ? "success" : "error";
        $message = $success ? "Đã xoá đơn hàng!" : "Xoá đơn hàng thất bại!";
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#orders");
        exit();
    }

    public function updateOrderStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $orderId = $_POST['order_id'] ?? null;
            $status = $_POST['status'] ?? null;

            $success = $orderId && $status && Orders::updateStatus($orderId, $status);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
