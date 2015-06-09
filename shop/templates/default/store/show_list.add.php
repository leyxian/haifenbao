<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<style type="text/css">
    .main { border : 1px solid #ddd; margin: 10px; padding-left: 10px; padding-bottom: 10px; }
    .main textarea { vertical-align: top; width: 400px; }
    .main .list li img { width: 80px; height: 80px; vertical-align: middle; }
    .main .list li div{ display: inline-block; vertical-align: middle; line-height: 20px; line-height: 30px; }
    .main .list li div:first-child { width: 350px; overflow: hidden; }
    .main label { width: 80px; display: inline-block; font-size: 14px; font-weight: bold;}
    .form-group { text-align: center; }
    .form-group img { vertical-align: middle; }
    .main .input-submit { padding: 6px 12px; }
</style>
<div class="main">
    <form action='index.php?act=show_list&op=store' method="post" id="store_form">
    <ul class="list">
        <?php foreach ($output['list'] as $v) { ?>
            <li>
                <div>
                    <a href="index.php?act=goods&op=index&goods_id=<?php echo $v['goods_id']?>" target="_blank"><?php echo $v['goods_name'];?></a><br/>
                    <font style="color:red;">￥<?php echo $v['goods_price'];?></font><br/>
                    <img src="<?php echo thumb($v, 'small');?>">
                    <input type="hidden" name="gids[]" value="<?php echo $v['goods_id'];?>"/>
                </div>
                <div class="w400">
                    <label>您的价格</label><input class="w80" type="text" name="price[]" placeholder="0.00"/>￥<br/>
                    <label>货源链接</label><input class="w250" type="text" name="url[]" placeholder="http://"/>
                </div>
                <div>
                    <label>说明信息</label><textarea rows="3" name="remark[]" placeholder="请提供您的联系方式，地址等额外信息(限140字)。" onKeyUp='if (this.value.length>=20){ this.value=this.value.substr(0, 139);}'></textarea>
                </div>
            </li>
        <?php }?>
    </ul>
    <div class="form-group">
        <label>验证码</label><input class="w80" type="text" id="code"/>&nbsp;&nbsp;<img id="codeimg" src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>">&nbsp;&nbsp;
        <a href="javascript:changeimg();">换一张？</a>
        <br/><br/>
        <input class="input-submit" type="submit" value="提交">
    </div>
    </form>
</div>
<script type="text/javascript">
function changeimg(){
    $('#codeimg').attr('src', 'index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>'+'&t='+Math.random());
}
var check_code = false;
$("#code").blur(function(){
    $.get('index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>&captcha='+$('#code').val(), function(data){
        if(data == 'true')
            check_code = true;
        else
            check_code = false;
    });
});
var check_price = false;
var check_url = false;
$('#store_form').submit(function(){
    $("input[name='price[]']").each(function(){
        if(!$(this).val()){
            alert('价格不能为空');
            $(this).focus();
            check_price = false;
            return check_price;
        }else if(!/^\d+.?\d{0,2}$/.test($(this).val())) {
            alert('请输入正确的价格');
            $(this).focus();
            check_price = false;
            return check_price;
        }else{
            check_price = true;
        }
    });
    if(!check_price) return false;
    if(!check_code){
        alert('请检查验证码是否填写正确'); return false;
    }
});
</script>