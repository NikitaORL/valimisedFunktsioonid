<?php
require ('funktsioonid.php');


if (isset($_REQUEST['KustutaKomment'])){
    kustutaKomment($_REQUEST['KustutaKomment']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}




if (isset($_REQUEST['uue_komment_id']) && !empty($_REQUEST['uus_kommentaar'])){
    lisaKomentaar($_REQUEST['uue_komment_id'], $_REQUEST['uus_kommentaar']);
}



if (isset($_REQUEST['kustuta'])){
    kustutaPresident($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// päringud funktsioonide otsimiseks failis funktsioonid.php
if (isset($_REQUEST['lisa1punkt'])){
    lisapunkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//kustutab komentaar
if (isset($_REQUEST['kustuta1punkt'])){
    kustutapunkt($_REQUEST['kustuta1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



//paring lisaPresident funktsiooni otsimiseks
if (!empty($_REQUEST['presedentNimi'])) {
    lisaPresident($_REQUEST['presedentNimi'], $_REQUEST['pilt'], $_REQUEST['punktid']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>

    </title>
</head>
<body>
<h1>Tabel Valimised kirjatud funktsioonide abil</h1>
<table>
    <tr>
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Komentaar</th>
        <th>Lisa kommentaar</th>
        <th>Kustuta kommentaar</th>
    </tr>


    <?php
    //funktsioon mis näitab tabeli asub funktsioonid.php failis
    naitaTabelKasutaja();
    ?>
</table>

<h2>Lisa oma presidenti</h2>
<form action="">
    <label for="presedentNimi">President nimi:</label>
    <input type="text" name="presedentNimi">
    <br>
    <label for="pilt">Presidenti pilt</label>
    <textarea name="pilt" id="pilt"></textarea>
    <br>
    <label for="punktid">Presedenti punktid</label>
    <textarea name="punktid" id="punktid"></textarea>
    <br>
    <input type="submit" value="Lisa">
</form>


</body>
</html>