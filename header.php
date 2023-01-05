<?php
session_start();	//セッションを開始する
require_once("function.php");	//システム内で利用する関数群を読み込む
login_check();    //ログインしているかどうかチェックする
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title><?php echo get_screen_name(); ?></title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body id="<?php echo get_screen_id(); ?>">

  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sysmenu">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand"><?php echo get_screen_name(); ?></div>
      </div>
      <div class="collapse navbar-collapse" id="sysmenu">
        <?php if (get_login_user_name()) { ?><p id="username" class="navbar-text navbar-right">【<?php echo get_login_user_name(); ?>】</p><?php } ?>
        <p id="logout" class="navbar-text navbar-right"><a href="logout.php" class="navbar-link">ログアウト</a></p>
        <p id="top" class="navbar-text navbar-right"><a href="menu.php" class="navbar-link">メニューへ戻る</a></p>
      </div>
    </div>
  </nav>
