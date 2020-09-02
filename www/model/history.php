<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function insert_history($db, $item_id, $order_id, $amount, $price){
  $sql = "
    INSERT INTO
      histories(item_id, order_id, amount, price)
    VALUES (:item_id, :order_id, :amount, :price);
  ";

  $params = [':item_id' => $item_id, ':order_id' => $order_id, ':amount' => $amount, ':price' => $price];

  return execute_query($db, $sql, $params);
}