<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $info=$_POST;
    $file=$_FILES['feature'];
    if($file['error']==0){
        $ext=strrchr($file['name'],'.');
        $newPath='tmpimg/'.time().rand(1000,9999).$ext;
        move_uploaded_file($file['tmp_name'],$newPath);
        $info['feature']='../assets/vendors/api/post-addAPI/'.$newPath;
        $feature=$info['feature'];
    };
    $index=$info['index'];
    $slug=$info['slug'];
    $title=$info['title'];        
    $created=$info['created'];
    $content=$_POST['content'];
    $status=$info['status'];
    $user_id=$info['user_id'];
    $category=$info['category'];
    $sql="insert into posts (slug,title,feature,created,content,status,user_id,category_id) values('$slug','$title','$feature','$created','$content','$status','$user_id','$category')"; 
    my_edit($sql);
    header('location:../../../../admin/posts.php');
?>