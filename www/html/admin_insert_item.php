<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

// 送信されたトークンを変数に代入
$token = get_post('csrf_token');

// 送信されたトークンとセッションに保存のトークンが一致しない場合不正なリクエストとして扱う。
if(is_valid_csrf_token($token) === FALSE) {
  set_error('不正なリクエストです。');
  redirect_to(ADMIN_URL);
}

// トークンを破棄
unset($_SESSION['csrf_token']);

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

$name = get_post('name');
$price = get_post('price');
$status = get_post('status');
$stock = get_post('stock');

$image = get_file('image');

// 商品登録処理
if(regist_item($db, $name, $price, $stock, $status, $image)){
  set_message('商品を登録しました。');
}else {
  set_error('商品の登録に失敗しました。');
}


redirect_to(ADMIN_URL);