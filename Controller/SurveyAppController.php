<?php
/*
* アンケートプラグイン
* 基底コントローラー
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
App::uses('BcPluginAppController', 'Controller');

/**
* 基底コントローラー
*
* @package  baser.plugins.survey
*/
class SurveyAppController extends BcPluginAppController {

  /**
  * クラス名
  *
  * @var string
  * @access public
  */
  public $name = 'SurveyApp';

  /**
  * beforeFilter
  *
  * @return void
  * @access   public
  */
  public function beforeFilter() {
    parent::beforeFilter();
  }

}
