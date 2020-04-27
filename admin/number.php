<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../assets/vendors/php/db.php';
    $sql1="select count(*) from posts";
    $posts=my_query($sql1)[0]['count(*)'];
    $sql2="select count(*) from categories";
    $categories=my_query($sql2)[0]['count(*)'];
    $sql3="select count(*) from comments";
    $comments=my_query($sql3)[0]['count(*)'];
    $num=[
        'posts'=>$posts,
        'categories'=>$categories,
        'comments'=>$comments
    ];
    echo json_encode($num);
?>