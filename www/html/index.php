<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

$in_order = get_get('in_order');

$items = get_open_items_inOrder($db, $in_order);

// トークンを生成
$token = get_csrf_token();

include_once VIEW_PATH . 'index_view.php';