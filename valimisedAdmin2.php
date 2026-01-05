<?php
require('config.php');
require ('funktsioonid.php');
global $yhendus;



if (isset($_REQUEST['KustutaKomment'])){
    kustutaKomment($_REQUEST['KustutaKomment']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (!empty($_POST['presedentNimi']) && !empty($_POST['pilt']) && isset($_POST['avalik'])) {
    lisaPresident($_POST['presedentNimi'], $_POST['pilt'], $_POST['avalik']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



if (isset($_REQUEST['naita'])) {
    naytaPresident($_REQUEST['naita']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_REQUEST['peida'])) {
    peidaPresident($_REQUEST['peida']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_REQUEST['kustuta'])){
    kustutaPresident($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (isset($_REQUEST['Tuhista'])) {
    tuhistaPunktid($_REQUEST['Tuhista']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}



?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Valimiste leht</title>
</head>
<body>
<h1>TARpv24 presedendi valimised ADMIN</h1>

<nav>
    <ul>
        <li><a href="valimised.php">Kasutaja leht</a></li>
        <li><a href="valimisedAdmin.php">Admin leht</a></li>
        <li>
            <a href="galerii.php">Galerii leht</a>
        </li>
    </ul>
</nav>

<table>
    <tr>
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamisaeg</th>
        <th>Komentaarid</th>
        <th>Haldus</th>
        <th>Seisund</th>
        <th>Kustutamine</th>
        <th>Tühistamine</th>
        <th>Kustutamine komment</th>
    </tr>

    <?php

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

    /*ADMIN
    1. delete presedenti kandidaadi
    2. punktid nulliks
    3, ei saa +1/-1
    4.admin kohe saab lisada avalikuse staatus
    */



    ?>

</table>

<h2>Lisa oma presidenti</h2>
<form action="" method="get">
    <label for="presedentNimi">President nimi:</label>
    <input type="text" name="presedentNimi" required>
    <br>
    <label for="pilt">Presidenti pilt</label>
    <textarea name="pilt" id="pilt" required></textarea>
    <br>
    <input type="submit" value="Lisa">
    <br>

    <label for="avalik">Palun vali presedenti avalik</label><br>
    <input type="radio" name="avalik" value="0" id="avalik0" checked>
    <label for="avalik0">Peidetud</label><br>

    <input type="radio" name="avalik" value="1" id="avalik1">
    <label for="avalik1">Näidatud</label><br>
</form>

</body>
</html>
