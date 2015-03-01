<tr>
  <td class="row-tools">
    <?php $this->BcBaser->link($this->BcBaser->getImg('Survey.admin/icon_tool_survey.png', array('width' => 24, 'height' => 24, 'alt' => '編集', 'class' => 'btn')), array('action' => 'confirm', $data['MailContent']['id']), array('title' => '集計')) ?>
  </td>
  <td><?php echo $data['MailContent']['id'] ?></td>
  <td><?php echo $data['MailContent']['title'] ?></td>
  <td><?php echo $data['MailContent']['name'] ?></td>
  <td style="white-space:nowrap">
  <?php echo $this->BcTime->format('Y-m-d', $data['MailContent']['created']); ?><br />
  <?php echo $this->BcTime->format('Y-m-d', $data['MailContent']['modified']); ?>
  </td>
  </tr>
