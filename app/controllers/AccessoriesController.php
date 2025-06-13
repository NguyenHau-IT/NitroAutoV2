<?php
require_once 'app/core/BaseController.php';
require_once 'app/models/Accessories.php';

class AccessoriesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $accessories = Accessories::allbystock();
        require_once 'app/views/accessories/accessories_list.php';
    }

    public function addAccessory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description']
            ];
            $success = Accessories::create($data);
            $status = $success ? 'success' : 'error';
            $message = $success ? 'Thêm phụ kiện thành công!' : 'Thêm phụ kiện thất bại!';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#accessories");
            exit();
        }
        require_once 'app/views/accessories/accessories_form.php';
    }

    public function editAccessory($id)
    {
        $accessory = Accessories::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description']
            ];
            $success = Accessories::update($id, $data);
            $status = $success ? 'success' : 'error';
            $message = $success ? 'Cập nhật phụ kiện thành công!' : 'Cập nhật phụ kiện thất bại!';
            header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#accessories");
            exit();
        }
        require_once 'app/views/accessories/accessories_form.php';
    }

    public function deleteAccessory($id)
    {
        $success = Accessories::delete($id);
        $status = $success ? 'success' : 'error';
        $message = $success ? 'Xoá phụ kiện thành công!' : 'Xoá phụ kiện thất bại!';
        header("Location: /admindashbroad?status=$status&message=" . urlencode($message) . "#accessories");
        exit();
    }

public function updateAccessoryStatus()
{
    $id = $_POST['accessory_id'] ?? null;
    $status = $_POST['status'] ?? null; 

    if ($id !== null && $status !== null) {
        $success = Accessories::updateStatus($id, $status);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false]);
    }
}
}
