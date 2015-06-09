<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <h3>仓库</h3>
            <ul class="tab-base">
                <li><a href="index.php?act=pur" <?php if($_GET['op']=='' || $_GET['op']=='index') echo 'class="current"';?>><span>采购列表</span></a></li>
                <li><a href="index.php?act=pur&op=instore" <?php if($_GET['op']=='instore') echo 'class="current"';?>><span>入库列表</span></a></li>
                <li><a href="index.php?act=pur&op=outstore" <?php if($_GET['op']=='outstore') echo 'class="current"';?>><span>出库列表</span></a></li>
                <li><a href="index.php?act=pur&op=add" <?php if($_GET['op']=='add') echo 'class="current"';?>><span>采购申请</span></a></li>
                <li><a href="index.php?act=pur&op=goods" <?php if($_GET['op']=='goods') echo 'class="current"';?>><span>商品管理</span></a></li>
                <li><a href="index.php?act=pur&op=suppliers" <?php if($_GET['op']=='suppliers') echo 'class="current"';?>><span>供货商管理</span></a></li>
                <li><a href="index.php?act=pur&op=spec" <?php if($_GET['op']=='spec') echo 'class="current"';?>><span>规格管理</span></a></li>
            </ul>
        </div>
    </div> 
    <div class="fixed-empty"></div>
    <form action="index.php" method="GET">
        <table class="tb-type1 noborder search">
            <tr>
                <!-- <th><label for="search_goods_name"> 采购编号:</label></th>
                <td><input class="w96" type="number" value="<?php echo $_GET['order_id']?>" name="id" placeholder="请输入采购编号"/></td> -->
                <th><label for="search_goods_name"> 库存编号:</label></th>
                <td><input class="w96" type="number" value="<?php echo $_GET['instore_id']?>" name="instore_id" placeholder="请输入库存编号"/></td>
                <td>
                    <input type="hidden" name="act" value="pur"/>
                    <input type="hidden" name="op" value="outstore"/>
                    <input type="submit" value="查询"/>
                </td>
            </tr>
        </table>
    </form>
    <table class="table tb-type2">
        <tr>
            <th>库存编号</th>
            <th>商品名</th>
            <th>日文名称</th>
            <th>客服</th>
            <th>商品规格</th>
            <th>供应商</th>
            <th>价格</th>
            <th>重量</th>
            <th>体积</th>
            <th>生产日期</th>
            <th>保质期</th>
            <th>数量</th>
            <th>出库时间</th>
        </tr>
        <?php if($output['list']){ foreach ($output['list'] as $v) { ?>
        <tr>
            <td><?php echo $v['instore_id']; ?></td>
            <td><?php echo $v['goods']['goods_name']; ?></td>
            <td><?php echo $v['goods']['jap_name']; ?></td>
            <td><?php echo $v['author']; ?></td>
            <td><?php echo $v['order']['marque'].'&nbsp;'.$v['order']['specifications']?></td>
            <td>
                <?php echo $v['vender']['name'].'<br/>'.$v['vender']['link_user'].'<br/>'.$v['vender']['link_tel'];?>
            </td>
            <td><?php echo $v['order']['jap_price']?></td>
            <td><?php echo sprintf('%.2f', $v['order']['weight']);?></td>
            <td><?php echo sprintf('%.2f', $v['order']['volume']);?></td>
            <td><?php if($v['order']['good_date']) echo date('Y-m-d', $v['order']['good_date']);?></td>
            <td><?php if($v['order']['good_time']) echo date('Y-m-d', $v['order']['good_time']);?></td>
            <td><?php echo $v['store_num']?></td>
            <td><?php if($v['addtime']) echo date('Y-m-d H:i', $v['addtime']);?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="14">
                <div class="pagination">
                    <?php echo $output['show_page']; ?>
                </div>
            </td>
        </tr>
        <?php }else { ?>
        <tr>
            <td colspan="14">没有数据</td>
        </tr>
        <?php } ?>
    </table>
</div>
<style type="text/css">
    #rk_div { width: 300px; border: 3px solid #333; padding: 10px; position: fixed; background: #fff; left: 50%; top: 50%; display: none; }
    #rk_div { margin-left: -150px; margin-top: -100px; }
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$('input[name="pay_date"]').datepicker({dateFormat: 'yy-mm-dd'});
$('.ruku').click(function(){
    $('#rk_div').show();
    $('input[name="order_id"]').val($(this).attr('data-id'));
    if($(this).attr('data-date') > '0')
        $('input[name="pay_date"]').val($(this).attr('data-date'));
    if($(this).attr('data-time') > '0')
        $('input[name="pay_time"]').val($(this).attr('data-time'));
});
$('#rk_submit').click(function(){
    if(!$('input[name="location"]').val()){
        alert('请输入货位');
    }else if(!$('input[name="pay_date"]').val()){
        alert('请输入支付时间');
    }else{
        $.post('index.php?act=pur&op=store',{'form': 'ruku','id':$('input[name="order_id"]').val(),'location':$('input[name="location"]').val()}, function(data){
            if(data.status==1){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
                $('#rk_div').hide();
            }
        }, 'json')
    }
}); 
$('.table-close').click(function(){
    $(this).parent().hide();
});
</script>