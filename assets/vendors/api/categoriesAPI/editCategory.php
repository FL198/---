<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $id=$_GET['id'];
    $name=$_GET['name'];
    $slug=$_GET['slug'];
    $sql="update categories set name='$name',slug='$slug' where id='$id'";
    my_edit($sql);
?>