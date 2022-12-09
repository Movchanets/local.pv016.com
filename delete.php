<?php
$id =  $_POST['id'];
try {
    $user = "root";
    $pass = "";
    $dbh = new PDO('mysql:host=localhost;dbname=pv016', $user, $pass);
    $sql = "DELETE FROM tbl_products WHERE id=".$id;
    $dbh->exec($sql);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$dbh = null;
?>