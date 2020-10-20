<?php
// ファイルの読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

// セッションスタート
session_start();

// ログインしている場合
if(is_logined() === true){
  // HOME_URLにリダイレクト
  redirect_to(HOME_URL);
}

// トークンを生成
$token = get_csrf_token();

// ファイルの読み込み
include_once VIEW_PATH . 'login_view.php';