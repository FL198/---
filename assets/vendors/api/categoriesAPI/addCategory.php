<?php
    include_once '../../php/db.php';
    $name=$_GET['name'];
    $slug=$_GET['slug'];
    $sql="insert into categories (name,slug) values ('$name','$slug')";
    my_edit($sql);
?>