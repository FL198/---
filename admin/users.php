  <?php
  header('content-type:text/html;charset=utf-8');
      $page='users';
      include_once '../assets/vendors/php/aside.php';
  ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/pagination.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php include_once '../assets/vendors/php/navbar.php';?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form action='../assets/vendors/api/userAPI/addUser.php' method="post" enctype="multipart/form-data"·>
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong id='slugName'>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <label for="avatar">头像</label>
              <img class="help-block thumbnail" style="display: none; width:80">
              <input id="avatar" class="form-control" name="avatar" type="file" accept="image/*">
            </div>
            <div class="form-group">              
              <input class="btn btn-primary addBtn" type="submit" value="添加">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none" id="deleteBtn">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox" class='checkAll'></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
          <div id="pagination"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/jquery/jquery.pagination.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/jquery/template-web.js"></script>
  <script>NProgress.done()</script>
  <script>
    var obj={
      'activated':'已激活',
      'unactivated':'未激活',
      'forbidden':'禁止',
      'trashed':'回收站'
    };
  </script>
  <script type="text/html" id="tmp">
    {{each list v i}}
    <tr>
        <td class="text-center"><input type="checkbox" class='list-checkbox' value={{v.id}}></td>
        <td class="text-center"><img class="avatar" src="{{v.avatar}}"></td>
        <td>{{v.email}}</td>
        <td>{{v.slug}}</td>
        <td>{{v.nickname}}</td>
        <td>{{status[v.status]}}</td>
        <td class="text-right" edit-id={{v.id}}>
          <a href="post-add.php" class="btn btn-default btn-xs del-edit">编辑</a>
          {{if v.status!='trashed'}}
          <a href="javascript:;" class="btn btn-danger btn-xs del-btn">删除</a>
          {{/if}}
        </td>
    </tr>
    {{/each}}
  </script>
  <script>
    $('#slug').on('input',function(){
      $('#slugName').text($(this).val())
    })
    var page=0,pageSize=7;
    //获取分类列表
    function pageChange(page,pageSize){
      $.ajax({
        url:'../assets/vendors/api/userAPI/getUserList.php',
        data:{page,pageSize},
        dataType:'json',
        success:function(info){
          var htmlStr=template('tmp',{list:info,status:obj})
          $("tbody").html(htmlStr)
        }
      })
    }
    function render(){
    $.ajax({
      url:'../assets/vendors/api/userAPI/getCount.php',
      dataType:'json',
      success:function(info){
        var pageCount=info;
        $("#pagination").pagination(pageCount,    //分布总数量，必须参数
          {
　　　　　　 callback: PageCallback,  //PageCallback() 为翻页调用次函数。
            prev_text: "« 上一页",
            next_text: "下一页 »",
            items_per_page:pageSize,
            num_edge_entries: 2,       //两侧首尾分页条目数
            num_display_entries: 5,    //连续分页主体部分分页条目数
            current_page: 0,   //当前页索引
　　　    });
      }
    })
  }
  render();
  function PageCallback(index){
      page=index;
      pageChange(page,pageSize)
  }
  //全选按钮控制
  $('.checkAll').on('click',function(){
    var status=$(this).prop('checked');
    $('.list-checkbox').prop('checked',status);
    if(status){
      $('#deleteBtn').show()
    }else{
      $('#deleteBtn').hide()
    }
  })
  //监听当前所选复选框
  $('tbody').on('click','.list-checkbox',function(){
    var length=$('.list-checkbox:checked').length;
    if(length>0){
      $('#deleteBtn').show()
    }else{
      $('#deleteBtn').hide();
    }
    if(length==$('.list-checkbox').length){
      $('.checkAll').prop('checked',true)
    }else{
      $('.checkAll').prop('checked',false)
    }
  })
  //删除
  $('tbody').on('click','.del-btn',function(){
    var id=$(this).parent().attr('edit-id');
    $.ajax({
      url:'../assets/vendors/api/userAPI/delUser.php',
      data:{id},
      success:function(){
          render();
      }
    })
  })
  //批量删除
    $('#deleteBtn').on('click',function(){
    var ids=[];
    $('.list-checkbox:checked').each(function(k,v){
      ids.push(v.value) //取id
    })
    $.ajax({
      url:'../assets/vendors/api/userAPI/Multidelusers.php',
      data:{ids:ids.join()},//因为数据库命令中，delete多项数据语法为delete from categories where id in (val1,val2,val3)格式，所以要将数组转换为逗号分隔的字符串;
      success:function(){
        render();
      }
    })
  })
   $('#avatar').on('change',function(){
      var file=this.files[0];
      var url=URL.createObjectURL(file);
      $(this).siblings('.thumbnail').attr('src', url).fadeIn()
    })
    //编辑
    
  </script>
</body>
</html>
