<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.raty').raty({
            path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
            click: function(score) {
                $(this).find('[nctype="score"]').val(score);
            }
        });

        $('.raty-x2').raty({
            path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
            starOff: 'star-off-x2.png',
            starOn: 'star-on-x2.png',
            width: 150,
            click: function(score) {
                $(this).find('[nctype="score"]').val(score);
            }
        });


        $('#btn_submit').on('click', function() {
			ajaxpost('evalform', '', '', 'onerror')
        });
    });
</script>

<div class="wrap-shadow">
  <div class="wrap-all ncu-order-view">
    <h2><?php echo $lang['member_evaluation_toevaluategoods'];?></h2>
    <form id="evalform" method="post" action="index.php?act=member_evaluate&op=add&order_id=<?php echo $_GET['order_id'];?>">
      <h3 class="mt20 mb10">商品评价</h3>
      <div class="ncm-notes">
        <ul>
          <li><?php echo $lang['member_evaluation_rule_1'];?></li>
          <li><?php echo $lang['member_evaluation_rule_3'];?></li>
          <li><?php echo $lang['member_evaluation_rule_4'];?></li>
        </ul>
      </div>
      <table class="ncu-table-style order deliver">
        <tbody>
          <tr>
            <th colspan="20"><span class="ml10"><?php echo $lang['member_evaluation_order_desc'];?></span><span class="fr mr20">
              <input type="checkbox" name="anony" checked>
              &nbsp;<?php echo $lang['member_evaluation_modtoanonymous'];?></span> </th>
          </tr>
          <?php if(!empty($output['order_goods'])){?>
          <?php foreach($output['order_goods'] as $goods){?>
          <tr>
            <td class="bdl w10"></td>
            <td class="w70"><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id']; ?>" target="_blank"><img src="<?php echo $goods['goods_image_url']; ?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
            <td class="tl goods-info"><dl>
                <dt><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a></dt>
                <dd class="tr"><span class="price"><?php echo $goods['goods_price'];?></span>&nbsp;x&nbsp;<?php echo $goods['goods_num'];?></dd>
              </dl></td>
            <td class="bdr"><div class="ncgeval mb10">
              <div class="raty">
                <input nctype="score" name="goods[<?php echo $goods['goods_id'];?>][score]" type="hidden">
              </div>
              <textarea name="goods[<?php echo $goods['goods_id'];?>][comment]" cols="150" class="w400" maxlength="250"></textarea></td>
          </tr>
        </tbody>
        <?php }?>
        <?php }?>
        <tfoot>
          <tr>
            <td colspan="20"></td>
          </tr>
        </tfoot>
      </table>
      <h3>店铺信息及服务评价</h3>
      <div class="ncu-evaluation-store">
      
      <div class="ncu-form-style">
        <h4>我对此次服务的评分</h4>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_1'].$lang['nc_colon'];?></dt>
          <dd style=" width:450px;">
            <div class="raty-x2">
              <input nctype="score" name="store_desccredit" type="hidden">
            </div>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_2'].$lang['nc_colon'];?></dt>
          <dd style=" width:450px;">
            <div class="raty-x2">
              <input nctype="score" name="store_servicecredit" type="hidden">
            </div>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['member_evaluation_evalstore_type_3'].$lang['nc_colon'];?></dt>
          <dd style=" width:450px;">
            <div class="raty-x2">
              <input nctype="score" name="store_deliverycredit" type="hidden">
            </div>
          </dd>
        </dl>
      </div>
      <div class="clear"></div>
       <div class="mt30 tc"><input id="btn_submit" type="button" class="submit" value="<?php echo $lang['member_evaluation_submit'];?>"/>
      </div>
    </form>
  </div>
</div>
