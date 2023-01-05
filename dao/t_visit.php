<?php
/* ======================================
  関数名：get_plan_list
  機能　：訪問予定の一覧を取得する
  引数　：利用者ID
  戻り値：訪問予定のレコード配列
====================================== */
function get_plan_list($user_id = null) {
  global $pdo;
  // MRの利用者IDが指定されていない場合
  if ($user_id == null) {
    // 利用者ID、訪問予定日の昇順で取得する
    $sql = "SELECT * FROM `t_visit` ORDER BY `user_id` ASC, `plan_date` ASC";
    $stmt = $pdo->prepare($sql);
  }
  // MRの利用者IDが指定されている場合
  else {
    // 訪問予定日の昇順で取得する
    $sql = "SELECT * FROM `t_visit` WHERE user_id = ? ORDER BY `plan_date` ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $user_id);
  }
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
/* ======================================
  関数名：get_visit_list
  機能　：訪問実績の一覧を取得する
  引数　：利用者ID
  戻り値：訪問実績のレコード配列
====================================== */
function get_visit_list($user_id = null) {
  global $pdo;
  // MRの利用者IDが指定されていない場合
  if ($user_id == null) {
    // 利用者ID、訪問予定日の昇順で取得する
    $sql = "SELECT * FROM `t_visit` WHERE `plan_date` IS NOT NULL ORDER BY `user_id` ASC, `plan_date` ASC";
    $stmt = $pdo->prepare($sql);
  }
  // MRの利用者IDが指定されている場合
  else {
    // 訪問予定日の昇順で取得する
    $sql = "SELECT * FROM `t_visit` WHERE `user_id` = ? AND `plan_date` IS NOT NULL ORDER BY `plan_date` ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $user_id);
  }
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
/* ======================================
  関数名：insert_plan
  機能　：訪問予定を追加する
  引数　：医療機関コード,利用者ID,訪問予定日,MR備考
  戻り値：なし
====================================== */
function insert_plan($hosp_code, $user_id, $plan_date, $note) {
  global $pdo;
  $sql = "INSERT INTO `t_visit` (`hosp_code`, `user_id`, `plan_date`, `record_date`, `note`) VALUES (?, ?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $hosp_code);
  $stmt->bindValue(2, $user_id);
  $stmt->bindValue(3, empty($plan_date) ? null : $plan_date);
  $stmt->bindValue(4, null);
  $stmt->bindValue(5, $note);
  $stmt->execute();
}
/* ======================================
  関数名：update_plan
  機能　：訪問予定を更新する
  引数　：訪問ID,医療機関コード,訪問予定日,MR備考
  戻り値：なし
====================================== */
function update_plan($visit_id, $hosp_code, $plan_date, $note) {
  global $pdo;
  $sql = "UPDATE `t_visit` SET `hosp_code` = ?, `plan_date` = ?, `note` = ? WHERE `visit_id` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $hosp_code);
  $stmt->bindValue(2, empty($plan_date) ? null : $plan_date);
  $stmt->bindValue(3, $note);
  $stmt->bindValue(4, $visit_id);
  $stmt->execute();
}
/* ======================================
  関数名：update_visit
  機能　：訪問実績を更新する
  引数　：訪問ID,訪問実績日,MR備考
  戻り値：なし
====================================== */
function update_visit($visit_id, $record_date, $note) {
  global $pdo;
  $sql = "UPDATE `t_visit` SET `record_date` = ?, `note` = ? WHERE `visit_id` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, empty($record_date) ? null : $record_date);
  $stmt->bindValue(2, $note);
  $stmt->bindValue(3, $visit_id);
  $stmt->execute();
}
/* ======================================
  関数名：delete_plan
  機能　：訪問予定を削除する
  引数　：訪問ID
  戻り値：なし
====================================== */
function delete_plan($visit_id) {
  global $pdo;
  $sql  = "DELETE FROM `t_visit` WHERE `visit_id` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $visit_id);
  $stmt->execute();
}
/* ======================================
  関数名：delete_visit
  機能　：訪問実績を削除する
  引数　：訪問ID
  戻り値：なし
====================================== */
function delete_visit($visit_id) {
  delete_plan($visit_id);
}
?>