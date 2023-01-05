<?php
/* ======================================
  定数定義
====================================== */
define("USER_AUTH_MR", 10);
define("USER_AUTH_KANRI", 20);

/* ======================================
  データアクセスオブジェクトの読み込み
====================================== */
require_once("dao/connect.php");  // データベース接続
require_once("dao/m_user.php");   // 利用者テーブルを操作するプログラム
require_once("dao/m_hosp.php");   // 医療機関テーブルを操作するプログラム
require_once("dao/m_auth.php");
require_once("dao/t_visit.php");  // 訪問予定テーブルを操作するプログラム

/* ======================================
  関数名：get_screen_id
  機能　：現在の画面IDを取得する
  引数　：なし
  戻り値：現在の画面ID
====================================== */
function get_screen_id() {
  //現在アクセスしているページのファイル名（拡張子無し）を取得する
  return pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
}
/* ======================================
  関数名：get_screen_name
  機能　：現在の画面名を取得する
  引数　：なし
  戻り値：現在の画面名
====================================== */
function get_screen_name() {
  $screen_id = get_screen_id(); //現在アクセスしている画面のID
  switch ($screen_id) {
    case 'login' : $screen_name = 'ログイン'; break;
    case 'menu' : $screen_name = 'システムメニュー'; break;
    case 'm001' : $screen_name = '医療機関マスタ'; break;
    case 'm002' : $screen_name = '利用者マスタ'; break;
    case 't001' : $screen_name = '訪問予定入力'; break;
    case 't002' : $screen_name = '訪問実績入力'; break;
    case 't003' : $screen_name = '訪問実績照会'; break;
    case 't002_make' : $screen_name = '訪問実績入力'; break;
    default : $screen_name = '';
  }
  return $screen_name;
}
/* ======================================
  関数名：transfer
  機能　：指定されたプログラムへ制御を渡す
  引数　：遷移先のプログラムファイル名
  戻り値：なし
====================================== */
function transfer($filename) {
  $url  = (empty($_SERVER["HTTPS"]) ? "http://" : "https://");
  $url .= $_SERVER["HTTP_HOST"] . dirname($_SERVER["SCRIPT_NAME"]);
  $url .= "/" . $filename;
  header("Location: " . $url);
  exit;
}
/* ======================================
  関数名：login_check
  機能　：ログインしていなければログイン
          ページへ遷移させる
  引数　：なし
  戻り値：なし
====================================== */
function login_check() {
  // ログイン画面以外の場合
  if (get_screen_id() != "login") {
    // セッションにユーザー情報が保持されていない場合
    if (!isset($_SESSION["user_info"])) {
      // ログイン画面へ遷移させる
      transfer("login.php");
    }
  }
}
/* ======================================
  関数名：auth_check
  機能　：画面の操作権限を持っていなければ
          強制的にログアウトさせる
  引数　：なし
  戻り値：なし
====================================== */
function auth_check() {
  // チェック結果判定フラグ（OK:true, NG:false）
  $flag = false;
  // 現在アクセスしている画面のID
  $screen_id = get_screen_id();
  // 画面IDごとに操作権限をチェック
  switch ($screen_id) {
    case 'login' : $flag = true; break;       // ログイン画面
    case 'menu' : $flag = true; break;        // メニュー画面
    case 'm001' : $flag = is_kanri(); break;  // 医療機関マスタ画面
    case 'm002' : $flag = is_kanri(); break;  // 利用者マスタ画面
    case 't001' : $flag = is_mr(); break;     // 訪問予定入力画面
    case 't002' : $flag = is_mr(); break;     // 訪問実績入力画面
    case 't003' : $flag = is_kanri(); break;  // 訪問実績照会画面
    default : $flag = false;                  // 上記以外の画面
  }
  // チェック結果がNGなら強制的にログアウトする
  if (!$flag) {
    transfer("logout.php");
  }
}
/* ======================================
  関数名：get_login_user_id
  機能　：ログインユーザーの利用者IDを取得する
  引数　：なし
  戻り値：ログインユーザーの利用者ID
====================================== */
function get_login_user_id() {
  $user_id = '';
  if ($_SESSION["user_info"]) {
    $user_id = $_SESSION["user_info"]["user_id"];
  }
  return $user_id;
}
/* ======================================
  関数名：get_login_user_name
  機能　：ログインユーザーの利用者名を取得する
  引数　：なし
  戻り値：ログインユーザーの利用者名
====================================== */
function get_login_user_name() {
  $user_name = '';
  if ($_SESSION["user_info"]) {
    $user_name = $_SESSION["user_info"]["user_name"];
  }
  return $user_name;
}
/* ======================================
  関数名：is_kanri
  機能　：ログインユーザーが管理部門かどうか判定する
  引数　：なし
  戻り値：管理部門ならtrue、それ以外はfalse
====================================== */
function is_kanri() {
  $auth_id = '';
  if ($_SESSION["user_info"]) {
    $auth_id = $_SESSION["user_info"]["auth_id"];
  }
  return ($auth_id == USER_AUTH_KANRI);
}
/* ======================================
  関数名：is_mr
  機能　：ログインユーザーがＭＲかどうか判定する
  引数　：なし
  戻り値：ＭＲならtrue、それ以外はfalse
====================================== */
function is_mr() {
  $auth_id = '';
  if ($_SESSION["user_info"]) {
    $auth_id = $_SESSION["user_info"]["auth_id"];
  }
  return ($auth_id == USER_AUTH_MR);
}

/* ======================================
  関数名：vd
  機能　：整形済みvar_dumpを実行する
  引数　：出力対象データ
  戻り値：なし
====================================== */
function vd($value) {
  echo "<pre>";
  var_dump($value);
  echo "</pre>";
}
?>