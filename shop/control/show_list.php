<?php
defined('ZQ-SHOP') or exit('Access Invalid!');
/**
 * 产品类列表
 */
class show_listControl extends BaseGoodsControl {

    public function __construct(){
        parent::__construct();
    }

    /**
     * [indexOp 列表]
     * @return [type] [description]
     */
    public function indexOp(){
        $page = max(1, intval($_GET['page']));
        $table = Model('goods');
        $rows = $table->page(6)->order('goods_id DESC')->select();
        while (list($k, $v) = each($rows)) {
            $row = Model('goods_common')->field('goods_costprice')->find($v['goods_commonid']);
            $rows[$k]['goods_costprice'] = $row['goods_costprice'];
        }
        Tpl::output('show_page', $table->showpage(2));
        Tpl::output('list', $rows);
        Tpl::showpage('show_list.index');
    }

    /**
     * [addOp 选择商品]
     */
    public function addOp(){
        $gids = $_POST['gids'];
        if(empty($gids))
            showMessage('请选择商品', 'index.php?act=show_list');
        $table = Model('goods');
        foreach ($gids as $v) {
            $rows[] = $table->find($v);
        }
        Tpl::output('list', $rows);
        Tpl::showpage('show_list.add');
    }

    /**
     * [storeOp 提交]
     * @return [type] [description]
     */
    public function storeOp(){
        $row = Model('member')->field('member_truename')->find($_SESSION['member_id']);
        $table = Model('goods_source');
        if($_POST['gids']){
            foreach ($_POST['gids'] as $k => $v) {
                $data['goods_id'] = $v;
                $data['member_id'] = $_SESSION['member_id'];
                $data['member_truename'] = $row['member_truename'];
                $data['goods_price'] = $_POST['price'][$k];
                $data['goods_url'] = $_POST['url'][$k];
                $data['remark'] = $_POST['remark'][$k];
                $data['udate'] = $_SERVER['REQUEST_TIME'];
                $row2 = $table->field('id')->where('member_id='.$_SESSION['member_id'].' AND goods_id='.$v)->find();
                if($row2){
                    $data['id'] = $row2['id'];
                }else{
                    $data['cdate'] = $_SERVER['REQUEST_TIME'];
                }
                print_r($data);
                $table->insert($data, true); unset($data);
            }
            showMessage('提交成功', 'index.php?act=show_list');
        }else{
            showMessage('提交错误', 'index.php?act=show_list');
        }
    }
}