<?php
require_once 'config/database.php';

class CarServices
{
    public $ServiceID;
    public $ServiceName;
    public $Description;
    public $Price;
    public $EstimatedTime;
    public $Status;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public static function all()
    {
        global $conn;
        $stmt = $conn->query("SELECT 
                            ServiceID, 
                            ServiceName, 
                            Description, 
                            Price, 
                            EstimatedTime, 
                            Status  
                            FROM CarServices WHERE Status = 1 ORDER BY ServiceID ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function alladmin()
    {
        global $conn;
        $stmt = $conn->query("SELECT 
                            ServiceID, 
                            ServiceName, 
                            Description, 
                            Price, 
                            EstimatedTime, 
                            Status  
                            FROM CarServices ORDER BY ServiceID ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM CarServices WHERE ServiceID = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($ServiceName, $Description, $Price, $EstimatedTime, $Status)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO CarServices (ServiceName, Description, Price, EstimatedTime, Status) VALUES (:ServiceName, :Description, :Price, :EstimatedTime, :Status)");
        return $stmt->execute([
            'ServiceName' => $ServiceName,
            'Description' => $Description,
            'Price' => $Price,
            'EstimatedTime' => $EstimatedTime,
            'Status' => $Status
        ]);
    }

    public static function update($ServiceID, $ServiceName, $Description, $Price, $EstimatedTime, $Status)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE CarServices SET ServiceName = :ServiceName, Description = :Description, Price = :Price, EstimatedTime = :EstimatedTime, Status = :Status WHERE ServiceID = :ServiceID");
        return $stmt->execute([
            'ServiceID' => $ServiceID,
            'ServiceName' => $ServiceName,
            'Description' => $Description,
            'Price' => $Price,
            'EstimatedTime' => $EstimatedTime,
            'Status' => $Status
        ]);
    }

    public static function delete($ServiceID)
    {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM CarServices WHERE ServiceID = :ServiceID");
        $stmt->execute(['ServiceID' => $ServiceID]);
        return true;
    }

    public static function updateStatus($service_id, $is_active)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE CarServices SET Status = :is_active WHERE ServiceID = :service_id");
        return $stmt->execute([
            'service_id' => $service_id,
            'is_active' => $is_active
        ]);
    }
   
public static function hasOrder($id)
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT COUNT(*) 
        FROM ServiceOrders 
        WHERE ServiceID = :id
    ");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn() > 0;
}

}
