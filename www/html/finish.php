<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

// 送信されたトークンを変数に代入
$token = get_post('csrf_token');

// 送信されたトークンとセッションに保存のトークンが一致しない場合不正なリクエストとして扱う。
if(is_valid_csrf_token($token) === FALSE) {
  set_error('不正なリクエストです。');
  redirect_to(CART_URL);
}

// トークンを破棄
unset($_SESSION['csrf_token']);

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$carts = get_user_carts($db, $user['user_id']);

if(purchase_carts($db, $carts) === false){
  set_error('商品が購入できませんでした。');
  redirect_to(CART_URL);
} 

$total_price = sum_carts($carts);

include_once '../view/finish_view.php';