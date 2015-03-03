<?php
/*
* アンケートプラグイン
* 設定コントローラー
*
* PHP 5.4.x
*
* @copyright    Copyright (c) hiniarata co.ltd
* @link         https://hiniarata.jp
* @package      Survey Plugin Project
* @since        ver.0.9.0
*/

/**
* 設定コントローラー
*
* @package  baser.plugins.survey
*/
class SurveyConfigsController extends SurveyAppController {

  /**
  * クラス名
  *
  * @var string
  * @access public
  */
  public $name = 'SurveyConfigs';

  /**
  * コンポーネント
  *
  * @var array
  * @access public
  */
  public $components = array('BcAuth', 'Cookie', 'BcAuthConfigure');

  /**
  * モデル
  *
  * @var array
  * @access public
  */
  public $uses = array('Survey.Survey', 'Mail.MailConfig', 'Mail.MailContent', 'Mail.MailField', 'Mail.Message');

  /**
  * ヘルパー
  *
  * @var array
  * @access public
  */
  public $helpers = array('Mail.Mailfield', 'BcText', 'BcArray');

  /**
  * メールコンテンツデータ
  *
  * @var array
  * @access public
  */
  public $mailContent;

  /**
  * ぱんくずナビ
  *
  * @var string
  * @access public
  */
  public $crumbs = array(
  array('name' => 'プラグイン管理', 'url' => array('plugin' => '', 'controller' => 'plugins', 'action' => 'index')),
  array('name' => 'アンケート管理', 'url' => array('controller' => 'survey_configs', 'action' => 'index'))
  );

  /**
  * サブメニューエレメント
  *
  * @var array
  * @access public
  */
  public $subMenuElements = array('survey');

  /**
  * beforeFilter
  *
  * @return void
  * @access   public
  */
  public function beforeFilter() {
    parent::beforeFilter();
    $this->MailContent->recursive = -1;
    if (!empty($this->params['pass'][0])) {
      $this->mailContent = $this->MailContent->read(null, $this->params['pass'][0]);
      if ($this->mailContent['MailContent']['name'] != 'message') {
        App::uses('Message', 'Mail.Model');
        $this->Message = new Message();
        $this->Message->setup($this->mailContent['MailContent']['id']);
      }
    }
  }

  /**
  * [ADMIN] メールフォームの一覧
  *
  * @return void
  */
  public function admin_index() {
    //表示件数
    if (empty($this->params['named']['num'])){
      $limit = 20;
    } else {
      $limit = $this->params['named']['num'];
    }
    //データの取得
    $conditions = array();
    $this->paginate = array('conditions' => $conditions,
    'order' => 'MailContent.id DESC',
    'limit' => $limit
    );
    /* 表示設定 */
    $this->set('forms', $this->paginate('MailContent'));
    $this->pageTitle = 'メールフォーム一覧';
    $this->help = 'survey_configs_index';
  }

  /**
  * [ADMIN] 集計開始の確認
  *
  * @return void
  */
  public function admin_confirm($id = null) {
    /* 除外処理 */
    if (empty($id)) {
      $this->setMessage('無効なIDです。', true);
      $this->redirect(array('action' => 'index'));
    }
    if (empty($this->mailContent)) {
      $this->setMessage('無効なIDです。', true);
      $this->redirect(array('action' => 'index'));
    }

    //フィールドの取得
    $messages = $this->Message->mailFields;

    /* 表示設定 */
    $this->set('messages', $messages);
    $this->set('form', $this->mailContent);
    $this->pageTitle = '集計開始の確認';
    $this->help = 'survey_configs_confirm';
  }

  /**
  * [ADMIN] 集計と結果表示
  *
  * @return void
  */
  public function admin_result($id = null) {
    /* 除外処理 */
    if (empty($id)) {
      $this->setMessage('無効なIDです。', true);
      $this->redirect(array('action' => 'index'));
    }
    //期間制限
    if (!empty($this->request->data['MailField']['begin'])) {
      $beginData = $this->request->data['MailField']['begin'];
    } else {
      $beginData = '';
    }
    if (!empty($this->request->data['MailField']['end'])) {
      $endData = $this->request->data['MailField']['end'];
    } else {
      $endData = '';
    }
    //集計処理
    $count = $this->Message->find('count');
    $result = $this->Survey->tally($id, $beginData, $endData);
    /* 表示設定 */
    $this->set('count', $count);
    $this->set('result', $result);
    $this->pageTitle = '集計結果';
    $this->help = 'survey_configs_result';
  }
}