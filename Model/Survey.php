<?php
/*
* アンケートプラグイン
* 集計モデル
*
* PHP 5.4.x
*
* @copyright    Copyright (c) hiniarata co.ltd
* @link         https://hiniarata.jp
* @package      Survey Plugin Project
* @since        ver.0.9.0
*/

/**
* Include files
*/
App::uses('SurveyApp', 'Survey.Model');

/**
* 集計モデル
*
* @package baser.plugins.survey
*/
class Survey extends SurveyApp {
  /**
  * クラス名
  *
  * @var string
  * @access public
  */
  public $name = 'Survey';

  /**
  * プラグイン名
  *
  * @var string
  * @access public
  */
  public $plugin = 'Survey';

  /**
  * DB接続時の設定
  *
  * @var string
  * @access public
  */
  public $useDbConfig = 'plugin';

  /**
  * 集計する
  *
  * @params int $id メールフォームのID
  * @return array 
  * @access public
  */
  public function tally($id = null, $beginDate = null, $endData = null){
    /* 除外 */
    if (empty($id)) {
      return false;
    }
    //メッセージモデル格納
    App::import('Model','Mail.Message'); 
    $messageModel = new Message();
    $messageModel->setup($id);
    //フィールドデータの取得
    $fields = $messageModel->mailFields;
    //結果格納変数
    $result = array();
    //カウンタ準備
    $i = 0;

    //期間指定の確認
    $postDate[] = array();
    if (!empty($beginDate)) {
      $begin = date("Y-m-d H:i:s", strtotime($beginDate));
      $postDate[] = array('Message.created >=' => $begin);
    }
    if (!empty($endData)) {
      $end = date("Y-m-d H:i:s", strtotime($endData));
      $postDate[] = array('Message.created <=' => $end);
    }

    //フィールド毎に集計していく。
    foreach ($fields as $data) {
      //集計開始
      switch($data['MailField']['type']){
        //ラジオ
        case 'radio':
          $source = explode('|', $data['MailField']['source']);
          if (!empty($source)) {
            //選択肢の分だけループ処理
            $c = 0; //配列キー用
            $sourceNum = 1; //何番目の値なのか
            foreach($source as $value){
              if (!empty($value)) {
                //カウントする
                $coutnt = 0;
                //条件文生成
                $conditions = $postDate;
                $conditions[] = array($data['MailField']['field_name'] => $sourceNum);
                $count = $messageModel->find('count', array('conditions' => $conditions));
                //結果格納
                $result[$i]['source'][$c] = $value;
                $result[$i]['count'][$c] = $count;
                $result[$i]['field_name'] = $data['MailField']['field_name'];
                $result[$i]['name'] = $data['MailField']['name'];
                $result[$i]['type'] = $data['MailField']['type'];
              }
              $c++;
              $sourceNum++;
            }
          }
        break;

        case 'multi_check':
          //例えば1をLIKE検索した場合、11とか18とかも引っかかる
          //$this->Table->find(‘all’, array(‘conditons’ => array(‘name REGEXP’ => ‘^1$|^1\||\|1$|\|1\|’));
          $source = explode('|', $data['MailField']['source']);
          $c = 0;
          $sourceNum = 1; //何番目の値なのか
          if (!empty($source)) {
            //選択肢の分だけループ処理
            foreach($source as $value){
              if (!empty($value)) {
                //カウントする
                $coutnt = 0;
                //条件文生成
                $conditions = $postDate;
                $conditions[] = array($data['MailField']['field_name'] .' REGEXP' => '^'.$sourceNum.'$|^'.$sourceNum.'\||\|'.$sourceNum.'$|\|'.$sourceNum.'\|');
                $count = $messageModel->find('count', array('conditions' => $conditions));
                //結果格納
                $result[$i]['source'][$c] = $value;
                $result[$i]['count'][$c] = $count;
                $result[$i]['field_name'] = $data['MailField']['field_name'];
                $result[$i]['name'] = $data['MailField']['name'];
                $result[$i]['type'] = $data['MailField']['type'];
              }
              $c++;
              $sourceNum++;
            }
          }
        break;

        case 'select':
          $source = explode('|', $data['MailField']['source']);
          if (!empty($source)) {
            //選択肢の分だけループ処理
            $c = 0;
            $sourceNum = 1; //何番目の値なのか
            foreach($source as $value){
              if (!empty($value)) {
                //カウントする
                $coutnt = 0;
                //条件文生成
                $conditions = $postDate;
                $conditions[] = array($data['MailField']['field_name'] => $sourceNum);
                $count = $messageModel->find('count', array('conditions' => $conditions));
                //結果格納
                $result[$i]['source'][$c] = $value;
                $result[$i]['count'][$c] = $count;
                $result[$i]['field_name'] = $data['MailField']['field_name'];
                $result[$i]['name'] = $data['MailField']['name'];
                $result[$i]['type'] = $data['MailField']['type'];
              }
              $c++;
              $sourceNum++;
            }
          }
        break;

        case 'pref':
          //都道府県番号から取得する。
          App::uses('BcTextHelper', 'View/Helper');
          $BcText = new BcTextHelper(new View());
          //47都道府県を順番に処理する。
          $c = 0;
          //$sourceNum = 1; //何番目の値なのか
          for($num=1; $num <= 47; $num++){
            //カウントする
            $coutnt = 0;
            //条件文生成
            $conditions = $postDate;
            $conditions[] = array($data['MailField']['field_name'] => $num);
            $count = $messageModel->find('count', array('conditions' => $conditions));
            //結果格納
            $result[$i]['source'][$c] = $BcText->pref($num);
            $result[$i]['count'][$c] = $count;
            $result[$i]['field_name'] = $data['MailField']['field_name'];
            $result[$i]['name'] = $data['MailField']['name'];
            $result[$i]['type'] = $data['MailField']['type'];
            $c++;
            //$sourceNum++;
          }
        break;

        default:
        break;
      }
      //カウント
      $i++;
    }
    //結果を返す
    return $result;
  }
}
