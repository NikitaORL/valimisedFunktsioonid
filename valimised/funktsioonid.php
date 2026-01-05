<?php
require ('config.php');
global $yhendus;

function lisapunkt($id){
    // +1 punkt
    global $yhendus;
        $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
        $paring->bind_param('i', $_id);
        $paring->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
}
