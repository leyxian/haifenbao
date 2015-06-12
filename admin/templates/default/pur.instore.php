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
                <th><label for="search_goods_name"> 采购编号:</label></th>
                <td><input class="w96" type="number" value="<?php echo $_GET['order_id']?>" name="order_id" placeholder="请输入采购编号"/></td>
                <th><label for="search_goods_name"> 库存编号:</label></th>
                <td><input class="w96" type="number" value="<?php echo $_GET['id']?>" name="id" placeholder="请输入库存编号"/></td>
                <td>
                    <input type="hidden" name="act" value="pur"/>
                    <input type="hidden" name="op" value="instore"/>
                    <input type="submit" value="查询"/>
                </td>
            </tr>
        </table>
    </form>
    <table class="table tb-type2">
        <tr>
            <th>库存编号</th>		
            <th>采购编号</th>
            <th>供应商</th>				
            <th>商品名</th>
            <th>日文名称</th>
            <th>数量</th>
            <th>商品规格</th>
            <th>出库数量</th>
            <th>价格</th>
            <th>重量</th>
            <th>体积</th>
            <th>生产日期</th>
            <th>保质期</th>


            <th>支付时间</th>
            <th>入库时间</th>
	        <th>客服</th>		
            <!-- <th>是否出库</th> -->
            <th>操作</th>
        </tr>
        <?php if($output['list']){ foreach ($output['list'] as $v) { ?>
        <tr>
            <td><?php echo $v['id']?></td>
            <td><?php echo $v['order']['id']?></td>
            <td>
                <?php echo $v['vender']['name'].'<br/>'.$v['vender']['link_user'].'<br/>'.$v['vender']['link_tel'];?>
            </td>			
	
            <td><?php echo $v['goods']['goods_name']?></td>
            <td><?php echo $v['goods']['jap_name']?></td>
            <td><?php echo $v['store_num']; ?></td>
            <td><?php echo $v['order']['marque'].'&nbsp;'.$v['order']['specifications']?></td>
            <td><?php echo $v['out_num']; ?></td>
            <td><?php echo $v['order']['jap_price']?>JPY</td>
            <td><?php echo sprintf('%.2f', $v['order']['weight']);?>G</td>
            <td><?php echo sprintf('%.2f', $v['order']['volume']);?>cm³</td>
            <td><?php if($v['order']['good_date']) echo date('Y-m-d', $v['order']['good_date']);?></td>
            <td><?php if($v['order']['good_time']) echo date('Y-m-d', $v['order']['good_time']);?></td>


            <td><?php if($v['pay_time']) echo date('Y-m-d H:i', $v['pay_time']); else echo '未支付';?></td>
            <td><?php if($v['addtime']) echo date('Y-m-d H:i', $v['addtime']);?></td>
            <!-- <td><?php if($v['outtime']) echo '已出库';?></td> -->
			 <td><?php echo $v['author']?></td>		
            <td>
                <a href="javascript:" class="chuku" data-id="<?php echo $v['id'];?>">出库</a><br/>
                <!-- <a href="javascript:del(<?php echo $v['id']?>)">删除</a> -->
            </td>
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
    #ck_div { width: 300px; border: 3px solid #333; padding: 10px; position: fixed; background: #fff; left: 50%; top: 50%; display: none; }
    #ck_div { margin-left: -150px; margin-top: -100px; }
    #ck_div a.table-close { position: absolute; right: 0; top: 0; margin: 10px; }
</style>
<div id="ck_div" style="display:none;">
    <table class="table">
        <tr>
            <td><label>数量</label></td>
        </tr>
        <tr>
            <td>
                <input type="number" name="store_num" value=""/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="hidden" name="instore_id"/>
                <button id="ck_submit">提交</button>
            </td>
        </tr>
    </table>
    <a href="javascript:" class="table-close">关闭</a>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$('input[name="pay_date"]').datepicker({dateFormat: 'yy-mm-dd'});
$('.chuku').click(function(){
    $('#ck_div').show();
    $('input[name="instore_id"]').val($(this).attr('data-id'));
});
$('#ck_submit').click(function(){
    if(!$('input[name="store_num"]').val() || $('input[name="store_num"]').val() < 1){
        alert('请输入出货数量');
        $('input[name="store_num"]').val().focus();
    }else{
        if(confirm('确认填写完整并出库？')){
            $.post('index.php?act=pur&op=store',{'form': 'chuku','id':$('input[name="instore_id"]').val(),'num':$('input[name="store_num"]').val()}, function(data){
                if(data.status==1){
                    alert(data.msg);
                    window.location.reload();
                }else{
                    alert(data.msg);
                }
            }, 'json');
        }
    }
}); 
$('.table-close').click(function(){
    $(this).parent().hide();
});
</script>