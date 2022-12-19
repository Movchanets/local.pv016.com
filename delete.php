<?php
include($_SERVER['DOCUMENT_ROOT'] . '/options/connection_database.php');

    $id = $_GET['id'];
    print_r($id);
    $sql = 'DELETE FROM tbl_products WHERE `tbl_products`.`id` = '.$id;
    $dbh->exec($sql);
    header("Location: /");
    exit();

?>


