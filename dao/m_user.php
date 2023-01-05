<?php
/* ======================================
  関数名：get_user
  機能　：利用者情報を取得する
  引数1 ：利用者ID
  引数2 ：利用者パスワード
  戻り値：利用者レコード
====================================== */
function get_user($id, $pwd) {
  global $pdo, $AES_KEY_STR;
  $sql = "SELECT * FROM `m_user` WHERE `user_id` = ? AND CONVERT(AES_DECRYPT(UNHEX(`user_pwd`), '{$AES_KEY_STR}') USING utf8) = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $id);
  $stmt->bindValue(2, $pwd);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}
/* ======================================
  関数名：get_user_name
  機能　：利用者名を取得する
  引数　：利用者ID
  戻り値：利用者名
====================================== */
function get_user_name($user_id) {
  global $pdo;
  $sql = "SELECT `user_name` FROM `m_user` WHERE `user_id` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $user_id);
  $stmt->execute();
  $result = $stmt->fetchColumn();
  return $result;
}
/* ======================================
  関数名：get_user_list
  機能　：利用者の一覧を取得する
  引数　：なし
  戻り値：利用者レコードの配列
====================================== */
function get_user_list() {
  global $pdo, $AES_KEY_STR;
  $sql = "SELECT `user_id`, `user_name`, CONVERT(AES_DECRYPT(UNHEX(`user_pwd`), '{$AES_KEY_STR}') USING utf8) user_pwd, `auth_id` FROM `m_user` ORDER BY `user_id` ASC";
  $stmt = $pdo->query($sql);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
/* ======================================
  関数名：insert_user
  機能　：利用者レコードを追加する
  引数　：利用者ID,利用者名,利用者パスワード,操作権限ID
  戻り値：なし
====================================== */
function insert_user($user_id, $user_name, $user_pwd, $auth_id) {
  global $pdo, $AES_KEY_STR;
  $sql  = "INSERT INTO `m_user` (`user_id`, `user_name`, `user_pwd`, `auth_id`) VALUES (?, ?, HEX(AES_ENCRYPT(?, '{$AES_KEY_STR}')), ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $user_id);
  $stmt->bindValue(2, $user_name);
  $stmt->bindValue(3, $user_pwd);
  $stmt->bindValue(4, $auth_id);
  $stmt->execute();
}
/* ======================================
  関数名：update_user
  機能　：利用者レコードを更新する
  引数　：利用者ID,利用者名,利用者パスワード,操作権限ID
  戻り値：なし
====================================== */
function update_user($user_id, $user_name, $user_pwd, $auth_id) {
  global $pdo, $AES_KEY_STR;
  $sql  = "UPDATE `m_user` SET `user_name` = ?, `user_pwd` = HEX(AES_ENCRYPT(?,'{$AES_KEY_STR}')), `auth_id` = ? WHERE `user_id` = ?";
//  $sql  = "UPDATE `m_user` SET `user_name` = ?, `user_pwd` = HEX(AES_ENCRYPT(?,'{$AES_KEY_STR}')) WHERE `user_id` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $user_name);
  $stmt->bindValue(2, $user_pwd);
  $stmt->bindValue(3, $auth_id);
  $stmt->bindValue(4, $user_id);
//  $stmt->bindValue(3, $user_id);
  $stmt->execute();
}
/* ======================================
  関数名：delete_user
  機能　：利用者レコードを削除する
  引数　：利用者ID
  戻り値：なし
====================================== */
function delete_user($user_id) {
  global $pdo;
  $sql  = "DELETE FROM `m_user` WHERE `user_id` = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(1, $user_id);
  $stmt->execute();
}
?>