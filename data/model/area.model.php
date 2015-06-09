<?php
/**
 * 地区模型
 *
 *
 *
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');

class areaModel extends Model{

    public function __construct() {
        parent::__construct('area');
    }

    public function getAreaList($condition = array(),$fields = '*', $group = '') {
        return $this->where($condition)->field($fields)->limit(false)->group($group)->select();
    }
}