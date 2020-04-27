<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $index=$_GET['id'];
    $data=['index'=>$index];
    $sql="select posts.id from posts join users on posts.user_id=users.id";
    my_edit($sql);
?>