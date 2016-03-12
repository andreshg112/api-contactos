<?php

require_once('db_abstract_model_pdo.php');

class Contacto extends DBAbstractModel {

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public static function getById($id = '') {
        if ($id != ''):
            $query = "select 
* from contactos where id = '$id'";
            $result = DBAbstractModel::get_result_from_query($query);
            return $result;
        //return self::parse_this($result);
        else:
            return null;
        endif;
    }

    public static function getAll() {
        $query = "select * from contactos";
        return parent::get_all_results_from_query($query);
    }

    public function save() {
        $query = "";
        $query .= "INSERT INTO "
                . "`contactos` (`nombre`,`apellido`,`telefono`) "
                . "VALUES ('$this->nombre', '$this->apellido', '$this->telefono'); ";
        $estado = parent::execute_single_query($query);
        if ($estado) {
            $this->id = parent::$conn->lastInsertId();
        }
        parent::close_connection();
        return $estado;
    }

    public function update($id_old) {
        if (isset($id_old)) {
            if (is_null($this->id)) {
                $this->id = $id_old;
            }
            $query = "";
            $query .= "update contactos "
                    . "set nombre='$this->nombre', apellido='$this->apellido', telefono='$this->telefono'"
                    . "where id='$id_old'; ";
            $estado = parent::execute_single_query($query);
            return $estado;
        } else {
            return false;
        }
    }

    public function delete() {
        $query = "DELETE FROM contactos WHERE id = '$this->id' ";
        return self::execute_single_query($query);
    }

    function __destruct() {
        unset($this);
    }

    public static function parse_this($received) {
        $object = new Contacto();
        foreach ($received as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    public function object_this() {
        $data = new stdClass();
        $data->id = $this->id;
        $data->nombre = $this->nombre;
        $data->apellido = $this->apellido;
        $data->telefono = $this->telefono;
        return $data;
    }

}
