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

$item_id = get_post('item_id');
$changes_to = get_post('changes_to');

if($changes_to === 'open'){
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  set_message('ステータスを変更しました。');
}else if($changes_to === 'close'){
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  set_message('ステータスを変更しました。');
}else {
  set_error('不正なリクエストです。');
}


redirect_to(ADMIN_URL);