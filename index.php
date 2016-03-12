<?php

require_once 'cors.php';
require_once 'db.php';
require_once 'Slim/Slim.php';
require_once './model/Contacto.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->get("/", function(){
    echo "Raíz";
});
$app->get("/contactos", "get_futbolistas");
$app->get("/contactos/:id", "get_futbolista_by_id");
$app->post("/contactos", "save_futbolista");
$app->put("/contactos/:id", "update_futbolista");
$app->delete("/contactos/:id", "delete_futbolista");

$app->run();

function get_futbolistas() {
    try {
        echo '{"result": ' . json_encode(Contacto::getAll()) . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function get_futbolista_by_id($id) {
    try {
        $futbolista = Contacto::getById($id);
        echo '{"result": ' . json_encode($futbolista) . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function update_futbolista($id) {
    $request = \Slim\Slim::getInstance()->request();
    $received = json_decode($request->getBody());
    try {
        $futbolista = Contacto::parse_this($received);
        $tuvo_exito = $futbolista->update($id);
        echo '{"result": ' . json_encode($futbolista->object_this()) . ', "tuvo_exito": ' . $tuvo_exito . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function delete_futbolista($id) {
    try {
        $futbolista = new Contacto();
        $futbolista->id = $id;
        echo '{"result": ' . $futbolista->delete() . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function save_futbolista() {
    $request = \Slim\Slim::getInstance()->request();
    $received = json_decode($request->getBody());
    try {
        $futbolista = Contacto::parse_this($received);
        $tuvo_exito = $futbolista->save();
        echo '{"result": ' . json_encode($futbolista->object_this()) . ', "tuvo_exito": ' . $tuvo_exito . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}