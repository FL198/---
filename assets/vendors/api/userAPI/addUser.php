<?php
    header('content-type:text/html;charset=utf-8');
    include_once '../../php/db.php';
    $info=$_POST;
    $file=$_FILES['avatar'];
    if($file['error']==0){
        $ext=strrchr($file['name'],'.');
        $newPath='headphoto/'.time().rand(1000,9999).$ext;
        move_uploaded_file($file['tmp_name'],$newPath);
        $info['avatar']='/pages/assets/vendors/api/userAPI/'.$newPath;
    };
    $slug=$info['slug'];
    $email=$info['email'];        
    $nickname=$info['nickname'];
    $password=$info['password'];
    $avatar=$info['avatar'];
    $sql="insert into users (slug,email,password,nickname,avatar) values('$slug','$email','$password','$nickname','$avatar')"; 
    my_edit($sql);
    header('location:../../../../admin/users.php');
?>