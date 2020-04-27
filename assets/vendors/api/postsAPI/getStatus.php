<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $sql="select posts.status from posts join users where posts.user_id=users.id";
    echo json_encode(my_query($sql));
?>