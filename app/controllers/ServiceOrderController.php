<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/ServiceOrder.php';
require_once 'app/models/CarServices.php';

class ServiceOrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $serviceOrders = ServiceOrder::all();
        require_once 'app/views/service_orders/service_order_list.php';
    }

    public function ServicesOrderForm()
    {
        $this->requireLogin();
        $services = CarServices::all();
        require_once 'app/views/services/add_service_order.php';
    }

    public function ServicesOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $serviceId = $_POST['service_id'] ?? null;
            $userId = $_POST['user_id'] ?? null;
            $date = $_POST['service_date'] ?? null;
            $note = $_POST['note'] ?? '';
            $status = 'Pending';

            if (!$serviceId || !$userId || !$date) {
                header("Location: /services?status=error&message=" . urlencode("Thiếu thông tin đặt lịch!"));
                exit();
            }

            $result = ServiceOrder::create($serviceId, $userId, $date, $status, $note);
            $message = $result ? 'Đặt lịch thành công!' : 'Lỗi khi đặt lịch!';
            $statusText = $result ? 'success' : 'error';
            header("Location: /services?status=$statusText&message=" . urlencode($message));
            exit();
        }
    }

    public function getByUserId()
    {
        $this->requireLogin();
        $userId = $_SESSION['user']['id'];
        $orders = ServiceOrder::getByUser($userId);
        require_once 'app/views/services/services_user.php';
    }

    public function updateStatus($orderID)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $orderID = $_POST['ServiceOrderID'] ?? $orderID;
            $status = $_POST['status'] ?? null;

            if ($orderID && $status && ServiceOrder::updateStatus($orderID, $status)) {
                header("Location: /admindashbroad?status=success&message=" . urlencode("Cập nhật trạng thái thành công!") . "#service_orders");
            } else {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Cập nhật trạng thái thất bại!") . "#service_orders");
            }
            exit();
        }

        $serviceOrder = ServiceOrder::find($orderID);
        require_once 'app/views/services/edit_service_order.php';
    }

    public function delete($orderID)
    {
        $result = ServiceOrder::delete($orderID);
        $status = $result ? "success" : "error";
        $message = $result ? "Xoá thành công!" : "Xoá thất bại!";
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#service_orders");
        exit();
    }

    public function updateServiceStatus()
    {
        header('Content-Type: application/json');

        $serviceID = $_POST['service_order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($serviceID && $status) {
            $success = ServiceOrder::updateServiceStatus($serviceID, $status);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
    }
}
