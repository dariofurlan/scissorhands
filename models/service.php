<?php
require_once __DIR__ . "/helper.php";

class Service extends DBHelper {

    public function create($type, $name, $price, $duration, $desc) {
        $stmt = $this->prepare("INSERT INTO service (company, type, name, price, duration, description) values (1, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdis", $type, $name, $price, $duration, $desc);
        $stmt->execute();
    }

    public function createCapelli($name, $price, $duration, $desc) {
        static::create('capelli', $name, $price, $duration, $desc);
    }

    public function createBarba($name, $price, $duration, $desc) {
        static::create('barba', $name, $price, $duration, $desc);
    }

    public function getAll() {
        $stmt = $this->prepare("SELECT * FROM service WHERE company = 1 ORDER BY _id DESC");
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllByType($type) {
        $stmt = $this->prepare("SELECT * FROM service WHERE company = 1 AND type = ? ORDER BY _id DESC");
        $stmt->bind_param("s", $type);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function get($id) {
        $stmt = $this->prepare("SELECT * FROM service WHERE company = 1 AND _id = ? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function update($id, $name, $price, $duration, $desc) {
        $stmt = $this->prepare("UPDATE service SET name=?, price = ?, duration = ?, description = ? WHERE _id = ?");
        
        $stmt->bind_param("sdisi", $name, $price, $duration, $desc, $id);

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        };
    }

    public function delete($id) {
        $stmt = $this->prepare("DELETE FROM service WHERE _id = ?");
        $stmt->bind_param("i",  $id);
        try {
        $stmt->execute();
        } catch (Exception $err) {
            if ($stmt->errno === 1451) throw new CantDeleteServiceError();
            else throw $err;
    }
}
}
