<?php
defined('ZQ-SHOP') or exit('Access Invalid!');
class goods_sourceControl extends SystemControl {
    
    public function __construct(){
        parent::__construct();
    }

    public function indexOp(){
        $table = Model('goods_source');
        $rows = $table->page(10)->order('id DESC')->select();
        while(list($k, $v) = each($rows)){
            $rows[$k]['goods'] = Model('goods')->find($v['goods_id']);
        }
        Tpl::output('show_page', $table->showpage(2));
        TPL::output('list', $rows);
        TPL::showpage('goods_source.index');
    }

    public function updateOp(){
        $status = intval($_POST['status']);
        $id = intval($_POST['id']);
        if($id)
            Model('goods_source')->where(array('id'=>$id))->update(array('status'=>$status));
    }
}