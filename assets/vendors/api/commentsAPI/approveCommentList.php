<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $infos=$_GET['ids'];
    $sql="update comments set status='approved' where id in ($infos) ";
    my_edit($sql);
?>