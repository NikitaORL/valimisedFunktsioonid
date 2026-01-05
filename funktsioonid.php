<?php
require('config.php');
global $yhendus;

function lisapunkt($id){
    // +1 punkti
    global $yhendus;
        $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
        $paring->bind_param('i', $id);
        $paring->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
}

function naitaTabel(){

    global $yhendus;
    $paring = $yhendus->prepare("Select id, presedent, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1 or avalik=0");
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


//uue presidenti lisamine INSERT
function lisaPresident($presedent, $pilt, $punktid)
{
    global $yhendus;
    $paring = $yhendus->prepare("
        INSERT INTO valimised (presedent, pilt, punktid, lisamisaeg)
        VALUES (?, ?,?, NOW())"
    );
    $paring->bind_param('ssi', $presedent, $pilt, $punktid );
    $paring->execute();
    $yhendus->close();
}