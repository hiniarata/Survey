<?php
  $this->BcBaser->css(array(
    'Survey.../js/jqplot/jquery.jqplot'
  ));
  $this->BcBaser->js(array(
    'Survey.jqplot/excanvas.min',
    'Survey.jqplot/jquery.jqplot.min',
    'Survey.jqplot/plugins/jqplot.barRenderer.min',
    'Survey.jqplot/plugins/jqplot.categoryAxisRenderer.min',
    'Survey.jqplot/plugins/jqplot.pointLabels.min',
  ));
?>

<div class="section">
   <table cellpadding="0" cellspacing="0" id="FormTable" class="form-table">
    <tr>
      <th class="col-head">件数</th>
      <td class="col-input">
      <?php echo $count ?> 件
      </td>
    </tr>
    </table>

    <?php // var_dump($result) ?>

   <table cellpadding="0" cellspacing="0" id="FormTable" class="form-table">
    <?php foreach($result as $data) : ?>
    <tr>
      <th class="col-head">
        <?php echo $data['name'] ?>
        <?php
        //チェックボックスの時は複数回答であることを表示する
        if ($data['type'] == 'multi_check') { 
          echo '<br /><span style="font-weight:normal;">（※複数回答）</span>'; 
        } ?>
      </th>
      <td class="col-input">
        <?php
        $graphDatas = '';
        for($i=0; $i < count($data['source']); $i++){
          //echo $data['source'][$i] .'：'. $data['count'][$i] .'<br />';
          if (!empty($graphDatas)) {
            $graphDatas .= ', [' . $data['count'][$i] . ', "' . $data['source'][$i] . '"]';
          } else {
            $graphDatas .= '[' . $data['count'][$i] . ', "' . $data['source'][$i] . '"]';
          }
        }
        //高さを計算する。１つの要素（横棒）にたいして40px必要。加えて20px分の余白がいる。
        $height = $i * 40;
        $height = $height + 20;
        ?>
        <div id="<?php echo $data['field_name'] ?>" style="width:60%;height:<?php echo $height ?>px;"></div>
        <script>
         $.jqplot("<?php echo $data['field_name'] ?>", [
           [<?php echo $graphDatas ?>]
           ], {
                seriesDefaults: {
                    renderer:$.jqplot.BarRenderer,
                    pointLabels: { show: true, location: 'e', edgeTolerance: -15 },
                    shadowAngle: 135,
                    rendererOptions: {
                        barDirection: 'horizontal',
                        barWidth: 10,
                    }
                },
                axes: {
                    yaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer
                    }
                }
            });
        </script>

      </td>
    </tr>
  <?php endforeach; ?>
  </table>
</div>