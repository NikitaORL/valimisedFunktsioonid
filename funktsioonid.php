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

function kustutapunkt($id){
    // -1 punkti
    global $yhendus;
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param('i', $id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



/*-----------------------------------------------------------------------------------*/
function naitaTabelKasutaja(){
    global $yhendus;
    $paring = $yhendus->prepare("SELECT id, presedent, pilt, punktid, lisamisaeg, kommentaarid FROM valimised WHERE avalik=1");
    $paring->bind_result($id, $presedent, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>{$presedent}</td>";
        echo "<td><img src='$pilt' alt='pilt' style='width:100px;'></td>";
        echo "<td>{$punktid}</td>";
        echo "<td>{$lisamisaeg}</td>";
        echo "<td><a href='?lisa1punkt=$id'>+1 punkt</a></td>";
        echo "<td><a href='?kustuta1punkt=$id'>-1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
            <form action='' method='post'>
                <input type='hidden' name='uue_komment_id' value='$id'>
                <input type='text' name='uus_kommentaar' placeholder='Kirjuta kommentaar'>
                <input type='submit' value='Lisa'>
            </form>
        </td>";
        echo "<td><a href='?KustutaKomment=$id'>Kustuta komentaar</a></td>";
        //echo "<td><a href='?kustuta=$id'> Kustuta </a></td>";
        echo "</tr>";
    }
}


function naitaTabelAdmin(){
    global $yhendus;
    $paring = $yhendus->prepare("SELECT id, presedent, pilt, punktid, lisamisaeg, avalik, kommentaarid FROM valimised");
    $paring->bind_result($id, $presedent, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid);
    $paring->execute();

    while ($paring->fetch()) {
        echo "<tr>";
        echo "<td>$presedent</td>";
        echo "<td><img src='$pilt' alt='pilt' style='max-width:50px;'></td>";
        echo "<td>$punktid</td>";
        echo "<td>$lisamisaeg</td>";
        echo "<td>$kommentaarid</td>";

        // Кнопка Näita/Peida
        if ($avalik == 1) {
            echo "<td><a href='?peida=$id'>Peida</a></td>";
            echo "<td>Näidatud</td>";
        } else {
            echo "<td><a href='?naita=$id'>Näita</a></td>";
            echo "<td>Peidatud</td>";
        }

        echo "<td><a href='?Kustuta=$id'>Kustuta</a></td>";

        echo "<td><a href='?Tuhista=$id'>Tühista</a></td>";

        echo "<td><a href='?KustutaKomment=$id'>Kustuta komentaar</a></td>";

        echo "<td><a href='?kustuta=$id'>Kustuta </a></td>";

        echo "</tr>";
    }
}
/*-------------------------------------------------------------------------------------------------*/



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


function kustutaPresident($id){
    global $yhendus;
    $paring = $yhendus->prepare("DELETE FROM  valimised  WHERE id = ?");
    $paring->bind_param('i', $id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    $yhendus->close();
}



//Kommentaar lisamine
function lisaKomentaar($id, $uus_kommentaar)
{
    global $yhendus;
    $komment2 = "\n" . $uus_kommentaar . "\n";
    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid = concat(kommentaarid, ?) WHERE id = ?");
    $paring->bind_param('si', $komment2, $id);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


//Kommentaar kustutamine
function kustutaKomment($id){
    global $yhendus;
    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid = '' WHERE id = ?");
    $paring->bind_param('i', $id);
    $paring->execute();
}



/*---------------------------ADMIN----------------------------------------------*/

function naytaPresident($id) {
    global $yhendus;

    $paring = $yhendus->prepare("UPDATE valimised SET avalik = 1 WHERE id = ?");
    $paring->bind_param('i', $id);
    $paring->execute();
}



function peidaPresident($id) {
    global $yhendus;

    $paring = $yhendus->prepare("UPDATE valimised SET avalik = 0 WHERE id = ?");
    $paring->bind_param('i', $id);
    $paring->execute();
}




function tuhistaPunktid($id) {
    global $yhendus;
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = 0 WHERE id = ?");
    $paring->bind_param('i', $id);
    $paring->execute();
}
