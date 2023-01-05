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
?>