<?php include("header.php"); ?>

<?php

// 訪問実績の一覧を取得する
$visit_list = get_visit_list();

?>

  <div class="container">

    <!--▽参照フォーム▽-->
    <form action="t003.php" method="post" class="form-horizontal">
      <div class="table-responsive">
        <table class="table">
          <col width="20%">
          <col width="20%">
          <col width="10%">
          <col width="10%">
          <col width="40%">
          <thead>
            <tr>
              <th>医療機関名</th>
              <th>担当ＭＲ</th>
              <th>訪問予定日</th>
              <th>訪問実績日</th>
              <th>ＭＲ備考</th>
            </tr>
          </thead>
          <tbody class="datalist">
            <?php
            // 全てのMRの訪問実績を一覧表示する
            if (!empty($visit_list)) {
              foreach ($visit_list as $visit) {
                $hosp_name = get_hosp_name($visit["hosp_code"]); // 医療機関名を取得する
                $user_name = get_user_name($visit["user_id"]);   // MR名を取得する
            ?>
            <tr class="record">
              <td><input type="text" class="form-control" name="hosp_name[]" value="<?php echo htmlspecialchars($hosp_name, ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="text" class="form-control" name="user_name[]" value="<?php echo htmlspecialchars($user_name, ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="date" class="form-control" name="plan_date[]" value="<?php echo htmlspecialchars($visit["plan_date"], ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><input type="date" class="form-control" name="record_date[]" value="<?php echo htmlspecialchars($visit["record_date"], ENT_QUOTES, "UTF-8"); ?>" readonly></td>
              <td><textarea rows="3" class="form-control" name="note[]" readonly><?php echo htmlspecialchars($visit["note"], ENT_QUOTES, "UTF-8"); ?></textarea></td>
            </tr>
            <?php 
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </form>
    <!--△参照フォーム△-->

  </div>

<?php include("footer.php"); ?>