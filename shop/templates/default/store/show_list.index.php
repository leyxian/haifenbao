<?php defined('ZQ-SHOP') or exit('Access Invalid!');?>
<style type="text/css">
    ul.rows-list { padding: 10px; }
    ul.rows-list  li { border-bottom: 1px solid #333; height: 180px; }
    ul.rows-list li:last-child { border: none; }
    ul.rows-list li img { width: 140px; height: 140px; }
    .list-1, .list-2, .list-3 { display: inline-block; height: 100%; }
    .list-1 { width: 350px; overflow: hidden; padding-left: 20px; }
    .list-2 { width: 600px; text-align: center; padding-top: 20px; }
    .list-2 div { width: 200px; margin: 0 auto; text-align: left; }
    .list-2, .list-3 { vertical-align: top; }
    .list-3 { line-height: 180px; font-size: 14px; font-weight: bold; }
    .pagination{ padding: 2px; float: right; }
    .addmore { padding: 6px 12px; position: fixed; right: 50px; background: #666; border-radius: 15px; color: #fff; top:45%; }
    .addmore:hover { color: #CA771B; }
    .open-box { position: fixed; top: 50%; left: 50%; width: 600px; height: 400px; background: #fff; border: 4px solid #333; margin-top: -200px; margin-left: -300px;  overflow-y: scroll;}
    .pagination ul{ margin: 0; padding: 0; font-size: 12px; text-align: left;}
    .pagination ul li { display: inline; list-style-type: none; float: left; padding:0 !important; margin: 0 !important; border:none !important;}
    .pagination li span{font-size: 12px; color: #999; list-style-type: none; display: inline; float: left; padding: 0px 5px; margin: 0px 2px; border: 1px solid #CCC;}
    .pagination li a span , .pagination li a:visited span{ color: #6C92AD; text-decoration: none; border-color: #6C92AD; cursor:pointer;}
    .pagination li a:hover span, .pagination li a:active span{ color: #996600; background-color: #FAF6D6; border-color: #996600; cursor:pointer;}
    .pagination li span.currentpage{ color:#FFF; font-weight: bold;  background-color: #539CD5; border-color: #21589B;}
</style>
<a href="javascript:" class="addmore">我有更低价的货源</a>
<div style="margin: 10px 0;">
    <form method="post" action="index.php?act=show_list&op=add" id="add_list">
    <ul class="rows-list">
        <?php foreach ($output['list'] as $v) { ?>
        <li id="li_<?php echo $v['goods_id'];?>">
            <div class="list-1">
                <a href="index.php?act=goods&op=index&goods_id=<?php echo $v['goods_id']?>" target="_blank"><?php echo $v['goods_name'];?></a><br/>
                <img src="<?php echo thumb($v, 'small');?>">
            </div>
            <div class="list-2">
                <div>
                    <label>市场价</label>&nbsp;&nbsp;&nbsp;&nbsp;￥<?php echo $v['goods_marketprice'];?><br/>
                    <label>商品价</label>&nbsp;&nbsp;&nbsp;&nbsp;￥<?php echo $v['goods_price'];?><br/>
                    <label>成本价</label>&nbsp;&nbsp;&nbsp;&nbsp;￥<?php echo $v['goods_costprice'];?>
                </div>
            </div>
            <div class="list-3">
                <label><input type="checkbox" name="gids[]" value="<?php echo $v['goods_id']; ?>"/>勾选</label>
            </div>
        </li>
        <?php } ?>
    </ul>
    </form>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <div class="clear"></div>
</div>
<script type="text/javascript">
$(function(){
    $('.addmore').click(function(){
        if(!$("input[name='gids[]']:checked").val()){
            alert('请选择商品');
        }else{
            $('#add_list').submit();
        }
    });
});
</script>