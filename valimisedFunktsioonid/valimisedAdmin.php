<?php
require('config.php');
global $yhendus;


// INSERT
if (!empty($_REQUEST['presedentNimi']) && !empty($_REQUEST['pilt']) && isset($_REQUEST['avalik'])) {
    $paring = $yhendus->prepare("
        INSERT INTO valimised (presedent, pilt, avalik, lisamisaeg)
        VALUES (?, ?, ?, NOW())
    ");
    $paring->bind_param('ssi', $_REQUEST['presedentNimi'], $_REQUEST['pilt'], $_REQUEST['avalik']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// Näita
if (isset($_REQUEST['naita'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET avalik = 1 WHERE id = ?");
    $paring->bind_param('i', $_REQUEST['naita']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Peida
if (isset($_REQUEST['peida'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET avalik = 0 WHERE id = ?");
    $paring->bind_param('i', $_REQUEST['peida']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['Kustuta'])){
    $paring = $yhendus->prepare("Delete from valimised where id = ?");
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if(isset($_REQUEST['Tühista'])){
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = 0 WHERE id = ?");
    $paring->bind_param('i', $_REQUEST['Tühista']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//kustuta komment
if (isset($_REQUEST['KustutaKomment'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid = ' ' WHERE id = ?");
    $paring->bind_param('i', $_REQUEST['KustutaKomment']);
    $paring->execute();
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

        echo "<td><a href='?Tühista=$id'>Tühista</a></td>";

        echo "<td><a href='?KustutaKomment=$id'>Kustuta komentaar</a></td>";

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
