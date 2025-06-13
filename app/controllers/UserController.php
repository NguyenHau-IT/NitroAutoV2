<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Users.php';

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = Users::all();
        require_once 'app/views/user.php';
    }

    public function userById()
    {
        $this->requireLogin();
        $id = $_SESSION['user']['id'];
        $user = Users::find($id);
        require_once 'app/views/user/profile.php';
    }

    public function editProfile()
    {
        $this->requireLogin();
        $id = $_SESSION["user"]["id"];
        $user = Users::find($id);
        require_once 'app/views/user/edit_profile.php';
    }

    public function updateProfile()
{
    $this->requireLogin();
    $id = $_SESSION["user"]["id"];

    $full_name = $_POST['full_name'] ?? '';
    $email     = $_POST['email'] ?? '';
    $phone     = $_POST['phone'] ?? '';
    $address   = $_POST['address'] ?? '';
    $gender    = $_POST['gender'] ?? '';

    if (!$full_name || !$email || !$phone || !$address || $gender === '') {
        $this->redirectWithMessage("/edit_profile", "error", "Vui lòng điền đầy đủ thông tin!");
    }
    
    // Kiểm tra xem số điện thoại đã được đăng ký cho một người dùng khác chưa
    if (Users::isPhoneRegistered($phone) && Users::getUserIdByPhone($phone) !== $id) {
        $this->redirectWithMessage("/profile", "warning", "Số điện thoại đã được sử dụng!");
    }

    // Cập nhật thông tin người dùng
    if (Users::update($id, $full_name, $email, $phone, $address, $gender)) {
        $_SESSION['user'] = Users::find($id);
        $this->redirectWithMessage("/profile", "success", "Cập nhật thông tin thành công!");
    } else {
        $this->redirectWithMessage("/profile", "error", "Cập nhật thông tin thất bại!");
    }
}

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $full_name = $_POST['full_name'] ?? '';
            $email     = $_POST['email'] ?? '';
            $password  = $_POST['password'] ?? '';
            $phone     = $_POST['phone'] ?? '';
            $address   = $_POST['address'] ?? '';
            $gender = $_POST['gender'] ?? '';

            if (!$full_name || !$email || !$password || !$phone || !$address || $gender === '') {
                $this->redirectWithMessage("/admindashbroad", "error", "Thiếu thông tin!");
            }

            if (Users::isPhoneRegistered($phone)) {
                $this->redirectWithMessage("/admindashbroad", "warning", "Số điện thoại đã được sử dụng!");
            }

            $success = Users::register($full_name, $email, $password, $phone, $address, $gender);
            $status = $success ? 'success' : 'error';
            $message = $success ? 'Thêm người dùng thành công!' : 'Thêm người dùng thất bại!';

            $this->redirectWithMessage("/admindashbroad", $status, $message);
        }

        require_once 'app/views/user/register.php';
    }

    public function deleteUser($id)
    {
        if (Users::hasRelations($id)) {
            $status = 'warning';
            $message = 'Không thể xóa người dùng vì có dữ liệu liên quan!';
        } else {
            $success = Users::delete($id);
            $status = $success ? 'success' : 'error';
            $message = $success ? 'Đã xoá người dùng!' : 'Xoá người dùng thất bại!';
        }

        $this->redirectWithMessage("/admindashbroad", $status, $message);
    }

    public function editUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $id = $_POST['id'] ?? '';
            $role = $_POST['role'] ?? '';

            $success = Users::updateRole($id, $role);
            $status = $success ? 'success' : 'error';
            $message = $success ? 'Cập nhật vai trò thành công!' : 'Cập nhật vai trò thất bại!';

            if ($_SESSION['user']['id'] == $id) {
                $_SESSION['user'] = Users::find($id);
            }

            $this->redirectWithMessage("/admindashbroad", $status, $message);
        }

        $user = Users::find($id);
        require_once 'app/views/user/edit_user.php';
    }

    private function redirectWithMessage($url, $status, $message)
    {
        header("Location: $url?status=$status&message=" . urlencode($message));
        exit();
    }
}
