<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>运费查询</h3>
            <ul class="tab-base">
                <li><a href="index.php?act=shipping_fee" <?php if(!$_GET['type']) echo 'class="current"';?>><span>所有运费</span></a></li>
                <li><a href="index.php?act=shipping_fee&type=1" <?php if($_GET['type']=='1') echo 'class="current"';?>><span>客户运费</span></a></li>
                <li><a href="index.php?act=shipping_fee&type=2" <?php if($_GET['type']=='2') echo 'class="current"';?>><span>自付运费</span></a></li>
            </ul>
        </div>
    </div> 
    <div class="fixed-empty"></div>
    <form action="index.php" method="GET">
        <table class="tb-type1 noborder search">
            <tr>
                <th><label for="search_goods_name"> 订单编号:</label></th>
                <td><input class="w120" type="text" value="<?php echo $_GET['order_sn']?>" name="order_sn" placeholder="请输入订单编号"/></td>
                <td>
                    <input type="hidden" name="act" value="shipping_fee"/>
                    <input type="submit" value="查询"/>
                </td>
            </tr>
        </table>
    </form>
    <div style="text-align: right;">
        <a class="btns" target="_blank" href="index.php?act=shipping_fee&op=export_index<?php if($_GET['curpage']){ ?>&curpage=<?php echo $_GET['curpage']; } if($_GET['order_sn']) { ?>&order_sn=<?php echo $_GET['order_sn']; } if($_GET['type']){ ?>&type=<?php echo $_GET['type']; } ?>"><span>导出Excel</span></a>
    </div>
    <table class="table tb-type2">
        <tr>
            <th>订单编号</th>
            <th>下单时间</th>
            <th>付款时间</th>
            <th>运费</th>
            <th>物流单号</th>
        </tr>
        <?php if($output['list']){ foreach ($output['list'] as $v) { ?>
        <tr>
            <td><a href="index.php?act=order&op=show_order&order_id=<?php echo $v['order_id'];?>" target="_blank"><?php echo $v['order_sn']?></a></td>
            <td>
                <?php if($v['add_time']) echo date('Y-m-d H:i', $v['add_time']); ?>
            </td>           
            <td><?php if($v['payment_time']) echo date('Y-m-d H:i', $v['payment_time']); ?></td>
            <td><?php echo $v['shipping_fee'] ? $v['shipping_fee'] : '0.00';?>￥</td>
            <td><?php echo $v['shipping_code']; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="5">
                <div class="pagination">
                    <?php echo $output['page']; ?>
                </div>
            </td>
        </tr>
        <?php }else { ?>
        <tr>
            <td colspan="5">没有数据</td>
        </tr>
        <?php } ?>
    </table>
</div>
<style type="text/css">
    #rk_div { width: 300px; border: 3px solid #333; padding: 10px; position: fixed; background: #fff; left: 50%; top: 50%; display: none; }
    #rk_div { margin-left: -150px; margin-top: -150px; }
    #rk_div a.table-close { position: absolute; right: 0; top: 0; margin: 10px; }
</style>
<div id="rk_div" style="display:none;">
    <table class="table">
        <tr>
            <td><label>支付时间</label></td>
        </tr>
        <tr>
            <td>
                <input type="date" name="pay_date" value=""/>
                <input type="time" name="pay_time" value=""/>
            </td>
        </tr>
        <tr>
            <td><label>入库数量</label></td>
        </tr>
        <tr>
            <td><input type="number" name="store_num" value=""/></td>
        </tr>
        <tr>
            <td><label>货位：</label></td>
        </tr>
        <tr>
            <td>
                <input class="txt" name="location" value=""/>
                <input type="hidden" name="order_id" value=""/>
            </td>
        </tr>
        <tr>
            <td><button id="rk_submit">提交</button></td>
        </tr>
    </table>
    <a href="javascript:" class="table-close">关闭</a>
</div>
<script type="text/javascript">

</script>