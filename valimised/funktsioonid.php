<?php
require ('config.php');
global $yhendus;

function lisapunkt($id){
    // +1 punkti
    global $yhendus;
        $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
        $paring->bind_param('i', $_id);
        $paring->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
}

function naitaTabel(){

    global $yhendus;
    $paring = $yhendus->prepare("Select id, presedent, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1");
    $paring->bind_result($id, $presedent, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td> {$presedent} </td>";
        echo "<td> {$punktid} </td>";
        echo "<td><a href='?lisa1punkt=$id'> +1 punkt </a></td>";
        echo "<td>";
    }
}
