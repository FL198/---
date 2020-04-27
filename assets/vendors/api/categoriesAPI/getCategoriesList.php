<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $page=$_GET['page'];
    $pageSize=$_GET['pageSize'];
    $start=$page*$pageSize;
    $sql="select * from categories limit $start,$pageSize";
    echo json_encode(my_query($sql));
?>