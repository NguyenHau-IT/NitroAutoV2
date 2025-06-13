<?php
require_once 'config/database.php';

class Car_images {
    public $id;
    public $car_id;
    public $image_url;
    public $image_type;

    public function __construct($data = []) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
?>