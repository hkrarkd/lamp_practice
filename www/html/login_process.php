<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

// 送信されたトークンを変数に代入
$token = get_post('csrf_token');

// 送信されたトークンとセッションに保存のトークンが一致しない場合不正なリクエストとして扱う。
if(is_valid_csrf_token($token) === FALSE) {
  set_error('不正なリクエストです。');
  redirect_to(LOGIN_URL);
}

// トークンを破棄
unset($_SESSION['csrf_token']);

if(is_logined() === true){
  redirect_to(HOME_URL);
}

$name = get_post('name');
$password = get_post('password');

$db = get_db_connect();


$user = login_as($db, $name, $password);
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

set_message('ログインしました。');
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}
redirect_to(HOME_URL);