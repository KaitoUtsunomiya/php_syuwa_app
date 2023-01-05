<?php
/* ======================================
  関数名：get_hosp_name
  機能　：医療機関名を取得する
  引数　：医療機関コード
  戻り値：医療機関名
====================================== */
function get_hosp_name($hosp_code) {
  global $pdo;
  $sql = "SELECT `hosp_name` FROM `m_hosp` WHERE `hosp_code` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $hosp_code);
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}
/* ======================================
  関数名：get_hosp_list
  機能　：医療機関の一覧を取得する
  引数　：なし
  戻り値：医療機関レコードの配列
====================================== */
function get_hosp_list() {
  global $pdo;
  $sql = "SELECT * FROM `m_hosp` ORDER BY `hosp_code` ASC";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
/* ======================================
  関数名：insert_hosp
  機能　：医療機関レコードを追加する
  引数　：医療機関コード,医療機関名,住所,電話番号
  戻り値：なし
====================================== */
function insert_hosp($hosp_code, $hosp_name, $hosp_addr, $hosp_tel) {
  global $pdo;
  $sql  = "INSERT INTO `m_hosp` (`hosp_code`, `hosp_name`, `hosp_addr`, `hosp_tel`) VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $hosp_code);
  $stmt->bindValue(2, $hosp_name);
  $stmt->bindValue(3, $hosp_addr);
  $stmt->bindValue(4, $hosp_tel);
  $stmt->execute();
}
/* ======================================
  関数名：update_hosp
  機能　：医療機関レコードを更新する
  引数　：医療機関コード,医療機関名,住所,電話番号
  戻り値：なし
====================================== */
function update_hosp($hosp_code, $hosp_name, $hosp_addr, $hosp_tel) {
  global $pdo;
  $sql  = "UPDATE `m_hosp` SET `hosp_name` = ?, `hosp_addr` = ?, `hosp_tel` = ? WHERE `hosp_code` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $hosp_name);
  $stmt->bindValue(2, $hosp_addr);
  $stmt->bindValue(3, $hosp_tel);
  $stmt->bindValue(4, $hosp_code);
  $stmt->execute();
}
/* ======================================
  関数名：delete_hosp
  機能　：医療機関レコードを削除する
  引数　：医療機関コード
  戻り値：なし
====================================== */
function delete_hosp($hosp_code) {
  global $pdo;
  $sql  = "DELETE FROM `m_hosp` WHERE `hosp_code` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $hosp_code);
  $stmt->execute();
}
?>