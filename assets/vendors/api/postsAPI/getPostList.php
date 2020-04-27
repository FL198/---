<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $page=$_GET['page'];
    $pageSize=$_GET['pageSize'];
    $start=$page*$pageSize;
    $sql="select posts.*,categories.name,users.nickname from posts join categories on posts.category_id=categories.id join users on posts.user_id=users.id order by id desc limit $start,$pageSize";
    echo json_encode(my_query($sql));
?>
