<?php
  header('content-type:text/html;charset=utf-8');
  include_once '../assets/vendors/php/db.php';
  $tip=false;
  if(!empty($_GET)){
      if(empty($_GET['email'])||empty($_GET['password'])){
        $tip_info='用户名或密码未填写';
        $tip=true;
      }else{
        $tip=false;
        $email=$_GET['email'];
        $password=$_GET['password'];
        $sql="select * from users where email='$email'";
        $info=my_query($sql);
        if(!empty($info)&&$info[0]['password']==$password){
          session_start();
          $_SESSION['userid']=$info[0]['id'];
          header('location:index.php');
        }else{
          $tip_info='用户名或密码错误';
          $tip=true;
        }
      }
  }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../assets/img/default.png">
      <?php if($tip){ ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $tip_info;?>
      </div>
      <?php }?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="text" name='email' class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" name='password' class="form-control" placeholder="密码">
      </div>     
      <input  class="btn btn-primary btn-block" type="submit" value="登录" id='submit'>
    </form>
  </div>
</body>
</html>
