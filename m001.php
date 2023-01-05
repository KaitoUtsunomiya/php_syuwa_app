<?php include("header.php"); ?>

<?php
$message = '';      // 更新メッセージ

// 更新ボタンがクリックされた場合
if (isset($_POST["update"])) {

  // フォームの送信内容を取得する
  $hosp_code = $_POST["hosp_code"]; // 医療機関コード
  $hosp_name = $_POST["hosp_name"]; // 医療機関名
  $hosp_addr = $_POST["hosp_addr"]; // 住所
  $hosp_tel  = $_POST["hosp_tel"];  // 電話番号

  // 医療機関の一覧を繰り返し処理する
  for ($i=0; $i<count($hosp_code); $i++) {
    // 削除対象の場合
    if (isset($_POST['del-' . $hosp_code[$i]])) {
      delete_hosp($hosp_code[$i]);
    }
    // 更新対象の場合
    else {
      update_hosp($hosp_code[$i], $hosp_name[$i], $hosp_addr[$i], $hosp_tel[$i]);
    }
  }

  // 更新メッセージをセットする
  $message = '医療機関マスタを更新しました。';
}

// 新規登録ボタンがクリックされた場合
if (isset($_POST["insert"])) {

  // フォームの送信内容を取得する
  $hosp_code = $_POST["new_hosp_code"]; // 医療機関コード
  $hosp_name = $_POST["new_hosp_name"]; // 医療機関名
  $hosp_addr = $_POST["new_hosp_addr"]; // 住所
  $hosp_tel  = $_POST["new_hosp_tel"];  // 電話番号

  // レコードを1件追加する
  insert_hosp($hosp_code, $hosp_name, $hosp_addr, $hosp_tel);

  // 更新メッセージをセットする
  $message = '医療機関マスタを追加しました。';
}

// 医療機関の一覧を取得する
$hosp_list = get_hosp_list();

?>

  <div class="container">

    <?php if ($message) { ?>
      <p class="alert <?php echo $is_error ? 'alert-danger' : 'alert-success'; ?>"><?php echo $message; ?></p>
    <?php } ?>

    <!--▽更新・削除フォーム▽-->
    <form action="m001.php" method="post">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="10%">
          <col width="30%">
          <col width="40%">
          <col width="15%">
          <thead>
            <tr>
              <th>削除</th>
              <th>医療機関コード<span>*</span></th>
              <th>医療機関名<span>*</span></th>
              <th>住所</th>
              <th>電話番号</th>
            </tr>
          </thead>
          <tbody class="datalist">
            <?php
            // 医療機関マスタの一覧を表示する
            if (!empty($hosp_list)) {
              foreach ($hosp_list as $hosp) {
            ?>
            <tr class="record">
              <td><input type="checkbox" class="form-control" name="del-<?php echo htmlspecialchars($hosp["hosp_code"], ENT_QUOTES, "UTF-8"); ?>"></td>
              <td><input type="text" class="form-control" name="hosp_code[]" value="<?php echo htmlspecialchars($hosp["hosp_code"], ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="text" class="form-control" name="hosp_name[]" value="<?php echo htmlspecialchars($hosp["hosp_name"], ENT_QUOTES, "UTF-8"); ?>" required></td>
              <td><input type="text" class="form-control" name="hosp_addr[]" value="<?php echo htmlspecialchars($hosp["hosp_addr"], ENT_QUOTES, "UTF-8"); ?>"></td>
              <td><input type="text" class="form-control" name="hosp_tel[]" value="<?php echo htmlspecialchars($hosp["hosp_tel"], ENT_QUOTES, "UTF-8"); ?>"></td>
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
    <form action="m001.php" method="post">
      <div class="table-responsive">
        <table class="table">
          <col width="5%">
          <col width="10%">
          <col width="30%">
          <col width="40%">
          <col width="15%">
          <thead>
            <tr>
              <th></th>
              <th>医療機関コード<span>*</span></th>
              <th>医療機関名<span>*</span></th>
              <th>住所</th>
              <th>電話番号</th>
            </tr>
          </thead>
          <tbody class="datalist">
            <tr class="record">
              <td></td>
              <td><input type="text" class="form-control" name="new_hosp_code" value="" required></td>
              <td><input type="text" class="form-control" name="new_hosp_name" value="" required></td>
              <td><input type="text" class="form-control" name="new_hosp_addr" value=""></td>
              <td><input type="text" class="form-control" name="new_hosp_tel" value=""></td>
            </tr>
          </tbody>
        </table>
      </div>
      <button type="submit" name="insert" class="btn btn-primary">新規登録</button>
    </form>
    <!--△新規登録フォーム△-->

  </div>

<?php include("footer.php"); ?>