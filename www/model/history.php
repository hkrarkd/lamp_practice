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

function get_order_histories($db, $order_id){
  $sql = "
    SELECT
      history_id,
      histories.item_id,
      amount,
      histories.price,
      name
    FROM
      histories
    JOIN
      items
    ON
      histories.item_id = items.item_id
    WHERE
      order_id = :order_id
  ";

  $params = [':order_id' => $order_id];

  return fetch_all_query($db, $sql, $params);
}