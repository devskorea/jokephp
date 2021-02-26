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
  $list = $list."<li><a href=\"./index.php?id={$row['id']}\">{$row['title']}</a></li>";
}

$article = array(
  'title'=>'Welcome',
  'description'=>'Hello, web'
);
if(isset($_GET['id'])) {
  $sql = "SELECT * FROM topic WHERE id={$_GET['id']}";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  $article['title'] = $row['title'];
  $article['description'] = $row['description'];
  //$a_title은 title 태그나 현재 어떤 글을 보고 있는지 나타낸다
  $a_title = $article['title'];
  //$site_title은 HOME 옆에 나타나는 제목을 설정한다. 너무 길면 안되서 따로 만듬. 오류만 출력한다고 보면 됨
  $site_title = $article['title'];
}

$error = '';
?>
<?php
//글 아이디 입력 오류나 삭제된 글일시 출력 해보고 싶었지만 뻘짓이라 곧 삭제될 문단입니다
if ($article['title'] === null) {
  $article['title'] = '<span style="color:red">삭제되었거나 생성되지 않은 글</span>';
  $article['description'] = '삭제되었거나 아직 생성되지 않았을 글을 열람하시려고 하고 계십니다. 이 글이 삭제되었다면 운영정책을 위반하여 이용수칙에 맞게 삭제처리 된 것이니 안심하시기 바랍니다.';
  $a_title = '삭제되었거나 생성되지 않은 글';
  $site_title = '<span style="color:red">오류</span>';
}if ($article['title'] === "") {
  $article['title'] = '<span style="color:red">제목이 없습니다</span>';
  $site_title = '<span style="color:red">오류</span>';
  //$article['description'] = '삭제되었거나 아직 생성되지 않았을 글을 열람하시려고 하고 계십니다. 혹은 제목란이 비어 있는지 한번 확인해보시기 바랍니다';
  $a_title = '제목이 존재하지 않는 글';
  $error = '제목이 존재하지 않는 글입니다. 만약 이 글의 작성자이시다면 수정을 요청드립니다.';
} if ($article['title'] === 'Welcome') {
  //그냥 저거 홈에 나타나는 문구 고치기 귀찮아서... ㅋㅋㅋ
  $a_title = '홈';
  $site_title = 'HOME';
  $article['title'] = '홈에 오셨습니다';
  $article['description'] = '이 사이트의 시작이에요~';
}
?>
<!--여기가 html의 시작인가...-->
<!doctype html>
<html>
    <title>홈 - <?=$a_title?></title>
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body>
    <?php
    //echo '<h1>Home</h1>'
    ?>
    <h1><a href="index.php">HOME</a> - <?=$site_title?></h1>
    <?php
    $name = $_GET['name'];
    $login = 'false';
    if (empty($_GET['name'])) {
    echo '<span style="color:red">'.'익명'.'</span>'.'님 방문을 환영합니다'; //?name= 이 없으면 익명으로 간주. 어차피 name 안씀
  } else {
    echo '<span style="color:red">'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'</span>'
    . '님 방문을 환영합니다'; //방문 환영 메시지
  }
    ?>
    <hr>
    <input type="button" value="글쓰기" onclick="location.href='./create.php'"><br>
    <p class="font-10">글쓰기는 데이터베이스에 저장됩니다. 데이터베이스는 언제든지 열람하실수 있습니다. ㅋ <span style="font-size:5px">관리자 한정임 ㅅㄱ</span></p>
    <hr>
    <span>아래 목록에서 보고 싶으신 글을 보실수 있습니다. 현재 <?=$a_title?>을(를) 보고 계십니다. </span>
    <ol>
      <?=$list?>
    </ol>
    <?php echo $error; ?>
    <!--<a href="create.php">create</a>-->
    <h2>환영합니다</h2>
    <span>위에 리스트에서 클릭을 통해 데이터베이스에 저장된 문서를 열람하실수 있게되었습니다</span>
    <h2><?=$article['title']?></h2>
    <?=$article['description']?>
  </body>
</html>
