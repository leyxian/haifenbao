<?php
/**
 * 广告展示
 *
 * 
 *
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');
class advControl {
    /**
	 * 
	 * 广告展示
	 */
	public function advshowOp(){
		import('function.adv');
		$ap_id = intval($_GET['ap_id']);
		echo advshow($ap_id,'js');
	}
}