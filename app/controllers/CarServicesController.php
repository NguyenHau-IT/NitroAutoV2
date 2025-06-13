<?php
require_once 'app/models/CarServices.php';

class CarServicesController
{
    public function index()
    {
        $services = CarServices::all();
        require_once 'app/views/services/service_list.php';
    }

    public function addServiceForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $ServiceName = trim($_POST['service_name'] ?? '');
            $Description = trim($_POST['description'] ?? '');
            $Price = $_POST['price'] ?? '';
            $EstimatedTime = $_POST['estimated_time'] ?? '';
            $Status = $_POST['status'] ?? '';

            if (!$ServiceName || !$Description || !$Price || !$EstimatedTime || $Status === '') {
                header("Location: /admindashbroad#car_services?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!"));
                exit();
            }

            $success = CarServices::create($ServiceName, $Description, $Price, $EstimatedTime, $Status);
            $message = $success ? "Thêm dịch vụ thành công!" : "Thêm dịch vụ thất bại!";
            $status = $success ? "success" : "error";

            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#car_services");
            exit();
        }

        require_once 'app/views/services/add_service.php';
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $ServiceID = $_POST['service_id'];
            $ServiceName = trim($_POST['service_name'] ?? '');
            $Description = trim($_POST['description'] ?? '');
            $Price = $_POST['price'] ?? '';
            $EstimatedTime = $_POST['estimated_time'] ?? '';
            $Status = $_POST['status'] ?? '';

            if (!$ServiceName || !$Description || !$Price || !$EstimatedTime || $Status === '') {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!") . "#car_services");
                exit();
            }

            $success = CarServices::update($ServiceID, $ServiceName, $Description, $Price, $EstimatedTime, $Status);
            $message = $success ? "Cập nhật dịch vụ thành công!" : "Cập nhật dịch vụ thất bại!";
            $status = $success ? "success" : "error";

            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#car_services");
            exit();
        }

        $service = CarServices::find($id);
        require_once 'app/views/services/edit_service.php';
    }

public function delete($id)
{
    // Kiểm tra nếu dịch vụ đã có trong đơn hàng
    if (CarServices::hasOrder($id)) {
        $message = "Không thể xoá dịch vụ vì đang được sử dụng trong đơn hàng!";
        $status = "error";
    } else {
        // Nếu không có đơn hàng liên quan, thì cho phép xoá
        $success = CarServices::delete($id);
        $message = $success ? "Xoá dịch vụ thành công!" : "Xoá dịch vụ thất bại!";
        $status = $success ? "success" : "error";
    }

    // Redirect kèm thông báo
    header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#car_services");
    exit();
}

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service_id = $_POST['Services_id'] ?? null;
            $is_active = $_POST['is_active'] ?? null;

            if ($service_id !== null && $is_active !== null) {
                $success = CarServices::updateStatus((int)$service_id, (int)$is_active);
                echo json_encode(['success' => $success]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
    }
}
