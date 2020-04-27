<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $id=$_GET['id'];
    $sql="update comments set status='approved' where id=$id";
    my_edit($sql);
?>