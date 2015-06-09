<?php
/**
 * 会员中心--收藏功能
 *  
 */
defined('ZQ-SHOP') or exit('Access Invalid!');

class member_shortstockcontrol extends BaseMemberControl {

    public function __construct(){
        parent::__construct();
        Language::read('member_layout,member_member_favorites');
    }

    public function indexOp(){
        echo 111;
    }

    public function listOp(){
        $table = Model('shortstock_goods');
        $list = $table->page(10)->order('gshort_id DESC')->select();
        Tpl::output('show_page',$table->showpage(2));
        $this->get_member_info();
        Tpl::output('list', $list);
        Tpl::output('store_favorites', $list);
        Tpl::output('menu_sign','shortstock_list');
        Tpl::showpage('member_shortstock_list');
    }
}