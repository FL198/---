<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $id=$_GET['id'];
    $sql="select name from categories where id='$id'";
    echo json_encode(my_query($sql));
?>
