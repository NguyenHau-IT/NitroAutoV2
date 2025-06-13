<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/TestDriveRegistration.php';
require_once 'app/models/Cars.php';

class TestDriveController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->requireLogin();
        $testDrives = TestDriveRegistration::findByUser();
        require_once 'app/views/test_drives/test_drive_user.php';
    }

    public function Test_Drive()
    {
        $this->requireLogin();
        $cars = Cars::all();
        require_once 'app/views/test_drives/test_drive_register.php';
    }

    public function create()
    {
        $this->requireLogin();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user_id = $_SESSION["user"]["id"];
            $car_id = $_POST['car_id'] ?? null;
            $preferred_date = $_POST['preferred_date'] ?? null;
            $preferred_time = $_POST['preferred_time'] ?? null;
            $location = $_POST['location'] ?? null;

            if (!$car_id || !$preferred_date || !$preferred_time || !$location) {
                header("Location: /home?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!"));
                exit();
            }

            $result = TestDriveRegistration::create($user_id, $car_id, $preferred_date, $preferred_time, $location);
            $status = $result ? 'success' : 'error';
            $message = $result ? 'Đăng ký lái thử thành công!' : 'Đăng ký lái thử thất bại!';
            header("Location: /home?status=$status&message=" . urlencode($message));
            exit();
        }
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data = [
                'user_id' => $_POST['user_id'] ?? '',
                'car_id' => $_POST['car_id'] ?? '',
                'preferred_date' => $_POST['preferred_date'] ?? '',
                'preferred_time' => $_POST['preferred_time'] ?? '',
                'location' => $_POST['location'] ?? '',
                'status' => $_POST['status'] ?? null
            ];

            if (in_array('', $data, true)) {
                header("Location: /admindashbroad?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!") . "#test_drive");
                exit();
            }

            $result = TestDriveRegistration::update($id, $data);
            $statusText = $result ? 'success' : 'error';
            $message = $result ? 'Cập nhật lịch lái thử thành công!' : 'Cập nhật thất bại!';
            header("Location: /admindashbroad?status=$statusText&message=" . urlencode($message) . "#test_drive");
            exit();
        }

        $cars = Cars::all();
        $testDrive = TestDriveRegistration::find($id);
        require_once 'app/views/test_drives/test_drive_edit.php';
    }

    public function delete($id)
    {
        $result = TestDriveRegistration::delete($id);
        $status = $result ? 'success' : 'error';
        $message = $result ? 'Xoá lịch lái thử thành công!' : 'Xoá thất bại!';
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#test_drive");
        exit();
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');

        $test_drive_id = $_POST['test_drive_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($test_drive_id && $status) {
            $success = TestDriveRegistration::updateStatus($test_drive_id, $status);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu']);
        }
    }
}
