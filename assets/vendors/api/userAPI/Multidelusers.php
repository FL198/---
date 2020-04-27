<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $ids=$_GET['ids'];
    $sql="delete from users where id in ($ids)";
    my_edit($sql);
?>