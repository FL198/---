<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $sql="select count(*) as total from comments join posts on comments.post_id=posts.id";
    echo json_encode(my_query($sql)[0]['total']);
?>