<?php

require_once __DIR__ . '/../../models/staff.php';

class StaffStaffService {
    public static function create($name, $surname) {
        return (new Staff())->create($name, $surname);
    }

    public static function getAll() {
        return (new Staff())->getAll();
    }

    public static function get($id) {
        return (new Staff())->get($id);
    }

    public static function delete($id) {
        return (new Staff())->delete($id);
    }

    public static function update($id, $name, $surname) {
        return (new Staff())->update($id, $name, $surname);
    }
}