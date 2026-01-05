<?php
require ('config.php');
global $yhendus;

// +1 punkt
if (isset($_GET['lisa1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
    $paring->bind_param('i', $_GET['lisa1punkt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// -1 punkt
if (isset($_GET['kustuta1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param('i', $_GET['kustuta1punkt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// INSERT
if (!empty($_REQUEST['presedentNimi']) && !empty($_REQUEST['pilt'])) {
    $paring = $yhendus->prepare("
        INSERT INTO valimised (presedent, pilt, lisamisaeg)
        VALUES (?, ?, NOW())"
    );
    $paring->bind_param('ss', $_REQUEST['presedentNimi'], $_REQUEST['pilt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


//komentaari lisamine - update


if (isset($_REQUEST['uue_komment_id'])) {
    $paring = $yhendus->prepare("
UPDATE valimised SET kommentaarid = concat(kommentaarid, ?) WHERE id = ?");
    $komment2="\n".$_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param('si', $komment2, $_REQUEST['uue_komment_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    $yhendus->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Valimiste leht</title>
</head>
<body>
<h1>TARpv24 presedendi valimised</h1>

<nav>
    <ul>
        <li>
            <a href="valimised.php">Kasutaja leht</a>
        </li>

        <li>
            <a href="valimisedAdmin.php">Admin leht</a>
        </li>

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
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Komentaar</th>
        <th>Lisa komentaar</th>
    </tr>
    <?php
    global $yhendus;
    $paring=$yhendus->prepare("Select id, presedent, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1");
    $paring->bind_result($id, $presedent, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$presedent."</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td><a href='?lisa1punkt=$id'> +1 punkt </a></td>";
        echo "<td><a href='?kustuta1punkt=$id'> -1 punkt </a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
<form action='?' method='post'>
<input type='hidden' name='uue_komment_id' value='$id'>
<label for='uus_kommentaar'></label>
<input type='text' name='uus_kommentaar' id='uus_kommentaar'>
<input type='submit' value='ok'>
</form>

";
        echo "</tr>";
    }
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
    <input type="submit" value="Lisa">
</form>


</body>
</html>
