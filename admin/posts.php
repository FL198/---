  <?php
  header('content-type:text/html;charset=utf-8');
    $page='posts';
    include_once '../assets/vendors/php/aside.php';
  ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm delBtn" href="javascript:;" style="display: none">批量删除</a>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" id='checkAll'></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>     
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <div id='pagination'></div>
    </div>
  </div>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/jquery/template-web.js"></script>
  <script src="../assets/vendors/jquery/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <script>
    var obj={
      'drafted':'草稿',
      'published':'已发布',
      'trashed':'回收站'
    }
  </script>
  <script type="text/html" id="tmp">
  {{each list v i}}
  <tr>
      <td class="text-center"><input type="checkbox" class='check-list' checkid={{v.id}}></td>
      <td>{{v.title}}</td>
      <td>{{v.nickname}}</td>
      <td>{{v.name}}</td>
      <td class="text-center" id='time'>{{v.created.split(' ')[0]}}</td>
      <td class="text-center">{{status[v.status]}}</td>
      <td class="text-right" edit-id='{{v.id}}'>
        {{if v.status=='drafted'}}
        <a href="post-edit.php?index={{v.id}}" class="btn btn-default btn-xs edit-btn">编辑</a>
        {{/if}}
        {{if v.status!='trashed'}}
        <a href="javascript:" class="btn btn-danger btn-xs del-btn">删除</a>
        {{/if}}
      </td>
  </tr>
  {{/each}}
  </script>
  <script>
    var page=0,pageSize=5;
    //获取分类列表
    function pageChange(page,pageSize){
      $.ajax({
        url:'../assets/vendors/api/postsAPI/getPostList.php',
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
      url:'../assets/vendors/api/postsAPI/getCount.php',
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
  //全选按钮
  $('#checkAll').on('click',function(){
    var status=$(this).prop('checked');
    $('.check-list').prop('checked',status);
    if(status){
      $('.delBtn').show();
    }else{
      $('.delBtn').hide();
    }
  })
  //监听按钮
  $('tbody').on('click','.check-list',function(){
    var length=$('.check-list:checked').length;
    if(length>0){
      $('.delBtn').show();
    }else{
       $('.delBtn').hide();
    }
    if(length==$('.check-list').length){
      $('#checkAll').prop('checked',true)
    }else{
      $('#checkAll').prop('checked',false)
    }
  })
  //删除
  $('tbody').on('click','.del-btn',function(){
    var id=$(this).parent().attr('edit-id');
    $.ajax({
      url:'../assets/vendors/api/postsAPI/delpost.php',
      data:{id},
      success:function(){
        render();
      }
    })
  })
  //批量删除
  $('.delBtn').on('click',function(){
    var ids=[];
    $('.check-list:checked').each(function(i,v){
      ids.push($(this).attr('checkid'))
    })
    $.ajax({
      url:'../assets/vendors/api/postsAPI/Multidelposts.php',
      data:{ids:ids.join()},
      success:function(){
        render();
      }
    })
  })
  </script>
</body>
</html>
