<h2>集計項目の確認</h2>
<p>以下の内容で集計を開始します（集計期間を指定したい場合は下記で設定してください）。</p>

<div class="section">
  <?php echo $this->BcForm->create('MailField', array('url' => array('plugin' => 'survey', 'controller' => 'survey_configs', 'action' => 'result', $form['MailContent']['id']) ,'enctype' => 'multipart/form-data')) ?>
  <table cellpadding="0" cellspacing="0" id="FormTable" class="form-table">
    <tr>
      <th>集計期間</th>
      <td>
        <?php echo $this->BcForm->dateTimePicker('MailField.begin', array('size' => 12, 'maxlength' => 10), true) ?>
          &nbsp;〜&nbsp;
        <?php echo $this->BcForm->dateTimePicker('MailField.end', array('size' => 12, 'maxlength' => 10), true) ?>
        <br />
        ※特に指定しない場合は空欄で構いません。
      </td>
    </tr>
  </table>

  <table cellpadding="0" cellspacing="0" id="FormTable" class="form-table">
    <?php foreach($messages as $data) : ?>
    <tr>
      <th class="col-head"><?php echo $data['MailField']['name'] ?></th>
      <td class="col-input">
      <?php
      //text textarea email autozip は集計しない。
      if ($data['MailField']['type'] == 'radio' || $data['MailField']['type'] == 'multi_check' || $data['MailField']['type'] == 'multi_check' || $data['MailField']['type'] == 'pref') {
        echo '集計します';
      } else {
        echo '<span style="color:#999">集計しません</span>';
      }
      ?>
      </td>
    </tr>
  <?php endforeach; ?>
    </table>
  </div>
  <!-- button -->
  <div class="submit">
    <?php echo $this->BcForm->submit('集計開始', array('div' => false, 'class' => 'button', 'id' => 'BtnSave')) ?>
  </div>