<?php

function get_db_connect(){
  // MySQL用のDSN文字列
  // DSN=data source name　データベース接続情報を文字列にまとめたもの
  // mysql=DBの種類　mysql:dbname=DBの名前を設定　DBの名前はdocker-compose.ymlのenvironmentで設定している
  // host=ホスト（サーバ）のアドレス　phpとmysqlが同じサーバに保存されている場合、ホスト名はlocalhost　phpとmysqlが違うサーバに保存されている場合、ホスト名はmyssqlが保存されているサーバのIPアドレス（Dockerは「mysql」でmysqlが保存されているサーバのIPアドレスに変換する仕組みがある）
  // charset=文字コードの設定
  $dsn = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset='.DB_CHARSET;
 
  try {
    // データベースに接続
    // PDO=phpのDBに接続するためのライブラリ(機能)
    // new PDO=DBに接続した結果を$dbh(オブジェクト)に代入
    // utf8mb4=utf8の上位互換（データベースで使用する文字に合わせる）
    $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    // setAttribute=PDOのメソッド（オプションの設定）　エラーが発生したときに、PDOExceptionの例外を投げるように設定
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // setAttribute=PDOのメソッド（オプションの設定）　EMULATE_PREPARESをfalseに設定（エミュレートしない=静的プレースホルダを使う）
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // setAttribute=PDOのメソッド（オプションの設定）　DEFAULT_FETCH_MODEをASSOC(連想配列)に設定（fetchした時に連想配列で取得）
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    exit('接続できませんでした。理由：'.$e->getMessage() );
  }
  return $dbh;
}

function fetch_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    return $statement->fetch();
  }catch(PDOException $e){
    set_error('データ取得に失敗しました。');
  }
  return false;
}

function fetch_all_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
  }catch(PDOException $e){
    set_error('データ取得に失敗しました。');
  }
  return false;
}

function execute_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    return $statement->execute($params);
  }catch(PDOException $e){
    set_error('更新に失敗しました。');
  }
  return false;
}