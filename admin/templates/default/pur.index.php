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
    <div class="trace">
        <a href="index.php?act=pur&op=add" class="btn-add" style="margin-top:5px; float:none;">添加采购</a>
    </div>
    <form action="index.php" method="GET">
        <table class="tb-type1 noborder search">
            <tr>
                <th><label for="search_goods_name"> 采购编号:</label></th>
                <td><input class="w96" type="number" value="<?php echo $_GET['id']?>" name="id" placeholder="请输入采购编号"/></td>
                <!-- <th>是否入库</th>
                <td>
                    <select name="is_store">
                        <option value="">不限</option>
                        <option value="0" <?php if($_GET['is_store']==='0') echo 'selected'; ?>>未入库</option>
                        <option value="1"  <?php if($_GET['is_store']=='1') echo 'selected'; ?>>已入库</option>
                    </select>
                </td> -->
                <td>
                    <input type="hidden" name="act" value="pur"/>
                    <input type="submit" value="查询"/>
                </td>
            </tr>
        </table>
    </form>
    <table class="table tb-type2">
        <tr>
            <th>采购编号</th>
			 <th>供应商</th>
            <th>商品名</th>
            <th>日文名称</th>
            <th>数量</th>
            <th>商品规格</th>
             <th>入库数量</th>
            <th>价格</th>
            <th>重量</th>
            <th>体积</th>
            <th>生产日期</th>
            <th>保质期</th>


            <th>支付方式</th>
            <th>订购时间</th>			
            <th>支付时间</th>

            <th>客服</th>			
            <th>修改时间</th>
            <th>修改客服</th>
            <!-- <th>是否入库</th> -->
            <th>操作</th>
        </tr>
        <?php if($output['list']){ foreach ($output['list'] as $v) { ?>
        <tr>
            <td><?php echo $v['id']?></td>
            <td>
                <?php echo $v['vender']['name'].'<br/>'.$v['vender']['link_user'].'<br/>'.$v['vender']['link_tel'];?>
            </td>			
            <td><?php echo $v['goods']['goods_name']?></td>
            <td><?php echo $v['goods']['jap_name']?></td>
            <td><?php echo $v['store_num']?></td>
            <td><?php echo $v['marque'].'&nbsp;'.$v['specifications']?></td>
            <td><?php echo $v['in_num']?></td>
            <td><?php echo $v['jap_price']?>JPY</td>
            <td><?php echo sprintf('%.2f', $v['weight']);?>G</td>
            <td><?php echo sprintf('%.2f', $v['volume']);?>cm³</td>
            <td><?php if($v['good_date']) echo date('Y-m-d', $v['good_date']);?></td>
            <td><?php if($v['good_time']) echo date('Y-m-d', $v['good_time']);?></td>


            <td><?php echo $v['pay_type'];?></td>
            <td><?php if($v['addtime']) echo date('Y-m-d H:i', $v['addtime']);?></td>			
            <td><?php if($v['pay_time']) echo date('Y-m-d H:i', $v['pay_time']); else echo '未支付';?></td>

            <td><?php echo $v['author']?></td>			
            <td><?php if($v['updatetime']) echo date('Y-m-d H:i', $v['updatetime']);?></td>
            <td><?php echo $v['edit_author'];?></td>
            <!-- <td><?php if($v['store_time']) echo '已入库';?></td> -->
            <td>
                <a href="javascript:" class="ruku" data-id="<?php echo $v['id'];?>" data-date="<?php if($v['pay_time']) echo date('Y-m-d',$v['pay_time']); else echo 0; ?>" data-time="<?php if($v['pay_time']) echo date('H:i',$v['pay_time']); else echo 0;?>" data-num="<?php echo $v['store_num']; ?>">入库</a><br/>
                
                <a href="<?php if($v['instore_time']){?>javascript:<?php }else{ ?>index.php?act=pur&op=edit&id=<?php echo $v['id']; }?>" <?php if($v['instore_time']){?>style="color:grey"<?php }?>>编辑</a>
                
                <!-- <a href="javascript:" class="del-btn" data-id="<?php echo $v['id'];?>">删除</a> -->
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$('input[name="pay_date"]').datepicker({dateFormat: 'yy-mm-dd'});
$('.ruku').click(function(){
    $('#rk_div').show();
    $('input[name="order_id"]').val($(this).attr('data-id'));
    if($(this).attr('data-date'))
        $('input[name="pay_date"]').val($(this).attr('data-date'));
    if($(this).attr('data-time'))
        $('input[name="pay_time"]').val($(this).attr('data-time'));
    if($(this).attr('data-num'))
        $('input[name="store_num"]').val($(this).attr('data-num'));
});
$('.del-btn').click(function(){
    if(confirm('确认删除？')){
        $.post('index.php?act=pur&op=destroy', {'id':$(this).attr('data-id')}, function(data){
            if(data.status==1){
                window.location.reload();
            }else{
                alert(data.msg);
            }
        });
    }
});
$('#rk_submit').click(function(){
    if(!$('input[name="location"]').val()){
        alert('请输入货位');
    }else if(!$('input[name="pay_date"]').val()){
        alert('请输入支付时间');
    }else if(!$('input[name="store_num"]').val() || $('input[name="store_num"]').val() < 1){
        alert('请输入正确库存');
    }else{
        $.post('index.php?act=pur&op=store',{'form': 'ruku','id':$('input[name="order_id"]').val(),'location':$('input[name="location"]').val(),'date':$('input[name="pay_date"]').val(),'time':$('input[name="pay_time"]').val(),'num':$('input[name="store_num"]').val()}, function(data){
            if(data.status==1){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }, 'json')
    }
}); 
$('.table-close').click(function(){
    $(this).parent().hide();
});
</script>