<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $id=$_GET['id'];
    $sql="select * from categories where id=$id";
    $info=my_query($sql);
    echo json_encode($info);
?>