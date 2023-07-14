<?php

class DatabaseConnection {

    static function connect() {
        return new DB\SQL(
            'mysql:host=localhost;port=3306;dbname=sedin111_SimpleModel',
            'sedin111_s2046846',
            'Jth@1998315'
        );
    }

}
