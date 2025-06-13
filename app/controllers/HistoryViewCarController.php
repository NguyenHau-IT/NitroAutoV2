<?php
require_once 'app/core/BaseController.php';
require_once 'config/database.php';
require_once 'app/models/HistoryViewCar.php';

class HistoryViewCarController extends BaseController
{
    public function __construct()
    {
        parent::__construct(); // đảm bảo session_start()
    }

    public function getHistory()
    {
        $this->requireLogin();

        $user_id = $_SESSION["user"]["id"];
        $histories = HistoryViewCar::getHistoryByUser($user_id);
        require_once 'app/views/cars/historyviewcar.php';
    }

    public function deleteHistory($id)
    {
        HistoryViewCar::delete($id);
        header("Location: /home");
        exit();
    }

    public function addHistory($data)
    {
        $this->requireLogin();

        $data["user_id"] = $_SESSION["user"]["id"];
        $data["ip_address"] = $_SERVER['REMOTE_ADDR'];
        $data["user_agent"] = $_SERVER['HTTP_USER_AGENT'];

        return HistoryViewCar::create($data);
    }

    public function deleteHistoryByUser($user_id)
    {
        HistoryViewCar::deleteAllByUser($user_id);
        header("Location: /home");
        exit();
    }
}
