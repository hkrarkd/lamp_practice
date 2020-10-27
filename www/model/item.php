<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用

function get_item($db, $item_id){
  $sql = "
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
    WHERE
      item_id = :item_id
  ";

  $params = [':item_id' => $item_id];

  return fetch_query($db, $sql, $params);
}

function get_items($db, $is_open = false, $in_order = ''){
  // sql文　SELECT=取得するカラムを選択　FROM=テーブルを選択
  $sql = '
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status,
      created
    FROM
      items
  ';
  // $is_openの値がtrueの場合
  if($is_open === true){
    // sql文　WHERE=条件を設定（statusカラムが1）
    $sql .= '
      WHERE status = 1
    ';
  }
  // $in_orderの値が空or新着順の場合
  if($in_order === '' || $in_order === '新着順'){
    // sql文　ORDER BY=並び替え（createdカラムについて降順）
    $sql .= '
      ORDER BY
        created DESC
    ';
  } 
  // $in_orderの値が安い順の場合
  elseif ($in_order === '安い順') {
    // sql文　ORDER BY=並び替え（priceカラムについて昇順）
    $sql .= '
      ORDER BY
        price
    ';
  } 
  // $in_orderの値が高い順の場合
  elseif ($in_order === '高い順') {
    // sql文　ORDER BY=並び替え（priceカラムについて降順）
    $sql .= '
      ORDER BY
        price DESC
    ';
  }

  // 返り値
  return fetch_all_query($db, $sql);
}

function get_all_items($db){
  return get_items($db);
}

function get_open_items($db){
  return get_items($db, true);
}

function get_open_items_inOrder($db, $in_order){
  // 返り値
  return get_items($db, true, $in_order);
}

function regist_item($db, $name, $price, $stock, $status, $image){
  // 画像ファイル名を取得
  $filename = get_upload_filename($image);
  // バリデーション処理
  if(validate_item($name, $price, $stock, $filename, $status) === false){
    return false;
  }
  // 商品情報をデータベースに登録
  return regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename);
}

function regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename){
  $db->beginTransaction();
  if(insert_item($db, $name, $price, $stock, $filename, $status) 
    && save_image($image, $filename)){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
  
}

function insert_item($db, $name, $price, $stock, $filename, $status){
  $status_value = PERMITTED_ITEM_STATUSES[$status];
  $sql = "
    INSERT INTO
      items(
        name,
        price,
        stock,
        image,
        status
      )
    VALUES(:name, :price, :stock, :filename, :status_value);
  ";

  $params = [':name' => $name, ':price' => $price, ':stock' => $stock, ':filename' => $filename, ':status_value' => $status_value];

  return execute_query($db, $sql, $params);
}

function update_item_status($db, $item_id, $status){
  $sql = "
    UPDATE
      items
    SET
      status = :status
    WHERE
      item_id = :item_id
    LIMIT 1
  ";

  $params = [':status' => $status, ':item_id' => $item_id];
  
  return execute_query($db, $sql, $params);
}

function update_item_stock($db, $item_id, $stock){
  $sql = "
    UPDATE
      items
    SET
      stock = :stock
    WHERE
      item_id = :item_id
    LIMIT 1
  ";

  $params = [':stock' => $stock, ':item_id' => $item_id];
  
  return execute_query($db, $sql, $params);
}

function destroy_item($db, $item_id){
  $item = get_item($db, $item_id);
  if($item === false){
    return false;
  }
  $db->beginTransaction();
  if(delete_item($db, $item['item_id'])
    && delete_image($item['image'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}

function delete_item($db, $item_id){
  $sql = "
    DELETE FROM
      items
    WHERE
      item_id = :item_id
    LIMIT 1
  ";

  $params = [':item_id' => $item_id];
  
  return execute_query($db, $sql, $params);
}


// 非DB

function is_open($item){
  return $item['status'] === 1;
}

function validate_item($name, $price, $stock, $filename, $status){
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_filename = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);

  return $is_valid_item_name
    && $is_valid_item_price
    && $is_valid_item_stock
    && $is_valid_item_filename
    && $is_valid_item_status;
}

function is_valid_item_name($name){
  $is_valid = true;
  if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_price($price){
  $is_valid = true;
  if(is_positive_integer($price) === false){
    set_error('価格は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_stock($stock){
  $is_valid = true;
  if(is_positive_integer($stock) === false){
    set_error('在庫数は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_filename($filename){
  $is_valid = true;
  if($filename === ''){
    $is_valid = false;
  }
  return $is_valid;
}

function is_valid_item_status($status){
  $is_valid = true;
  if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
    $is_valid = false;
  }
  return $is_valid;
}