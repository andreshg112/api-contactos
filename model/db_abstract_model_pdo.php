<?php

abstract class DBAbstractModel {

    private static $db_host = 'localhost';
    private static $db_user = 'root';
    private static $db_pass = '';
    protected static $db_name = 'bd_contactos';
    //protected $query;
    //protected $rows = array();
    protected static $conn;
    //protected $last_insert_id = null;

    abstract protected function save();

    abstract protected function update($pk);

    abstract protected function delete();

    //abstract public function parse_this($received);

    //Retorna un objeto estandar (instancia de stdClass) para que pueda ser codificado por json_encode($object);
    abstract public function object_this();

    private static function open_connection() {
        self::$conn = new PDO('mysql:host=' . self::$db_host . ';dbname=' . self::$db_name . ';charset=utf8', self::$db_user, self::$db_pass);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

# Desconectar la base de datos

    protected static function close_connection() {
        self::$conn = null;
    }

# Ejecutar un query simple del tipo INSERT, DELETE, UPDATE

    protected static function execute_single_query($query) {
        self::open_connection();
        $cmd = self::$conn->prepare($query);
        $estado = $cmd->execute();
        return $estado;
    }

# Traer resultados de una consulta en un Array

    protected static function get_result_from_query($query) {
        self::open_connection();
        $consulta = self::$conn->prepare($query);
        $consulta->execute();
        $row = $consulta->fetchObject();
        self::close_connection();
        return $row;
    }

    protected static function get_all_results_from_query($query) {
        self::open_connection();
        $consulta = self::$conn->prepare($query);
        $consulta->execute();
        $rows = $consulta->fetchAll(PDO::FETCH_OBJ);
        self::close_connection();
        return $rows;
    }

}
