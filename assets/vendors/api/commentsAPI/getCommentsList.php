<?php
    include_once '../../php/db.php';
    header('content-type:text/html;charset=utf-8');
    $page=$_GET['page'];
    $pageSize=$_GET['pageSize'];
    $start=$page*$pageSize;
    $sql="select comments.*,posts.title from comments join posts on comments.post_id=posts.id limit $start,$pageSize";
    echo json_encode(my_query($sql));
?>