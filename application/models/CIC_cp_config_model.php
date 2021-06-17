<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_cp_config_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */

class CIC_cp_config_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_cp_config';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cpc_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

}

?>