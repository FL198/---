  <?php 
  header('content-type:text/html;charset=utf-8');
  $page='categories';
  include_once '../assets/vendors/php/aside.php'
  ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id='form'>
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block" style='color:red;display:none'>名称或别名不能为空！</p>
            </div>
            <div class="form-group">              
              <input type="button" class="btn btn-primary submitBtn" value="添加" >
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm multiple-del" href="javascript:;" style="display: none;position: absolute;top:-30px;">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox" id="checkAll"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <div id='pagination'></div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id='myModal'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">编辑分类信息</h4>
      </div>
      <div class="modal-body">
        <form id='edit-form' class='edit-form'>
          <div class="form-group">
            <label for="name">名称</label>
            <input class="form-control" id='edit-name' name="name" type="text" placeholder="分类名称">
          </div>
          <div class="form-group">
            <label for="slug">别名</label>
            <input class="form-control" id='edit-slug' name="slug" type="text" placeholder="slug">
          </div>
          <input type="hidden" name='id' id='edit-id' >
        </form>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick='saveChange()'>保存</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/jquery/jquery.pagination.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/jquery/template-web.js"></script>
  <script type='text/html' id='tmp'>
    {{each list v i}}
    <tr>
      <td class="text-center"><input type="checkbox" value="{{v.id}}" class="checkbox-list"></td>
      <td>{{v.name}}</td>
      <td>{{v.slug}}</td>
      <td class="text-center oprete" data-id="{{v.id}}">
        <a href="javascript:;" class="btn btn-info btn-xs btn-edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
    {{/each}}
  </script>
  <script>NProgress.done()</script>
  <script>
  
  var page=0,pageSize=5;
  //获取分类列表
  function pageChange(page,pageSize){
    $.ajax({
      url:'../assets/vendors/api/categoriesAPI/getCategoriesList.php',
      data:{page,pageSize},
      dataType:'json',
      success:function(info){
        var htmlStr=template('tmp',{list:info})
        $("tbody").html(htmlStr)
      }
    })
  }
  // 新增分类
  $('.submitBtn').on('click',function(){
    // 判断新增表单中数据不能为空
    if(!$('#name').val()||!$('#slug').val()){
      $('.help-block').show();
      return false;
    }else{
      $('.help-block').hide();
    }
    // 提交数据
    var info=$("#form").serialize()
    $.ajax({
      url:'../assets/vendors/api/categoriesAPI/addCategory.php',
      data:decodeURIComponent(info,true),
      success:function(){
        // 成功之后表单重置，并重新渲染表格数据
        document.querySelector('#form').reset()
        render();
      }
    })
  })
  function render(){
    $.ajax({
      url:'../assets/vendors/api/categoriesAPI/getCount.php',
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

  // 添加删除事件
  $("tbody").on('click','.btn-del',function(){
    var id=$(this).parent().attr('data-id')
    $.ajax({
      data:{id},
      url:'../assets/vendors/api/categoriesAPI/delCategory.php',
      success:function(){
        render();
      },
      error:function(){
        console.log(123)
      }
    })
  })

  // 添加修改事件
  $('tbody').on('click','.btn-edit',function(){
    var id=$(this).parent().attr('data-id');
    $.ajax({
      url:'../assets/vendors/api/categoriesAPI/getCategoryInfo.php',
      data:{id},
      dataType:'json',
      success:function(info){
        $('#myModal').modal();//展示模态框
        $("#edit-name").val(info[0]['name'])
        $("#edit-slug").val(info[0]['slug'])
        $("#edit-id").val(info[0]['id'])//给模态框中表单控件添加默认值
      }
    })
  })

  // 给模态框的确认键添加事件
  function saveChange(){
    //新增分类，提交前检查是否填写完整
    if(!$('#edit-name').val()||!$('#edit-slug').val()){
      $('.edit-tip').show();
      return false;
    }else{
      $('.edit-tip').hide();
    }
    var info=$(".edit-form").serialize()
    //提交新增分类
    $.ajax({
      url:'../assets/vendors/api/categoriesAPI/editCategory.php',
      data:decodeURIComponent(info,true),
      success:function(){
        //成功之后重置表单，并重新获取数据渲染
        document.querySelector('.edit-form').reset()
        $('#myModal').modal('hide')
        render();
      }
    })
  }

  //全选按钮控制当前页所有checkbox
  $("#checkAll").on('click',function(){
    var status=$(this).prop('checked')
    $(".checkbox-list").prop('checked',status)
    //如果全选按钮选中状态，显示批量删除按钮，否则隐藏该按钮
    if(status){
      $('.multiple-del').show()
    }else{
      $('.multiple-del').hide()
    }
  })

  // 监听当前页所有选择框（‘checkbox-list’），如果有选择框被选中，则展示批量删除按钮，否则隐藏该按钮
  $("tbody").on('change','.checkbox-list',function(){
    var length=$(".checkbox-list:checked").length;
    if(length>0){
      $('.multiple-del').show()
    }else{
      $('.multiple-del').hide()
    }
    //如果当前页被选中的选择框个数等于当前页所展示的数据长度，说明所有数据被选中了，则全选按钮状态改为被选中；否则为未选中状态
    if(length==$('.checkbox-list').length){
      $("#checkAll").prop('checked',true)
    }else{
      $("#checkAll").prop('checked',false)
    }
  })

  //批量删除按钮被点击时，搜集所有被选中的按钮，获取他们的value值，作为参数传给后端
  $('.multiple-del').on('click',function(){
    var ids=[];
    $('.checkbox-list:checked').each(function(k,v){
      ids.push(v.value) //取id
    })
    $.ajax({
      url:'../assets/vendors/api/categoriesAPI/delCategoryList.php',
      data:{ids:ids.join()},//因为数据库命令中，delete多项数据语法为delete from categories where id in (val1,val2,val3)格式，所以要将数组转换为逗号分隔的字符串;
      success:function(){
        render();
      }
    })
  })

  </script>
</body>
</html>
