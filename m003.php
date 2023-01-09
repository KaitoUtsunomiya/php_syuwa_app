<?php include("header.php"); ?>

<?php
$message = "";
if (isset($_POST["update"])){
    $auth_id = $_POST["auth_id"];
    $auth_name = $_POST["auth_name"];

    for($i=0; $i<count($auth_id); $i++){
        if(isset($_POST["del-" . $auth_id[$i]])){
            delete_auth($auth_id[$i]);
        }else{
            update_auth($auth_id[$i], $auth_name[$i]);
        }
    }
    $message = "操作権限マスタを更新しました";
}

if (isset($_POST["insert"])){
    $auth_id = $_POST["new_auth_id"];
    $auth_name = $_POST["new_auth_name"];

    insert_auth($auth_id, $auth_name);

    $message = "操作権限マスタを追加しました";
}

$auth_list = get_auth_list();
?>

<div class="container">
    <?php if ($message){ echo '<p class="alert alert-success">' . $message . '</p>';}?>
    <!-- 更新・削除フォーム -->
    <form action="m003.php" method="post">
        <div class="table-responsive">
            <table class="table">
                <col width="5%">
                <col width="20%">
                <col width="25%">
                <thead>
                    <tr>
                        <th>削除</th>
                        <th>操作権限ID<span>*</span></th>
                        <th>操作権限名<span>*</span></th>
                    </tr>
                </thead>
                <tbody class="datalist">
                    <?php
                    if (!empty($auth_list)){
                        foreach ($auth_list as $auth){
                    ?>
                    <tr class="record">
                        <td><input type="checkbox" class="form-control" name="del-<?php echo htmlspecialchars($auth["auth_id"], ENT_QUOTES, "UTF-8"); ?>"></td>
                        <td><input type="text" class="form-control" name="auth_id[]" value="<?php echo htmlspecialchars($auth["auth_id"], ENT_QUOTES, "UTF-8"); ?>" required></td>
                        <td><input type="text" class="form-control" name="auth_name[]" value="<?php echo htmlspecialchars($auth["auth_name"], ENT_QUOTES, "UTF-8"); ?>" required></td>
                    </tr>
                    <?php        
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <button type="submit" name="update" class="btn btn-primary">更新</button>
    </form>
    <!-- 更新・削除フォーム -->

    <!-- 新規登録フォーム -->
    <form action="m003.php" method="post">
        <div class="table-responsive">
            <table class="table">
                <col width="5%">
                <col width="20%">
                <col width="25%">
                <thead>
                    <tr>
                        <th></th>
                        <th>操作権限ID<span>*</span></th>
                        <th>操作権限名<span>*</span></th>
                    </tr>
                </thead>
                <tbody class="datalist">
                    <tr class="record">
                        <td></td>
                        <td><input type="text" class="form-control" name="new_auth_id" value="" required></td>
                        <td><input type="text" class="form-control" name="new_auth_name" value="" required></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="submit" name="insert" class="btn btn-primary">新規登録</button>
    </form>
    <!-- 新規登録フォーム -->
</div>
<?php include("fotter.php"); ?>