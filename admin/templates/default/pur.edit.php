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
    <form action="index.php?act=pur&op=update" method="post" name="order_form">
        <table class="table tb-type2">
            <tr>
                <td colspan="2">
                    <label class="validation">商品</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <select name="goods_id">
                        <option>请选择</option>
                        <?php if($output['goods']) foreach ($output['goods'] as $v) { ?>
                        <option value="<?php echo $v['id']; ?>" <?php if($output['order']['goods_id'] == $v['id']) echo 'selected'; ?>><?php echo $v['goods_name'].'&nbsp;'.$v['jap_name']; ?></option>
                        <?php } ?>
                    </select>
                    &nbsp;&nbsp;
                    <a href="javascript:" id="goods_add">添加新商品</a>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>商品规格：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt" type="text" value="<?php echo $output['order']['marque'];?>" name="marque" id="marque" maxlength="50" class="txt">
                    <select id="specifications" name="specifications">
                        <option value="">请选择</option>
                        <?php if($output['specs']) foreach ($output['specs'] as $v) { ?>
                        <option value="<?php echo $v['name'];?>" <?php if($output['order']['specifications'] == $v['name']) echo 'selected'; ?>><?php echo $v['name'];?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:" id="specifications_add">增加选项</a>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>供应商：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <select id="vender" name="vender">
                        <option value="">请选择</option>
                        <?php if($output['venders']) foreach ($output['venders'] as $v) { ?>
                        <option value="<?php echo $v['id'];?>" <?php if($output['order']['vender_id'] == $v['id']) echo 'selected'; ?>><?php echo $v['name'].'&nbsp;'.$v['link_user'].'&nbsp;'.$v['link_tel'];?></option>
                        <?php } ?>
                    </select>
                    <a href="javascript:" id="vender_add">增加选项</a>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>重量：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt" type="number" name="weight" id="weight" value="<?php echo round($output['order']['weight'],2); ?>"/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>体积：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt" type="number" name="volume" id="volume" value="<?php echo round($output['order']['volume'], 2); ?>"/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="validation">价格(日元)：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt" type="number" value="<?php echo $output['order']['jap_price']; ?>" name="jap_price" id="jap_price"/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>生产日期：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt date" type="text" value="<?php if($output['order']['good_date']) echo date('Y-m-d', $output['order']['good_date']); ?>" id="good_date" name="good_date">
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>保质期：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt date" type="text" value="<?php if($output['order']['good_time']) echo date('Y-m-d', $output['order']['good_time']); ?>" id="good_time" name="good_time">
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="validation">采购数量：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="txt" type="number" value="<?php echo $output['order']['store_num']; ?>" name="store_num" id="store_num"/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <label class="validation">支付时间：</label>
                </td>
            </tr>
            <tr>
                <td class="vatop">
                    <input class="w120" type="date" value="<?php if($output['order']['pay_time']) echo date('Y-m-d', $output['order']['pay_time']); ?>" name="pay_date" id="pay_date"/>
                    <input type="time" value="<?php if($output['order']['pay_time']) echo date('H:i', $output['order']['pay_time']); ?>" name="pay_time" id="pay_time"/>
                </td>
                <td class="vatop tips"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <input type="hidden" name="id" value="<?php echo $output['order']['id']; ?>"/>
                    <button id="order_submit">提交</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<style type="text/css">
    #vender_div, #spec_div, #goods_div { width: 300px; border: 3px solid #333; padding: 10px; position: fixed; background: #fff; left: 50%; top: 50%; display: none; }
    #vender_div, #spec_div, #goods_div { margin-left: -150px; }
    #vender_div { margin-top: -150px; }
    #spec_div { margin-top: -50px; }
    #goods_div { margin-top: -150px; }
    #vender_div a.table-close, #spec_div a.table-close, #goods_div a.table-close { position: absolute; right: 0; top: 0; margin: 10px; }
</style>
<!-- 产品 -->
<div id="goods_div" style="display:none;">
    <table class="table">
        <tr>
            <td><lable>产品名称：</lable></td>
        </tr>
        <tr>
            <td>
                <input class="w200" type="text" name="goods_name" value=""/>
            </td>
        </tr>
        <tr>
            <td><lable>日文名称：</lable></td>
            
        </tr>
        <tr>
            <td>
                <input class="w200" type="text" name="jap_name"/>
            </td>
        </tr>
        <tr>
            <td><button id="goods_submit">提交</button></td>
        </tr>
    </table>
    <a href="javascript:" class="table-close">关闭</a>
</div>
<!-- 供应商 -->
<div id="vender_div" style="display:none;">
    <table class="table">
        <tr>
            <td><label>供应商名称：</label></td>
        </tr>
        <tr>
            <td><input class="txt" type="text" name="vender_name" value=""/></td>
        </tr>
        <tr>
            <td><label>联系人：</label></td>
        </tr>
        <tr>
            <td><input class="txt" type="text" name="vender_user" value=""/></td>
        </tr>
        <tr>
            <td><label>电话：</label></td>
        </tr>
        <tr>
            <td><input class="txt" type="text" name="vender_tel" value=""/></td>
        </tr>
        <tr>
            <td><button id="vender_submit">提交</button></td>
        </tr>
    </table>
    <a href="javascript:" class="table-close">关闭</a>
</div>
<!-- 规格 -->
<div id="spec_div">
    <table class="table">
        <tr>
            <td><label>单位：</label></td>
        </tr>
        <tr>
            <td><input class="txt" type="text" name="spec_name" value=""/></td>
        </tr>
        <tr>
            <td><button id="spec_submit">提交</button></td>
        </tr>
    </table>
    <a href="javascript:" class="table-close">关闭</a>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#good_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#good_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#pay_date').datepicker({dateFormat: 'yy-mm-dd'});
    $("#goods_add").click(function(){
        $('#goods_div').show();
    });
    $('#specifications_add').click(function(){
        $('#spec_div').show();
    });
    $('#vender_add').click(function(){
        $('#vender_div').show();
    });
    $("#")
    $('.table-close').click(function(){
        $(this).parent().hide();
    });
    // 商品添加
    $('#goods_submit').click(function(){
        var goods_name = $('input[name="goods_name"]').val();
        var jap_name = $('input[name="jap_name"]').val();
        if(!goods_name){
            alert('请输入产品名称');
            $('input[name="goods_name"]').focus();
        }else{
            $.post('index.php?act=pur&op=store', {'form':'goods','goods_name':goods_name,'jap_name':jap_name}, function(data){
                if(data.status == 1){
                    $('select[name="goods_id"]').append('<option value="'+data.data.id+'" selected>'+goods_name+'&nbsp;'+jap_name+'</option>');
                    $('input[name="goods_name"]').val('');
                    $('input[name="jap_name"]').val('');
                    $('#goods_div').hide();
                }else{
                    alert(data.msg);
                }
            }, 'json');
        }
    });
    //规格提交
    $('#spec_submit').click(function(){
        var val = $('input[name="spec_name"]').val();
        if(!val){
            alert('请输入单位');
        }else{
            $.post('index.php?act=pur&op=store', {'name':val,'form':'spec'}, function(data){
                if(data.status==1){
                    $('#specifications').append('<option value="'+val+'" selected>'+val+'</option>');
                    $('input[name="spec_name"]').val('');
                    $('#spec_div').hide();
                }else{
                    alert(data.msg);
                }
            },'json');
        }
    });
    //供应商提交
    $('#vender_submit').click(function(){
        var name = $('input[name="vender_name"]').val();
        var user = $('input[name="vender_user"]').val();
        var tel = $('input[name="vender_tel"]').val();
        if(!name){
            alert('请输入供应商名称');
        }
        if(!user){
            alert('请输入联系人名');
        }
        if(!tel){
            alert('请输入联系电话');
        }
        $.post('index.php?act=pur&op=store',{'form':'vender','name':name,'user':user,'tel':tel},function(data){
            if(data.status == 1){
                $("#vender").append('<option value="'+data.data.id+'" selected>'+name+'&nbsp;'+user+'&nbsp;'+tel+'</option>');
                $('input[name="vender_name"]').val('');
                $('input[name="vender_user"]').val('');
                $('input[name="vender_tel"]').val('');
                $('#vender_div').hide();
            }else{
                alert(data.msg);
            }            
        }, 'json');
    });
    //商品更新
    $("#order_submit").click(function(){
        if(!$("select[name='goods_id']").val()){
            alert('请选择或添加商品');
            $("#goods_id").focus();
        }
        if(!$('#vender').val()){
            alert('供应商不能为空');
            $("#vender").focus();
        }
        if(!$('#jap_price').val()){
            alert('价格不能为空'); 
            $("#jap_price").focus();
        }
        if(!$('#store_num').val()){
            alert('采购数量不能为空'); 
            $("#store_num").focus();
        }
        $.post('index.php?act=pur&op=update', $('form[name="order_form"]').serialize(), function(data){
            if(data.status==1){
                alert('提交成功');
                window.location.href = 'index.php?act=pur';
            }else{
                alert(data.msg);
            }
        }, 'json');
        return false;
    });
});
</script>