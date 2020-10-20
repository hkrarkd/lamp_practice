<!-- 文書がHTML5で作成されたものであることを宣言 -->
<!DOCTYPE html>
<!-- HTML文書であることを宣言　lang=html要素内で使われている言語 -->
<html lang="ja">
<!-- ヘッダ情報 -->
<head>
  <!-- ファイルの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <!-- ブラウザのツールバーに表示するタイトル -->
  <title>ログイン</title>
  <!-- 外部スタイルシートの読み込み　rel=ファイルとの関係性、href=ファイルがある場所（URL）-->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'login.css'); ?>">
</head>
<!-- 文書の本体 -->
<body>
  <!-- ファイルの読み込み -->
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <div class="container">
    <h1>ログイン</h1>
    <!-- ファイルの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <!-- 入力・送信フォーム　method=転送方法　action=送信先URL　mx-auto=Bootstrap4でブロック中央寄せ -->
    <form method="post" action="login_process.php" class="login_form mx-auto">
      <div class="form-group">
        <!-- フォーム部品とラベル(項目名)を関連付け　for=関連付けするフォーム部品のid属性を指定 -->
        <label for="name">名前: </label>
        <!-- フォーム部品　type="text"=テキストボックス　name=データ送信時に使用　id=html,css,javascriptで使用 -->
        <input type="text" name="name" id="name" class="form-control">
      </div>
      <div class="form-group">
        <!-- フォーム部品とラベル(項目名)を関連付け　for=関連付けするフォーム部品のid属性を指定 -->
        <label for="password">パスワード: </label>
        <!-- フォーム部品　type="password"=パスワード入力欄　name=データ送信時に使用　id=html,css,javascriptで使用 -->
        <input type="password" name="password" id="password" class="form-control">
      </div>
      <!-- フォーム部品　type="submit"=送信ボタン　value=ボタンに表示されるテキスト -->
      <input type="submit" value="ログイン" class="btn btn-primary">
      <!-- トークンをhiddenで送信　name=フォーム部品の名前　value=送信する値 -->
      <input type="hidden" name="csrf_token" value="<?php print $token; ?>">
    </form>
  </div>
</body>
</html>