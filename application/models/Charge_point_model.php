<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Charge point model class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

class Charge_point_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'charge_point';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'cp_id'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

}
