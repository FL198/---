  <?php
  header('content-type:text/html;charset=utf-8');
    $page='post-add';
    include_once '../assets/vendors/php/aside.php';
  ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>
  <div class="main">
  <?php include_once '../assets/vendors/php/navbar.php';?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form action='../assets/vendors/api/post-addAPI/save.php' method="post" enctype='multipart/form-data'>
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <div id="editor"></div>
            <textarea  style="display:none" id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong id='slugname'>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category"></select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <input type="hidden" name='user_id' value=<?php echo $id;?>>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
              <option value="published">回收站</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit" id='save'>保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/jquery/wangEditor.min.js"></script>
  <script src="../assets/vendors/jquery/template-web.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script type="text/html" id="tmp">
    {{each list v i}}
    <option value={{v.id}}>{{v.name}}</option>
    {{/each}}
  </script>
  <script>
    var content="";
    var E = window.wangEditor
    var editor = new E('#editor')
    editor.customConfig.onchange =function(html){
      // 监控变化，同步更新到 textarea
      $('#content').val(html)
      content=$('#content').val();
    }
    editor.create()
  </script>
  <script>NProgress.done()</script>
  <script>
    $.ajax({
      url:'../assets/vendors/api/post-addAPI/getCategories.php',
      dataType:'json',
      success:function(info){
        var htmlStr=template('tmp',{list:info})
        $('#category').html(htmlStr)
      }
    })
    $('#slug').on('input',function(){
      $('#slugname').text($(this).val())
    })
    $('#feature').on('change',function(){
      var file=this.files[0];
      var url=URL.createObjectURL(file);
      $(this).siblings('.thumbnail').attr('src', url).fadeIn()
    })
    $('#created').val(moment().format('YYYY-MM-DDThh:mm'))
  </script>
</body>
</html>
