<!-- 文書がHTML5で作成されたものであることを宣言 -->
<!DOCTYPE html>
<!-- HTML文書であることを宣言　lang=html要素内で使われている言語 -->
<html lang="ja">
<!-- ヘッダ情報 -->
<head>
  <!-- ファイルの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <!-- ブラウザのツールバーに表示するタイトル -->
  <title>商品一覧</title>
  <!-- 外部スタイルシートの読み込み　rel=ファイルとの関係性、href=ファイルがある場所（URL）-->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<!-- 文書の本体 -->
<body>
  <!-- ファイルの読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">

  <!-- 商品の並び替え機能 -->
  <!-- 入力・送信フォーム　action=送信先URL　method=転送方法　text-right=Bootstrap4で右寄せ -->
  <form action="index.php" method="get" class="text-right">
    <!-- セレクトボックス　name=データ送信時に使用 -->
    <select name="in_order">
      <!-- 選択肢　value=データ送信時に使用　$in_orderが空or新着順の場合selectedで選択肢の表示を「新着順」に設定 -->
      <option value="新着順" <?php if($in_order === '' || $in_order === '新着順') {echo 'selected';} ?> >新着順</option>
      <!-- 選択肢　value=データ送信時に使用　$in_orderが安い順の場合selectedで選択肢の表示を「価格の安い順」に設定 -->
      <option value="安い順" <?php if($in_order === '安い順') {echo 'selected';} ?> >価格の安い順</option>
      <!-- 選択肢　value=データ送信時に使用　$in_orderが高い順の場合selectedで選択肢の表示を「価格の高い順」に設定 -->
      <option value="高い順" <?php if($in_order === '高い順') {echo 'selected';} ?> >価格の高い順</option>
    </select>
    <!-- フォーム部品　type="submit"=送信ボタン　value=ボタンに表示されるテキスト -->
    <input type="submit" value="並び替え">
  </form>

    <h1>商品一覧</h1>
    <!-- ファイルの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
      <!-- $items配列の値をそれぞれ$item変数として出力 -->
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
                <?php print(number_format(h($item['price']))); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                    <!-- トークンをhiddenで送信 -->
                    <input type="hidden" name="csrf_token" value="<?php print $token; ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>