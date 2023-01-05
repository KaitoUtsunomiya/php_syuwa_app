<?php include("header.php"); ?>

<?php
// 更新メッセージ
$message = '';

// 更新ボタンがクリックされた場合
if (isset($_POST["update"])) {

  // フォームの送信内容を取得する
  $visit_id  = $_POST["visit_id"];  // 訪問ID
  $hosp_code = $_POST["hosp_code"]; // 医療機関コード
  $plan_date = $_POST["plan_date"]; // 訪問予定日
  $note      = $_POST["note"];      // MR備考

  // 訪問予定の一覧を繰り返し処理する
  for ($i=0; $i<count($visit_id); $i++) {
    // 削除対象の場合
    if (isset($_POST['del-' . $visit_id[$i]])) {
      delete_plan($visit_id[$i]);
    }
    // 更新対象の場合
    else {
      update_plan($visit_id[$i], $hosp_code[$i], $plan_date[$i], $note[$i]);
    }
  }

  // 更新メッセージをセットする
  $message = '訪問予定を更新しました。';
}

// 新規登録ボタンがクリックされた場合
elseif (isset($_POST["insert"])) {

  // フォームの送信内容を取得する
  $hosp_code = $_POST["new_hosp_code"]; // 医療機関コード
  $user_id   = get_login_user_id();     // ログインユーザーの利用者ID
  $plan_date = $_POST["new_plan_date"]; // 訪問予定日
  $note      = $_POST["new_note"];      // MR備考

  // レコードを1件追加する
  insert_plan($hosp_code, $user_id, $plan_date, null, $note);

  // 更新メッセージをセットする
  $message = '訪問予定を追加しました。';
}

// 訪問予定の一覧を取得する
$plan_list = get_plan_list(get_login_user_id());

// 医療機関の一覧を取得する
$hosp_list = get_hosp_list();

?>

  <div class="container">

    <?php if ($message) { echo '<p class="alert alert-success">' . $message . '</p>'; } ?>

    <!--▽更新・削除フォーム▽-->
    <form action="t001.php" method="post" class="form-horizontal">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="30%">
          <col width="10%">
          <col width="55%">
          <thead>
            <tr>
              <th>削除</th>
              <th>医療機関名<span>*</span></th>
              <th>訪問予定日</th>
              <th>ＭＲ備考</th>
            </tr>
          </thead>
          <tbody class="datalist">
            <?php
            // ログインユーザーの訪問予定一覧を表示する
            if (!empty($plan_list)) {
              foreach ($plan_list as $plan) {
            ?>
            <tr class="record">
              <input type="hidden" name="visit_id[]" value="<?php echo $plan["visit_id"]; ?>">
              <td><input type="checkbox" class="form-control" name="del-<?php echo $plan["visit_id"]; ?>"></td>
              <td>
                <select class="form-control" name="hosp_code[]" required>
                <?php
                // 医療機関名のプルダウンリストを生成する
                if (!empty($hosp_list)) {
                  foreach ($hosp_list as $hosp) {
                    if ($hosp["hosp_code"] == $plan["hosp_code"]) {
                      echo '<option value="'. $hosp["hosp_code"]. '" selected>' . htmlspecialchars($hosp["hosp_name"], ENT_QUOTES, "UTF-8") . '</option>';
                    } else {
                      echo '<option value="'. $hosp["hosp_code"]. '">' . htmlspecialchars($hosp["hosp_name"], ENT_QUOTES, "UTF-8") . '</option>';
                    }
                  }
                }
                ?>
                </select>
              </td>
              <td><input type="date" class="form-control" name="plan_date[]" value="<?php echo htmlspecialchars($plan["plan_date"], ENT_QUOTES, "UTF-8"); ?>"></td>
              <td><textarea rows="3" class="form-control" name="note[]"><?php echo htmlspecialchars($plan["note"], ENT_QUOTES, "UTF-8"); ?></textarea></td>
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
    <form action="t001.php" method="post" class="form-horizontal">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="30%">
          <col width="10%">
          <col width="55%">
          <thead>
            <tr>
              <th></th>
              <th>医療機関名<span>*</span></th>
              <th>訪問予定日</th>
              <th>ＭＲ備考</th>
            </tr>
          </thead>
          <tbody class="datalist">
            <tr class="record">
              <td></td>
              <td>
                <select class="form-control" name="new_hosp_code" required>
                <?php
                // 医療機関名のプルダウンリストを生成する
                if (!empty($hosp_list)) {
                  foreach ($hosp_list as $hosp) {
                    echo '<option value="'. $hosp["hosp_code"]. '">' . htmlspecialchars($hosp["hosp_name"], ENT_QUOTES, "UTF-8") . '</option>';
                  }
                }
                ?>
                </select>
              </td>
              <td><input type="date" class="form-control" name="new_plan_date" value=""></td>
              <td><textarea rows="3" class="form-control" name="new_note"></textarea></td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="submit" name="insert" class="btn btn-primary">新規登録</button>
    </form>
    <!--△新規登録フォーム△-->

  </div>

<?php include("footer.php"); ?>