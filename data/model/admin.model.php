<?php
/**
 * 管理员
 *  
 *
 */
defined('ZQ-SHOP') or exit('Access Invalid!');
class adminModel{
	/**
	 * 管理员列表
	 *
	 * @param array $condition 检索条件
	 * @param obj $obj_page 分页对象
	 * @return array 数组类型的返回结果
	 */
	public function getAdminList($condition,$obj_page){
		$condition_str = $this->_condition($condition);
		$param = array(
					'table'=>'admin',
					'field'=>'*',
					'where'=>$condition_str
				);
		$result = Db::select($param);
		return $result;
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 字符串类型的返回结果
	 */
	public function _condition($condition){
		$condition_str = '';
		
		if ($condition['admin_id'] != ''){
			$condition_str .= " and admin_id = '". $condition['admin_id'] ."'";
		}
		if ($condition['admin_name'] != ''){
			$condition_str .= " and admin_name = '". $condition['admin_name'] ."'";
		}
		if ($condition['admin_password'] != ''){
			$condition_str .= " and admin_password = '". $condition['admin_password'] ."'";
		}
		
		return $condition_str;
	}

	/**
	 * 构造seller检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 字符串类型的返回结果
	 */
	public function _conditionseller($condition){
		$condition_str = '';	

		if ($condition['seller_name'] != ''){
			$condition_str .= " and seller_name = '". $condition['seller_name'] ."'";
		}
		return $condition_str;
	}	
	/**
	 * 取单个管理员的内容
	 *
	 * @param int $admin_id 管理员ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneAdmin($admin_id){
		if (intval($admin_id) > 0){
			$param = array();
			$param['table'] = 'admin';
			$param['field'] = 'admin_id';
			$param['value'] = intval($admin_id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 获取管理员信息
	 *
	 * @param	array $param 管理员条件
	 * @param	string $field 显示字段
	 * @return	array 数组格式的返回结果
	 */
	public function infoAdmin($param, $field = '*') {
		if(empty($param)) {
			return false;
		}
		//得到admin条件语句
		$condition_str	= $this->_condition($param);
		$param	= array();
		$param['table']	= 'admin';
		$param['where']	= $condition_str;
		$param['field']	= $field;
		$admin_info	= Db::select($param);
		return $admin_info[0];
	}
	
	/**
	 * 获取seller表 管理员信息
	 *
	 * @param	array $param 管理员条件
	 * @param	string $field 显示字段
	 * @return	array 数组格式的返回结果
	 */
	public function infoAdminSeller($param, $field = '*') {
		if(empty($param)) {
			return false;
		}
			//得到seller条件语句
			$condition_str	= $this->_conditionseller($param);
			$param	= array();
			$param['table']	= 'seller';
			$param['where']	= $condition_str;
			$param['field']	= $field;
			$admin_info	= Db::select($param);	
			return $admin_info[0];		

	}	
	
	
	
	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
	 */
	public function addAdmin($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$result = Db::insert('admin',$tmp);
			return $result;
		}else {
			return false;
		}
	}
	
	/*将新添加的客服用户写入到seller表中
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
	public function addSeller($param){
		if (empty($param)){
			return false;
		}
			//$result = Db::insert('seller',$param);
			return $this->insert($param);
			//return $result;
	}	
	
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function updateAdmin($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = " admin_id = '". $param['admin_id'] ."'";
			$result = Db::update('admin',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 更新seller表信息
	 *updateSeller
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function updateSeller($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = " seller_id = '". $param['seller_id'] ."'";
			$result = Db::update('seller',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	/**
	 * 删除
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function delAdmin($id){
		if (intval($id) > 0){
			$where = " admin_id = '". intval($id) ."'";
			$result = Db::delete('admin',$where);
			return $result;
		}else {
			return false;
		}
	}
}