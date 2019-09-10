<?php
include_once "base.php";

//登入檢查
if(!empty($_POST['acc'])){
  if($_POST['acc']=='admin' && $_POST['pw']=='1234'){
    $_SESSION['login']="admin";
  }else{
    $err="<div class='ct'>帳號或密碼錯誤</div>";
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0055)?do=admin -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>影城</title>
<link rel="stylesheet" href="css/css.css">
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/js.js"></script>
</head>

<body>
<div id="main">
  <div id="top" style=" background:#999 center; background-size:cover; " title="替代文字">
    <h1>ABC影城</h1>
  </div>
  <div id="top2"> <a href="index.php">首頁</a> <a href="index.php?do=order">線上訂票</a> <a href="#">會員系統</a> <a href="admin.php">管理系統</a> </div>
  <div id="text"> <span class="ct">最新活動</span>
    <marquee direction="right">
    ABC影城票價全面八折優惠1個月
    </marquee>
  </div>
  <div id="mm">
  <?php
    if(!empty($_SESSION['login'])){
      //已登入的畫面
  ?>
    <div class="ct a rb" style="position:relative; width:101.5%; left:-1%; padding:3px; top:-9px;">
     <a href="?do=tit">網站標題管理</a>|
     <a href="?do=go">動態文字管理</a>|
     <a href="?do=poster">預告片海報管理</a>|
     <a href="?do=movie">院線片管理</a>|
     <a href="?do=order">電影訂票管理</a>
    </div>
    <div class="rb tab">
      <?php
        $do=(!empty($_GET['do']))?$_GET['do']:"";
        switch($do){
          case "poster":
            include "ad_poster.php";
          break;
          case "movie":
            include "ad_movie.php";
          break;
          case "order":
            include "ad_order.php";
          break;
          case "newMovie":
            include "new_movie.php";
          break;
          case "editMovie":
            include "edit_movie.php";
          break;
          default:
            echo "<h2 class='ct'>請選擇所需功能</h2>";

        }

      ?>
    </div>
  <?php

    }else{
      //未登入的畫面
      if(isset($err)){
        echo $err;
      }
?>
    <form action="?" method="post" style="display:block;margin:auto;width:30%;">
      帳號:<input type="text" name="acc" id=""><br>
      密碼:<input type="password" name="pw" id=""><br>
      <div class="ct">
        <input type="submit" value="送出">
        <input type="reset" value="重置">
    </div>
    </form>
<?php
    }
  ?>
  </div>
  <div id="bo"> ©Copyright 2010~2014 ABC影城 版權所有 </div>
</div>
</body>
</html>