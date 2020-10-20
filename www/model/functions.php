<?php

function dd($var){
  var_dump($var);
  exit();
}

function redirect_to($url){
  header('Location: ' . $url);
  exit;
}

function get_get($name){
  // $_GET[$name]がセットされている場合
  if(isset($_GET[$name]) === true){
    // 返り値は$_GET[$name]
    return $_GET[$name];
  };
  // 返り値は空
  return '';
}

function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}

function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}

function get_session($name){
  // $_SESSION[$name]に値がセットされている場合
  if(isset($_SESSION[$name]) === true){
    // 返り値は$_SESSION[$name]
    return $_SESSION[$name];
  };
  // 返り値は空
  return '';
}

function set_session($name, $value){
  $_SESSION[$name] = $value;
}

function set_error($error){
  $_SESSION['__errors'][] = $error;
}

function get_errors(){
  // get_session('__errors')の返り値を$errors変数に代入
  $errors = get_session('__errors');
  // $errorsの値が空の場合
  if($errors === ''){
    // 返り値は空の配列
    return array();
  }
  // $_SESSION['__errors']に空の配列をセットすることで初期化
  set_session('__errors',  array());
  // 返り値は$errors
  return $errors;
}

function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

function set_message($message){
  $_SESSION['__messages'][] = $message;
}

function get_messages(){
  // get_session('__messages')の返り値を$messages変数に代入
  $messages = get_session('__messages');
  // $messagesが空の場合
  if($messages === ''){
    // 返り値は空の配列
    return array();
  }
  // $_SESSION['__messages']に空の配列をセットすることで初期化
  set_session('__messages',  array());
  // 返り値は$messages
  return $messages;
}

// ログインチェック
function is_logined(){
  return get_session('user_id') !== '';
}

function get_upload_filename($file){
  if(is_valid_upload_image($file) === false){
    return '';
  }
  $mimetype = exif_imagetype($file['tmp_name']);
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  return get_random_string() . '.' . $ext;
}

function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

function save_image($image, $filename){
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}

function delete_image($filename){
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }
  return false;
  
}



function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string){
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}


function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}

function h($str) {
 
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

// トークンを生成
function get_csrf_token() {
  // ランダムな文字列を取得
  $token = (string)mt_rand();
  // セッションに保存
  set_session('csrf_token', $token);
  return $token;
  }

// トークンのチェック
function is_valid_csrf_token($token) {
  // トークンが未設定の場合
  if($token === '') {
  // 返値：false
  return false;
  }
  // 返値：送信されたトークンとセッションに保存のトークンを比較
  return $token === get_session('csrf_token');
}
