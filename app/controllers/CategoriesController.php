<?php
require_once 'app/models/Categories.php';

class CategoriesController
{
    public function addCate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $data = [
                'name' => $name,
                'description' => $description
            ];

            if (Categories::create($data)) {
                header('Location: /admindashbroad?status=success&message=' . urlencode("Thêm hãng thành công!") ."#categories");
                exit;
            } else {
                header('Location: /admindashbroad?status=error&message=' . urlencode("Thêm hãng thất bại!") ."#categories");
                exit;
            }
        }
        require_once 'app/views/categories/add_category.php';
    }

    public function editCate($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode("ID không hợp lệ!")."#categories");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty($name) || empty($description)) {
                header('Location: /admindashbroad?status=error&message=' . urlencode("Vui lòng không để trống tên hoặc mô tả!") ."#categories");
                exit;
            }

            $data = [
                'name' => $name,
                'description' => $description
            ];

            if (Categories::update($id, $data)) {
                header('Location: /admindashbroad?status=success&message=' . urlencode("Cập nhật hãng thành công!") ."#categories");
                exit;
            } else {
                header('Location: /admindashbroad?status=error&message=' . urlencode("Cập nhật hãng thất bại!") ."#categories");
                exit;
            }
        }

        $category = Categories::find($id);
        require_once 'app/views/categories/edit_category.php';
    }

    public function deleteCate($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode("ID không hợp lệ!") ."#categories");
            exit;
        }

        if (Categories::hasCars($id)) {
            header('Location: /admindashbroad?status=error&message=' . urlencode("Không thể xoá hãng vì vẫn còn xe thuộc hãng này!") ."#categories");
            exit;
        }

        if (Categories::delete($id)) {
            header('Location: /admindashbroad?status=success&message=' . urlencode("Xoá hãng thành công!") ."#categories");
            exit;
        } else {
            header('Location: /admindashbroad?status=error&message=' . urlencode("Xoá hãng thất bại!") ."#categories");
            exit;
        }
    }
}
