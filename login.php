<?php include("header.php"); ?>

<?php
$error_message = '';

//ログインボタンがクリックされた場合
if (isset($_POST["login"])) {

  //データベースからユーザー情報を検索する
  $user = get_user($_POST["user_id"], $_POST["user_pwd"]);


  //ユーザー情報が存在する場合
  if (!empty($user)) {
    //セッションにユーザー情報を保存してメニュー画面へ遷移する
    $_SESSION["user_info"] = $user;
    transfer("menu.php");
  }
  //該当ユーザーが存在しない場合
  else {
    $error_message = '利用者IDまたはパスワードが違います。';
  }
}

?>

<div class="container">
  <?php if ($error_message) { ?>
    <p class="alert alert-danger"><?php echo $error_message; ?></p>
  <?php } ?>
  <form action="login.php" method="post" class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-4 control-label" for="user_id">利用者ID</label>
      <div class="col-sm-8">
        <input type="text" class="form-control" id="user_id" name="user_id" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label" for="user_pwd">パスワード</label>
      <div class="col-sm-8">
        <input type="password" class="form-control" id="user_pwd" name="user_pwd" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-8">
        <button type="submit" name="login" class="btn btn-primary">ログイン</button>
      </div>
    </div>
  </form>
</div>

<?php include("footer.php"); ?>

