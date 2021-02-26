<?php
//conn는 데이터베이스 접속 관련 함수
$conn = mysqli_connect(
  '127.0.0.1:3307', //만약 비트나미를 사용한다면 뒤에 3307이나 3306을 붙여야 한다.
  'root', //비트나미 루트 사용자
  'pw', //다른 비번이면 알아서 고쳐 쓰십쇼
  'testdb'); // DB명입니다
$filtered = array(
  'title'=>mysqli_real_escape_string($conn, $_POST['title']),
  'description'=>mysqli_real_escape_string($conn, $_POST['description'])
);
$sql = "
  INSERT INTO topic
    (title, description, created)
    VALUES(
        '{$filtered['title']}',
        '{$filtered['description']}',
        NOW()
    )
";
$result = mysqli_query($conn, $sql);
if($result === false){
  echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
  error_log(mysqli_error($conn));
} else {
  echo '성공했습니다. <a href="index.php">돌아가기</a>';
}
?>
