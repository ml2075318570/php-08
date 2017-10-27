<?php
// 校验（客户端来的东西都不能信）

// 确保客户端提交了 ID
$id = $_GET['id'];
// 1. 读取已有数据
$str = file_get_contents('data.json');
// 2. 反序列化
$arr = json_decode($str,true);
// 3. 遍历数组找到要删除的元素
foreach ($arr as $value) {
  if ($value['id'] === $id) {
    $index = array_search($value,$arr);
    array_splice($arr,$index,1);
    $new_json = json_encode($arr);
    file_put_contents('data.json',$new_json);
    break;
  }

}
    // 找到了要删除的数据
    // 4. 在数组中删除这个元素
    // 4.1. 找到这个数据在数组的下标
    // 5. 将删除过后的数组序列化成 JSON 字符串
    
    // 6. 持久化
// 跳转回去
header('Location: list.php');
