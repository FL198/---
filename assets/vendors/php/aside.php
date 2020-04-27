  <?php
      include_once 'db.php';
      include_once 'checkid.php';
      session_start();
      $id=$_SESSION['userid'];
      $sql="select *from users where id='$id'";
      $info=my_query($sql);
      $article=['posts','post-add','categories'];
      $settings=['nav-menus','slides','settings'];
  ?>
  <div class="aside" style="z-index:2">
    <div class="profile">
      <img class="avatar" src=<?php echo $info[0]['avatar'];?>>
      <h3 class="name"><?php echo $info[0]['slug'];?></h3>
    </div>
    <ul class="nav">
      <li class=<?php echo ($page=='index')?'active':' ';?>>
        <a href="../admin/index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li class=<?php echo in_array($page,$article)?'active':' ';?>>
        <a href="#menu-posts" class="collapsed" data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse">
          <li><a href="../admin/posts.php">所有文章</a></li>
          <li><a href="../admin/post-add.php">写文章</a></li>
          <li><a href="../admin/categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class=<?php echo ($page=='comments')?'active':' ';?>>
        <a href="../admin/comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class=<?php echo ($page=='users')?'active':' ';?>>
        <a href="../admin/users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li class=<?php echo in_array($page,$settings)?'active':' ';?>>
        <a href="#menu-settings" class="collapsed" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse">
          <li><a href="../admin/nav-menus.php">导航菜单</a></li>
          <li><a href="../admin/slides.php">图片轮播</a></li>
          <li><a href="../admin/settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>