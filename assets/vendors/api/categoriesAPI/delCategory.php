<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $id=$_GET['id'];
    $sql="delete from categories where id=$id";
    my_edit($sql);
    echo json_encode($id)
?>