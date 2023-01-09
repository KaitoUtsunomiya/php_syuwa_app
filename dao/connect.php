<?php
// 定数定義
$DB_HOST = 'localhost';         // データベースのホスト名
$DB_NAME = 'sample';            // データベース名
$DB_USER = 'sample_app';        // データベースのユーザー名
$DB_PAWD = '.J7NXApBD[NgeQPp';  // データベースのパスワード

$AES_KEY_STR = 'H3a5Aa3pCvGm';  // 暗号化・複合化のキー文字列

// E_NOTICE（注意メッセージ）以外の全てのエラーを表示する
error_reporting(E_ALL & ~E_NOTICE);

// データベースに接続する
$pdo = new PDO(
  "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8",
  $DB_USER,
  $DB_PAWD,
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);
?>