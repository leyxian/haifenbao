<?php
/**
 * 店铺卖家注销
 *
 * 
 *
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');

class seller_logoutControl extends BaseSellerControl {

	public function __construct() {
		parent::__construct();
	}

    public function indexOp() {
        $this->logoutOp();
    }

    public function logoutOp() {
        $this->recordSellerLog('注销成功');
        session_destroy();
        showMessage('注销成功', 'index.php?act=seller_login');
    }

}
