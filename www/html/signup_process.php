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
  redirect_to(SIGNUP_URL);
}

// トークンを破棄
unset($_SESSION['csrf_token']);

if(is_logined() === true){
  redirect_to(HOME_URL);
}

$name = get_post('name');
$password = get_post('password');
$password_confirmation = get_post('password_confirmation');

$db = get_db_connect();

try{
  $result = regist_user($db, $name, $password, $password_confirmation);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
redirect_to(HOME_URL);