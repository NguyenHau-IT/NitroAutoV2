<?php
class BaseController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function requireAdmin()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập bằng quyền admin để được truy cập!"));
            exit();
        }
        if ($_SESSION['user']['role'] !== 'admin') {
            header("Location: /home?status=error&message=" . urlencode("Bạn không có quyền truy cập vào trang này!"));
            exit();
        }
    }

    protected function requireLogin()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập trước!"));
            exit();
        }
    }
}
