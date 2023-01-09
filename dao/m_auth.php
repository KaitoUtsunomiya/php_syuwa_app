<?php
function get_auth_list(){
    global $pdo;
    $sql = "SELECT * FROM `m_user_auth` ORDER BY `auth_id` ASC";
    //$stmt = $pdo->query($sql);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function insert_auth($auth_id, $auth_name){
    global $pdo;
    $sql = "INSERT INTO `m_user_auth` (`auth_id`, `auth_name`) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $auth_id);
    $stmt->bindValue(2, $auth_name);
    $stmt->execute();
}

function update_auth($auth_id, $auth_name){
    global $pdo;
    $sql = "UPDATE `m_user_auth` SET `auth_name` = ? WHERE `auth_id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $auth_name);
    $stmt->bindValue(2, $auth_id);
    $stmt->execute();
}

function delete_auth($auth_id){
    global $pdo;
    $sql = "DELETE FROM `m_user_auth` WHERE `auth_id` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $auth_id);
    $stmt->execute();
}
?>