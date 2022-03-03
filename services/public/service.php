<?php

require_once __DIR__.'/../../models/service.php';

class PublicServiceService {
    public static function getAll() {
        return (new Service())->getAll();
    }

    public static function getAllCapelli() {
        return (new Service())->getAllByType('capelli');
    }

    public static function getAllBarba() {
        return (new Service())->getAllByType('barba');
    }

    public static function get($id) {
        return (new Service())->get($id);
    }
}