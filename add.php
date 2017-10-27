<?php
  
  function add_music() {
    if (empty($_POST['title'])) {
      $GLOBALS['error_message'] = '请输入标题';
      return;
    }
    if (empty($_POST['artist'])) {
      $GLOBALS['error_message'] = '请输入歌手';
      return;
    }
    // 校验上传文件
  // =====================================================
    if (empty($_FILES['source'])) {
      //提交的表单中没有source文件域
      $GLOBALS['error_message'] = '请正确提交文件';
      return;
    }
    $source = $_FILES['source'];
    //判断用户是否上传了文件
    if ($source['error'] !== UPLOAD_ERR_OK) {
      $GLOBALS['error_message'] = '请选择音乐文件';
      return;
    }
    //校验文件到的大小
    if ($source['size'] > 10 * 1024 * 1024) {
      $GLOBALS['error_message'] = '音乐文件过大';
      return;
    }
    if ($source['size'] < 1 * 1024 * 1024) {
      $GLOBALS['error_message'] = '音乐文件过小';
      return;
    }
    //校验类型
    $allowed_types = array('audio/mp3','audio/wma');
    if (!in_array($source['type'],$allowed_types)) {
      $GLOBALS['error_message'] = '不支持此一样格式';
      return;
    }
    // 音乐文件已经上传成功，但是还在临时目录中
  // 一般情况会将上传的文件重命名
  $linshi = $_FILES['source']['tmp_name'];
  $target = './uploads/mp3/' . uniqid() . '-' . $_FILES['source']['name'];
  $source = substr($target,2);
  if (!move_uploaded_file($linshi,$target)) {
    $GLOBALS['error_message'] = '上传音乐失败';
    return;
  }
  //    // =========== 接收图片
     if (empty($_FILES['images'])) {
      //提交的表单中没有images文件域
      $GLOBALS['error_message'] = '请正确提交文件';
      return;
    }
    $images = $_FILES['images'];
    //判断用户是否上传了文件
    if ($images['error'] !== UPLOAD_ERR_OK) {
      $GLOBALS['error_message'] = '请选择音乐文件';
      return;
    }
    //校验文件到的大小
    if ($images['size'] > 1 * 1024 * 1024) {
      $GLOBALS['error_message'] = '音乐文件过大';
      return;
    }
  
    //校验类型
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($images['type'],$allowed_types)) {
      $GLOBALS['error_message'] = '不支持此一样格式';
      return;
    }
    // 音乐文件已经上传成功，但是还在临时目录中
  // 一般情况会将上传的文件重命名
  $linshi = $_FILES['images']['tmp_name'];
  $target = './uploads/img/' . uniqid() . '-' . $_FILES['images']['name'];
  $images = substr($target,2);
  if (!move_uploaded_file($linshi,$target)) {
    $GLOBALS['error_message'] = '上传音乐失败';
    return;
  }
    // 图片音乐都上传成功
    
  $origin = json_decode(file_get_contents('data.json'),true);
  $origin[] = array(
    'id' => uniqid(),
    'title' => $_POST['title'],
    'artist' => $_POST['artist'],
    'images' => $images,
    'source' => $source
  ) ;
  var_dump($origin);
  $json = json_encode($origin);

  file_put_contents('data.json', $json);
  var_dump($json);
  //   跳转回列表页
  header('Location: list.php');
  } 
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_music();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>添加新音乐</title>
  <link rel="stylesheet" href="bootstrap.css">
</head>
<body>
  <div class="container py-5">
    <h1 class="display-4">添加新音乐</h1>
    <hr>
    <?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $error_message; ?>
    </div>
    <?php endif ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="form-group">
        <label for="title">标题</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
        <label for="artist">歌手</label>
        <input type="text" class="form-control" id="artist" name="artist">
      </div>
      <div class="form-group">
        <label for="images">海报</label>
        <input type="file" class="form-control" id="images" name="images">
      </div>
      <div class="form-group">
        <label for="source">音乐</label>
        <input type="file" class="form-control" id="source" name="source" accept="audio/*">
      </div>
      <button class="btn btn-primary btn-block">保存</button>
    </form>
  </div>
</body>
</html>
