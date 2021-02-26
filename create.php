<?php
//conn는 데이터베이스 접속 관련 함수
$conn = mysqli_connect(
  '127.0.0.1:3307', //만약 비트나미를 사용한다면 뒤에 3307이나 3306을 붙여야 한다.
  'root', //비트나미 루트 사용자
  'pw', //다른 비번이면 알아서 고쳐 쓰십쇼
  'testdb'); // DB명입니다
$sql = "SELECT * FROM topic";
$result = mysqli_query($conn, $sql);
$list = '';
while($row = mysqli_fetch_array($result)) {
  $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$row['title']}</a></li>";
}
$article = array(
  'title'=>'Welcome',
  'description'=>'Hello, web'
);
if(isset($_GET['id'])) {
  $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
  $sql = "SELECT * FROM topic WHERE id={$filtered_id}";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $article['title'] = $row['title'];
  $article['description'] = $row['description'];
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>WEB</title>
  </head>
  <body>
    <h1><a href="index.php">WEB</a></h1>
    <ol>
      <?=$list?>
    </ol>
    <form action="process_create.php" method="POST">
      <p><input type="text" name="title" placeholder="title"></p>
      <p><textarea name="description" placeholder="description"></textarea></p>
      <p><input type="submit"></p>
    </form>
  </body>
</html>
