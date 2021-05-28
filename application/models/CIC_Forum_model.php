<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Member Nickname model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class CIC_withdraw_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_forum_config';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'frm_key'; // 사용되는 테이블의 프라이머리키

	public $search_sfield = '';

	function __construct()
	{
		parent::__construct();
	}
	
}
