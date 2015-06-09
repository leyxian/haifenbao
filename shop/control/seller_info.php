<?php
/**
 * 店铺基本信息维护
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');

class seller_infoControl extends BaseSellerControl {

    /**
     * 构造方法
     *
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 店铺基本信息设置
     *
     */
    public function indexOp() {
        Tpl::showpage('index');
    }

}