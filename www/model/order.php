<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function insert_order($db, $user_id){
  $sql = "
    INSERT INTO
      orders(user_id)
    VALUES (:user_id);
  ";

  $params = [':user_id' => $user_id];

  return execute_query($db, $sql, $params);
}