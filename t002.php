<?php include("header.php"); ?>

<?php
// 更新メッセージ
$message = '';

// PDOオブジェクトを参照する
global $pdo;

// 更新ボタンがクリックされた場合
if (isset($_POST["update"])) {

  // フォームの送信内容を取得
  $visit_id    = $_POST["visit_id"];    // 訪問ID
  $record_date = $_POST["record_date"]; // 訪問実績日
  $note        = $_POST["note"];        // MR備考

  // 訪問予定の一覧を繰り返し処理する
  for ($i=0; $i<count($visit_id); $i++) {
    // 削除対象の場合
    if (isset($_POST['del-' . $visit_id[$i]])) {
      // データベースから該当レコードを削除する
      $sql = "DELETE FROM T_VISIT WHERE visit_id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(1, $visit_id[$i]);
      $stmt->execute();
    }
    // 更新対象の場合
    else {
      // データベースの該当レコードを更新する
      if ($record_date[$i]) {
        $sql = "UPDATE T_VISIT SET record_date = ?, note = ? WHERE visit_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $record_date[$i]);
        $stmt->bindValue(2, $note[$i]);
        $stmt->bindValue(3, $visit_id[$i]);
        $stmt->execute();
      } else {
        $sql = "UPDATE T_VISIT SET record_date = null, note = ? WHERE visit_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $note[$i]);
        $stmt->bindValue(2, $visit_id[$i]);
        $stmt->execute();
      }
    }
  }

  // 更新メッセージをセットする
  $message = '訪問記録を更新しました。';
}

// ログインユーザーの訪問予定を全件取得する
$visit_list = get_visit_list($_SESSION["user_info"]["user_id"]);

?>

  <div class="container">

    <?php if ($message) { echo '<p class="alert alert-success">' . $message . '</p>'; } ?>

    <!--▽更新・削除フォーム▽-->
    <form action="t002.php" method="post" class="form-horizontal">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="20%">
          <col width="10%">
          <col width="10%">
          <col width="55%">
          <thead>
            <tr>
              <th>削除</th>
              <th>医療機関名</th>
              <th>訪問予定日</th>
              <th>訪問実績日</th>
              <th>ＭＲ備考</th>
            </tr>
          </thead>
          <tbody class="datalist">
            <?php
            // ログインユーザーの訪問予定一覧を表示する
            if (!empty($visit_list)) {
              foreach ($visit_list as $visit) {
                $hosp_name = get_hosp_name($visit["hosp_code"]);  //医療機関名を取得する
            ?>
            <tr class="record">
              <input type="hidden" name="visit_id[]" value="<?php echo $visit["visit_id"]; ?>">
              <td><input type="checkbox" class="form-control" name="del-<?php echo $visit["visit_id"]; ?>"></td>
              <td><input type="text" class="form-control" name="hosp_name[]" value="<?php echo htmlspecialchars($hosp_name, ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="date" class="form-control" name="plan_date[]" value="<?php echo htmlspecialchars($visit["plan_date"], ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="date" class="form-control" name="record_date[]" value="<?php echo htmlspecialchars($visit["record_date"], ENT_QUOTES, "UTF-8"); ?>"></td>
              <td><textarea rows="3" class="form-control" name="note[]"><?php echo htmlspecialchars($visit["note"], ENT_QUOTES, "UTF-8"); ?></textarea></td>
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

  </div>

<?php include("footer.php"); ?>