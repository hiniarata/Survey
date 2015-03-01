<!-- pagination -->
<?php $this->BcBaser->element('pagination') ?>

<!-- list -->
<table cellpadding="0" cellspacing="0" class="list-table" id="ListTable">
  <thead>
    <tr>
      <th class="list-tool">
        操作
      </th>
      <th><?php echo $this->Paginator->sort('no', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' NO', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' NO'), array('escape' => false, 'class' => 'btn-direction')) ?></th>
      <th><?php echo $this->Paginator->sort('title', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' タイトル', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' タイトル'), array('escape' => false, 'class' => 'btn-direction')) ?></th>

      <th><?php echo $this->Paginator->sort('name', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' アカウント', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' タイトル'), array('escape' => false, 'class' => 'btn-direction')) ?></th>

      <th>
      <?php echo $this->Paginator->sort('created', array('asc' => $this->BcBaser->getImg('admin/blt_list_down.png', array('alt' => '昇順', 'title' => '昇順')) . ' 登録日', 'desc' => $this->BcBaser->getImg('admin/blt_list_up.png', array('alt' => '降順', 'title' => '降順')) . ' 登録日'), array('escape' => false, 'class' => 'btn-direction')) ?><br />
      </th>
      </tr>
      </thead>
      <tbody>
      <?php if (!empty($forms)): ?>
      <?php foreach ($forms as $data): ?>
      <?php $this->BcBaser->element('survey_configs/index_row', array('data' => $data)) ?>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
      <td colspan="9"><p class="no-data">データが見つかりませんでした。</p></td>
      </tr>
      <?php endif; ?>
      </tbody>
      </table>

      <!-- list-num -->
      <?php $this->BcBaser->element('list_num') ?>
