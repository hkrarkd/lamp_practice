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

function get_user_orders($db, $user_id){
  $sql = "
    SELECT
      orders.order_id,
      orders.created,
      SUM(price * amount) AS total_price
    FROM
      orders
    JOIN
      histories
    ON
      orders.order_id = histories.order_id
    WHERE
      user_id = :user_id
    GROUP BY
      orders.order_id
    ORDER BY
      orders.created DESC
  ";

  $params = [':user_id' => $user_id];

  return fetch_all_query($db, $sql, $params);
}

function get_all_orders($db){
  $sql = "
    SELECT
      orders.order_id,
      orders.created,
      SUM(price * amount) AS total_price
    FROM
      orders
    JOIN
      histories
    ON
      orders.order_id = histories.order_id
    GROUP BY
      orders.order_id
    ORDER BY
      orders.created DESC
  ";

  return fetch_all_query($db, $sql, $params);
}

function get_order_orders($db, $order_id){
  $sql = "
    SELECT
      orders.created,
      SUM(price * amount) AS total_price
    FROM
      orders
    JOIN
      histories
    ON
      orders.order_id = histories.order_id
    WHERE
      orders.order_id = :order_id
    GROUP BY
      orders.order_id
  ";

  $params = [':order_id' => $order_id];

  return fetch_query($db, $sql, $params);
}