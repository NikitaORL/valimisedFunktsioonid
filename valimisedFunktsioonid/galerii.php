<?php
require('config.php');
global $yhendus;


$valitud_id = $_GET['id'];

// +1 и -1 балл
if (isset($_GET['lisa1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
    $paring->bind_param('i', $_GET['lisa1punkt']);
    $paring->execute();
    header("Location: galerii.php?id=" . $_GET['lisa1punkt']);
    exit();
}
if (isset($_GET['kustuta1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param('i', $_GET['kustuta1punkt']);
    $paring->execute();
    header("Location: galerii.php?id=" . $_GET['kustuta1punkt']);
    exit();
}


if ($valitud_id && isset($_POST['uus_kommentaar'])) {
    $komment = "\n".$_POST['uus_kommentaar']."\n";
    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?");
    $paring->bind_param('si', $komment, $valitud_id);
    $paring->execute();
    header("Location: galerii.php?id=" . $valitud_id);
    exit();
}


function naitaGalerii($valitud_id = null) {
    global $yhendus;
    $paring=$yhendus->prepare("Select id, presedent, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1");
    $paring->bind_result($id, $presedent, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();

    echo "<div class='galerii'>";
    while ($paring->fetch()) {
        echo "<div class='galerii-item'>";
        echo "<a href='?id=$id'><img src='$pilt' alt='$presedent' style='max-width:200px;'></a>";
        echo "<p>$presedent</p>";


        if ($valitud_id == $id) {
            echo "<p>Punktid: $punktid</p>";
            echo "<p>Lisamisaeg: $lisamisaeg</p>";
            echo "<p><a href='?lisa1punkt=$id'>+1</a> | <a href='?kustuta1punkt=$id'>-1</a></p>";
            echo "<h4>Komentariid:</h4>";
            echo "<p>".nl2br(htmlspecialchars($kommentaarid))."</p>";
            echo "<form method='post'>
                    <input type='text' name='uus_kommentaar' required>
                    <input type='submit' value='Lisa Komentaar'>
                  </form>";
        }

        echo "</div>";
    }
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Presedenti galerii</title>
</head>
<body>
<h1>Presedenti galerii</h1>


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




<?php naitaGalerii($valitud_id); ?>
</body>
</html>
