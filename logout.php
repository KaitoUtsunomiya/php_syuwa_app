<?php
session_start();	//セッションを開始する
require_once("function.php");	//システム内で利用する関数群を読み込む

// セッション変数を削除する
$_SESSION = array();

// セッションを破棄
session_destroy();

//ログイン画面へ遷移する
transfer("login.php");

?>
