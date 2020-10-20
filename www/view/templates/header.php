<header>
  <!-- 主要なナビゲーション　navbar=ナビゲーションバーを表示　navbar-expand-sm=ハンバーガーメニューが表示される画面幅の設定（break point {-sm|-md|-lg|-xl}）　navbar-light=リンクの色が変わる(明るい背景の場合)　bg-light=背景色 -->
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
    <!-- リンクの設定　navbar-brand=サイト左上のロゴのスタイルの設定　href=リンク先 -->
    <a class="navbar-brand" href="<?php print(HOME_URL);?>">Market</a>
    <!-- ボタンの設定　type="button"=汎用的に使える押しボタン　navbar-toggler=折り畳みの開閉機能　data-toggle="collapse"=折り畳みの初期状態の設定(閉じ状態)　data-target=ターゲット要素（どこに適用するかを設定、idで設定した箇所に適用される）　aria-controls=対象　aria-expanded=開閉状態　aria-label= aria=アクセシィビリティ関係-->
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <!-- navbar-toggler-icon= -->
      <span class="navbar-toggler-icon=ハンバーガーメニューの画像イメージの設定"></span>
    </button>
    <!-- class="collapse navbar-collapse"= id="headerNav"=idの設定、ここではdata-targrtで使用 -->
    <div class="collapse navbar-collapse" id="headerNav">
      <!-- navbar-item= mr-auto=左寄せ（右にマージン） -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php print(SIGNUP_URL);?>">サインアップ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php print(LOGIN_URL);?>">ログイン</a>
        </li>
      </ul>
    </div>
  </nav>
</header>
