<?php include("header.php"); ?>

<?php
$message = '';      // 更新メッセージ

// 更新ボタンがクリックされた場合
if (isset($_POST["update"])) {
  
  // フォームの送信内容を取得する
  $user_id   = $_POST["user_id"];   // 利用者ID
  $user_name = $_POST["user_name"]; // 利用者名
  $user_pwd  = $_POST["user_pwd"];  // パスワード
  $auth_id   = $_POST["auth_id"];

  // 利用者の一覧を繰り返し処理する
  for ($i=0; $i<count($user_id); $i++) {
    // 削除対象の場合
    if (isset($_POST['del-' . $user_id[$i]])) {
      delete_user($user_id[$i]);
    }
    // 更新対象の場合
    else {
      update_user($user_id[$i], $user_name[$i], $user_pwd[$i], $auth_id[$i]);
    }
  }

  // 更新メッセージをセットする
  $message = '利用者マスタを更新しました。';
}

// 新規登録ボタンがクリックされた場合
elseif (isset($_POST["insert"])) {
  // フォームの送信内容を取得する
  $user_id   = $_POST["new_user_id"];   // 利用者ID
  $user_name = $_POST["new_user_name"]; // 利用者名
  $user_pwd  = $_POST["new_user_pwd"];  // パスワード
  $auth_id = $_POST["new_auth_id"];

  // レコードを1件追加する
  insert_user($user_id, $user_name, $user_pwd, $auth_id);

  // 更新メッセージをセットする
  $message = '利用者マスタを追加しました。';
}

$auth_list = get_auth_list();
// 利用者の一覧を取得する
$user_list = get_user_list();

?>

  <div class="container">

    <?php if ($message) { ?>
      <p class="alert <?php echo $is_error ? 'alert-danger' : 'alert-success'; ?>"><?php echo $message; ?></p>
    <?php } ?>

    <!--▽更新・削除フォーム▽-->
    <form action="m002.php" method="post">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="20%">
          <col width="25%">
          <col width="25%">
          <col width="25%">
          <thead>
            <tr>
              <th>削除</th>
              <th>利用者ID<span>*</span></th>
              <th>利用者名<span>*</span></th>
              <th>パスワード<span>*</span></th>
              <th>操作権限<span>*</span></th>
            </tr>
          </thead>
          <tbody class="datalist">
            <?php 
            // 利用者マスタの一覧を表示する
            if (!empty($user_list)) {
              foreach ($user_list as $user) {
            ?>
            <tr class="record">
              <td><input type="checkbox" class="form-control" name="del-<?php echo htmlspecialchars($user["user_id"], ENT_QUOTES, "UTF-8"); ?>"></td>
              <td><input type="text" class="form-control" name="user_id[]" value="<?php echo htmlspecialchars($user["user_id"], ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="text" class="form-control" name="user_name[]" value="<?php echo htmlspecialchars($user["user_name"], ENT_QUOTES, "UTF-8"); ?>" required></td>
              <td><input type="password" class="form-control" name="user_pwd[]" value="<?php echo htmlspecialchars($user["user_pwd"], ENT_QUOTES, "UTF-8"); ?>" required></td>
              <td>
                <select class="form-control" name="auth_id[]" required>
                  <!-- <option value="10" selected>MR</option>
                  <option value="20">管理部門</option> -->
                  <?php
                  if (!empty($auth_list)){
                    foreach ($auth_list as $auth){
                      $value = htmlspecialchars($auth["auth_id"], ENT_QUOTES, "UTF-8");
                      $label = htmlspecialchars($auth["auth_name"], ENT_QUOTES, "UTF-8");
                      if($auth["auth_id"] == $user["auth_id"]){
                        echo '<option value="' . $value . '"selected>' . $label . '</option>'; 
                      }else{
                        echo '<option value="' . $value . '">' . $label . '</option>';
                      }
                    }
                  }
                  ?>
                </select>
              </td>
            </tr>
            <?php 
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <button type="submit" name="update" class="btn btn-primary">更　新</button>
    </form>
    <!--△更新・削除フォーム△-->

    <!--▽新規登録フォーム▽-->
    <form action="m002.php" method="post">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="20%">
          <col width="25%">
          <col width="25%">
          <col width="25%">
          <thead>
            <tr>
              <th></th>
              <th>利用者ID<span>*</span></th>
              <th>利用者名<span>*</span></th>
              <th>パスワード<span>*</span></th>
              <th>操作権限<span>*</span></th>
            </tr>
          </thead>
          <tbody class="datalist">
            <tr class="record">
              <td></td>
              <td><input type="text" class="form-control" name="new_user_id" value="" required></td>
              <td><input type="text" class="form-control" name="new_user_name" value="" required></td>
              <td><input type="password" class="form-control" name="new_user_pwd" value="" required></td>
              <td>
                <select class="form-control" name="new_auth_id" required>
                  <?php
                  if (!empty($auth_list)){
                    foreach ($auth_list as $auth){
                      $value = htmlspecialchars($auth["auth_id"], ENT_QUOTES, "UTF-8");
                      $label = htmlspecialchars($auth["auth_name"], ENT_QUOTES, "UTF-8");
                      echo '<option value="' . $value . '">' . $label . '</option>';
                    }
                  }
                  ?>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="submit" name="insert" class="btn btn-primary">新規登録</button>
    </form>
    <!--△新規登録フォーム△-->

  </div>

<?php include("footer.php"); ?>