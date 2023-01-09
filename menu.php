<?php include("header.php"); ?>

<div class="container">
  <div class="row menu">
  <?php if (is_kanri()) { // ログインユーザーが管理部門の場合 ?>
    <div class="col-sm-3 menu-item"><a href="m001.php">医療機関マスタ</a></div>
    <div class="col-sm-3 menu-item"><a href="m002.php">利用者マスタ</a></div>
    <div class="col-sm-3 menu-item"><a href="m003.php">操作権限マスタ</a></div>
    <div class="col-sm-3 menu-item"><a href="t003.php">訪問実績照会</a></div>
  <?php } ?>
  <?php if (is_mr()) { // ログインユーザーがＭＲの場合 ?>
    <div class="col-sm-3 menu-item"><a href="t001.php">訪問予定入力</a></div>
    <div class="col-sm-3 menu-item"><a href="t002.php">訪問実績入力</a></div>
  <?php } ?>
  </div>
</div>

<?php include("footer.php"); ?>