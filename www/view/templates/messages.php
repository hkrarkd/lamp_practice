<!-- get_errors()で取得した配列の値をそれぞれ$error変数として出力 -->
<?php foreach(get_errors() as $error){ ?>
  <!-- class="alert alert-danger"=　print h($error)=$errorを出力 -->
  <p class="alert alert-danger"><span><?php print h($error); ?></span></p>
<?php } ?>
<!-- get_messages()で取得した配列の値をそれぞれ$message変数として出力 -->
<?php foreach(get_messages() as $message){ ?>
  <!-- class="alert alert-success"=　print h($message)=$messageを出力 -->
  <p class="alert alert-success"><span><?php print h($message); ?></span></p>
<?php } ?>