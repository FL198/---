<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $sql="select * from categories";
    echo json_encode(my_query($sql));
?>