<?php

class ReservationPendingError extends Error {
    public function __construct(){
        parent::__construct("Impossibile prenotare, in attesa della conferma della precedente prenotazione.");
    }
}

class ReservationSlotsError extends Error {
    public function __construct() {
        parent::__construct("Orario Prenotazione Non Valido");
    }
}

class CantDeleteServiceError extends Error {
    public function __construct() {
        parent::__construct("Impossibile eliminare un servizio per il quale son presenti prenotazioni");
    }
}