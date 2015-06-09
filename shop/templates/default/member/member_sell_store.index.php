<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<?php 
function getorder_state($state){
		switch ($state){
			case 0:
				$state_str='已取消';
				break;
			case 10:
				$state_str='待通知发货';
				break;
			case 20:
				$state_str='已确认';
				break;
			case 30:
				$state_str='已发货';
				break;
			case 40:
				$state_str='已收货';
				break;
			default:				
				$state_str='待通知发货';
				break;	
		}					
		return $state_str;
}
?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style type="text/css">
.store-name {
	width: 130px;
	display: inline-block;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
}
</style>

<div class="wrap">

<div class="tabmenu">
	<ul class="tab pngFix">
		<li class="normal"><a  href="index.php?act=member_order&op=store&state_type=state_pay">我的库存</a></li>	
		<li class="active"><a  href="index.php?act=member_sell_order&op=store&state_type=sold_order">已经售完</a></li> 	
	</ul>
  </div>
  <form method="get" action="index.php" target="_self">
    <table class="search-form">
      <input type="hidden" name="act" value="member_sell_order" />
	  <input type="hidden" name="op" value="store" />
      <tr>
        <td></td>
        <th><?php echo $lang['member_order_time'].$lang['nc_colon'];?></th>
        <td class="w180"><input type="text" class="text" name="query_start_date" id="query_start_date" value="<?php echo $_GET['query_start_date']; ?>"/>
          &#8211;
          <input type="text" class="text" name="query_end_date" id="query_end_date" value="<?php echo $_GET['query_end_date']; ?>"/></td>
        <th><?php echo $lang['member_order_sn'].$lang['nc_colon'];?></th>
        <td class="w160"><input type="text" class="text" name="order_sn" value="<?php echo $_GET['order_sn']; ?>"></td>
        <th><?php echo $lang['member_order_state'].$lang['nc_colon'];?></th>
        <td class="w100"><select name="state_type">
            <option value="sold_order" <?php echo $_GET['state_type']=='sold_order'?'selected':''; ?>>已售货物</option>

          </select></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['member_order_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="order ncu-table-style">
    <?php if ($output['order_group_list']) { ?>
      <?php foreach ($output['order_group_list'] as $order_pay_sn => $group_info) { ?><?php $p = 0;?>
      <tbody <?php if (!empty($group_info['pay_amount']) && $p == 0) {?> class="pay" <?php }?>>
      <?php foreach($group_info['order_list'] as $order_id => $order_info) {?>

        <tr><td colspan="19" class="sep-row"></td></tr>

      <tr>
        <th colspan="19">
		<span class="fl ml10">
            <!-- order_id -->
            发货单号：<span class="goods-num"><em><?php echo $order_info['sell_order_system_sn']; ?></em></span></span>
        <span class="fl ml10">
            <!-- order_sn -->
            平台订单号：<span class="goods-num"><em><?php echo $order_info['sell_order_sn']; ?></em></span></span>
		<span class="fl ml10">
            <!-- buyer_name -->
            收货人：<span class="goods-num"><em><?php echo $order_info['buyer_name']; ?></em></span></span>
            <!-- order_time -->
            <span class="fl ml20"><?php echo $lang['member_order_time'].$lang['nc_colon'];?><em class="goods-time"><?php echo date("Y-m-d H:i:s",$order_info['add_time']); ?></em></span>
       </th>
      </tr>

      <!-- S 商品列表 -->
      <?php foreach ((array)$order_info['extend_order_goods'] as $k => $goods_info) {?>
	  


<tr>
        <td class="w10 bdl"></td>
        <td class="w70"> </td>
        <td>
        <dl>
            <dt>商品</dt>
        </dl></td>
        <td> <dl class="w100">
            <dt>海分宝商品编号</dt>
        </dl></td>
        <td> <dl  class="w80">
            <dt>数量</dt>
        </dl></td>
        <td> <dl class="w60">
            <dt>我的库存</dt>
        </dl></td>	
        <td> <dl class="w60">
            <dt>海分宝库存</dt>
        </dl></td>	
        <td class="w90 bdl">订单状态</td>
        <td class="bdl bdr w80">订单操作</td>
      </tr>


      </tbody>
 
	  
	  
	  
      <tr>
        <td class="w10 bdl"></td>
        <td class="w70">
        <div class="goods-pic-small"><span class="thumb size60"><i></i><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank"><img src="<?php echo thumb($goods_info,60);?>"/></a></span></div></td>
        <td>
        <dl class="goods-name w120" >
            <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank"><?php echo $goods_info['goods_name']; ?></a></dt>
        </dl></td>
        <td><dl class="w100">
            <dt><?php echo $order_info['goods_serial']; 		
			?>
			</dt>
        </dl></td>
        <td><dl class="w60">
            <dt><?php echo $order_info['sell_goods_qty']; ?></dt>
        </dl></td>
        <td><dl class="w60">
            <dt><?php if(empty($order_info['extend_order_common']['goods_buyer_storage']) || $order_info['extend_order_common']['goods_buyer_storage']<1)echo '<font color=#F00>0</font>'; else echo $order_info['extend_order_common']['goods_buyer_storage']; ?></dt>
        </dl></td>
		
        <td><dl class="w60">
			<?php //foreach ((array)$order_info['extend_order_common']['goods_storage'] as $k => $value) {?>			
				<dt><?php echo $order_info['extend_order_common']['goods_storage']; ?></dt>
			<?php //} ?>	
				</dl>
		</td>		
				
        <?php if ((count($order_info['extend_order_goods']) > 1 && $k ==0) || (count($order_info['extend_order_goods']) == 1)){?>
        <td class="w100 bdl"><?php echo getorder_state($order_info['order_state']);?>           
		 <!-- 订单查看 -->
           <span class="fl ml10"><a href="index.php?act=sell_order_detail&op=show_order&order_id=<?php echo $order_info['order_id']; ?>" target="_blank" class="nc-show-order"><i></i><?php echo $lang['member_order_view_order'];?></a></span> </td>
		   
        <td class="bdl bdr w80">
		<!-- 订单编辑-->
  		<?php if ($order_info['order_state']=='10') {?>
          <!-- 取消订单 -->
          <?php if ($order_info['if_cancel']) { ?>
          <p>
<!--		  <a href="javascript:void(0)" style="color:#F30; text-decoration:underline;" nc_type="dialog" dialog_width="480" dialog_title="<?php echo $lang['member_order_cancel_order'];?>" dialog_id="buyer_order_cancel_order" uri="index.php?act=sell_order_detail&op=change_state&state_type=order_cancel&order_id=<?php echo $order_info['order_id']; ?>"  id="order<?php echo $order_info['order_id']; ?>_action_cancel"><?php echo $lang['member_order_cancel_order'];?></a>-->
 <a href="javascript:void(0)" onclick="if(confirm('确认取消订单?')){location.href='index.php?act=sell_order_detail&op=change_state&state_type=cancel&order_id=<?php echo $order['order_id']; ?>'}" style="color:#F30; text-decoration:underline;">
        	<?php echo $lang['member_order_cancel_order'];?></a>  
		  </p>		  
		     <p><a href="index.php?act=sell_order_detail&op=change_state&state_type=order_edit&order_id=<?php echo $order_info['order_id']; ?>">修改订单</a></p>
          <?php } }?>
  </td>
      </tr>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      </tbody>
      <?php } ?>
      <?php } else { ?>
      <tbody>
      <tr>
        <td colspan="19" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      </tbody>
      <?php } ?>

    <?php //if($output['order_pay_list']) { ?>
    <tfoot>
      <tr>
        <td colspan="19"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php //} ?>
  </table>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" ></script>
<script type="text/javascript">
$(function(){
    $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
