<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>

<div class="wrap">
  <table class="ncu-table-style">
    <thead>
      <tr style="text-align:center">
        <td>商品名称</td>
        <td>订购数量</td>
        <td>订购说明</td>
        <td>添加时间</td>
        <td>状态</td>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach ($output['list'] as $v) { ?>
        <tr>
        <td><a href="index.php?act=goods&op=index&goods_id=<?php echo $v['gshort_goodsid'];?>" target="_blank"><?php echo $v['gshort_goodsname'];?></a></td>
        <td><?php echo $v['gshort_goodquantity'];?></td>
        <td class="w80" style="word-wrap: break-word; max-width:400px;"><?php echo $v['gshort_content'];?></td>
        <td><?php echo $v['gshort_addtime'] ? date('Y-m-d', $v['gshort_addtime']) : '';?></td>
        <td><?php echo $v['gshort_state']==2 ? '已处理' : '处理中';?></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="6"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
        </tr>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?><span></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" charset="utf-8"></script>
