<?php

require_once __DIR__.'/../../models/service.php';

class StaffServiceService {
    public static function createCapelli($name, $price, $duration, $desc) {
        return (new Service())->createCapelli($name, $price, $duration, $desc);
    }

    public static function createBarba($name, $price, $duration, $desc) {
        return (new Service())->createBarba($name, $price, $duration, $desc);
    }

    public static function getAll() {
        return (new Service())->getAll();
    }

    public static function get($id) {
        return (new Service())->get($id);
    }

    public static function delete($id) {
        return (new Service())->delete($id);
    }

    public static function update($id, $name, $price, $duration, $desc) {
        return (new Service())->update($id, $name, $price, $duration, $desc);
    }
}