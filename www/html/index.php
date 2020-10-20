<?php
// ファイルの読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

// セッションスタート
session_start();

// 非ログインの場合
if(is_logined() === false){
  // LOGIN_URLにリダイレクト
  redirect_to(LOGIN_URL);
}

// データベースへの接続情報を取得
$db = get_db_connect();
// データベースのユーザ情報を$user変数に代入
$user = get_login_user($db);

// $_GET[$in_order]を$in_order変数に代入
$in_order = get_get('in_order');

// データベースの商品情報を$items変数に代入
$items = get_open_items_inOrder($db, $in_order);

// トークンを生成
$token = get_csrf_token();

// ファイルの読み込み
include_once VIEW_PATH . 'index_view.php';