<?php
/**
 * システムナビ
 */
$config['BcApp.adminNavi.survey'] = array(
    'name'    => 'アンケート プラグイン',
    'contents'  => array(
      array('name' => 'メールフォーム一覧',
        'url' => array(
          'admin' => true,
          'plugin' => 'survey',
          'controller' => 'survey_configs',
          'action' => 'index')
      )
  )
);

