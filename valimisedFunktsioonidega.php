<?php
require ('funktsioonid.php');
// päringud funktsioonide otsimiseks failis funktsioonid.php
if (isset($_REQUEST['lisa1punkt'])){
    lisapunkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
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
        <th>Lisa komentaar</th>
    </tr>

    <?php
    //funktsioon mis näitab tabeli asub funktsioonid.php failis
    naitaTabel();
    ?>

</body>
</html>