  <?php
  header('content-type:text/html;charset=utf-8');
      $page='comments';
      include_once '../assets/vendors/php/aside.php';
  ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/pagination.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <?php include_once '../assets/vendors/php/navbar.php';?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none" id='checkbox'>
          <button class="btn btn-info btn-sm approveAll">批量批准</button>
          <button class="btn btn-danger btn-sm delAll">批量删除</button>
        </div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox" id='checkAll'></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
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
  <script src="../assets/vendors/jquery/jquery.pagination.js"></script>
  <script src="../assets/vendors/jquery/template-web.js"></script>
  <script>NProgress.done()</script>
  <script type="text/html" id="tmp">
    {{each list v i}}
    <tr>
        <td class="text-center"><input type="checkbox" value="{{v.id}}" class='checkbox_list'></td>
        <td>{{v.author}}</td>
        <td>{{v.content.length>20?v.content.substr(0,20)+'...':v.content}}</td>
        <td>《{{v.title}}》</td>
        <td>{{v.created.split(' ')[0]}}</td>
        <td>{{status[v.status]}}</td>
        <td class="text-center" edit-id="{{v.id}}">
          {{if v.status=='held'}}<a href="javascript:;" class="btn btn-warning btn-xs btn_approve">批准</a>{{/if}}
          <a href="javascript:;" class="btn btn-danger btn-xs btn_delete">删除</a>
        </td>
    </tr>
    {{/each}}
  </script>
  <script>
    var obj={
      'rejected':'拒绝',
      'approved':'批准',
      'held':'待审核',
      'trashed':'回收站'
    };
  </script>
  <script>
    var page=0,pageSize=5;
    //获取分类列表
    function pageChange(page,pageSize){
      $.ajax({
        url:'../assets/vendors/api/commentsAPI/getCommentsList.php',
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
      url:'../assets/vendors/api/commentsAPI/getCount.php',
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
  $('#checkAll').on('click',function(){
      var status=$(this).prop('checked');
      $('.checkbox_list').prop('checked',status);
      if(status){
        $('#checkbox').show();
      }else{
        $('#checkbox').hide();
      }
  })
  //监听当前所有复选框
  $('tbody').on('click','.checkbox_list',function(){
      var length=$('.checkbox_list:checked').length;
      if(length>0){
        $('#checkbox').show();
      }else{
        $('#checkbox').hide();
      }
      //当前页选中长度等于目前页的总长度时
      if(length==$('.checkbox_list').length){
        $('#checkAll').prop('checked',true);
      }else{
        $('#checkAll').prop('checked',false);
      } 
  })
  //删除数据
  $('tbody').on('click','.btn_delete',function(){
    var id=$(this).parent().attr('edit-id');
    $.ajax({
        url:'../assets/vendors/api/commentsAPI/delComment.php',
        data:{id},
        success:function(){
          render();
        }
    })
  })
  //批量删除数据
  $('.delAll').on('click',function(){
    var ids=[];
    $('.checkbox_list:checked').each(function(k,v){
      ids.push(v.value);
    })
    $.ajax({
      url:'../assets/vendors/api/commentsAPI/delCommentList.php',
      data:{ids:ids.join()},
      success:function(){
        render();
      }
    })
  })
  //批准数据
    $('tbody').on('click','.btn_approve',function(){
    var id=$(this).parent().attr('edit-id');
    $.ajax({
        url:'../assets/vendors/api/commentsAPI/approveComment.php',
        data:{id},
        success:function(){
          render();
        }
    })
  })
  //批量批准数据
  $('.approveAll').on('click',function(){
    var ids=[];
    $('.checkbox_list:checked').each(function(k,v){
      ids.push(v.value);
    })
    $.ajax({
      url:'../assets/vendors/api/commentsAPI/approveCommentList.php',
      data:{ids:ids.join()},
      success:function(){
        render();
      }
    })
  })
  </script>
</body>
</html>
