<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forum model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class CIC_forum_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'cic_forum_config';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $meta_key = 'frm_key';

	public $meta_value = 'frm_value';

	public $cache_name= 'forum-model-get'; // 캐시 사용시 프리픽스

	public $cache_time = 86400; // 캐시 저장시간

	function __construct()
	{
		parent::__construct();
	}
	
	public function get_forum_list(){

		return ;
	}
}
