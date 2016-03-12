<?php

require_once("http://localhost:8080/JavaBridge/java/Java.inc");
$fileName = "../fcl/futbolistas.fcl";
$FIS = Java("net.sourceforge.jFuzzyLogic.FIS");
$fis = $FIS->createFromString(file_get_contents($fileName), true);
$fis->__client->cancelProxyCreationTag = 0;
$functionBlock = $fis->getFunctionBlock(null);
if ($fis == null) {
    echo "No se puede cargar el archivo: '" . fileName . "'";
    exit();
}
$functionBlock->setVariable("edad", 33);
$functionBlock->setVariable("altura", 240);
$functionBlock->setVariable("goles", 312);
$functionBlock->setVariable("amarillas", 37);
$functionBlock->setVariable("rojas", 75);
$functionBlock->setVariable("asistencias", 80);
$functionBlock->setVariable("partidos", 345);
$functionBlock->setVariable("equipos", 12);
$functionBlock->setVariable("trofeos", 27);
$functionBlock->setVariable("nominaciones", 3);
print $functionBlock->getVariable("edad")->getMembership("joven");