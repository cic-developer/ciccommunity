<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forum model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class CIC_forum_info_model extends CB_Model
{
    public $_table = 'cic_forum_info';

    public $primary_key = 'pst_id'; // 사용되는 테이블의 프라이머리키

    public $cache_name= 'forum-info-get'; // 캐시 사용시 프리픽스

    public $cache_time = 86400; // 캐시 저장시간

    function __construct()
	{
		parent::__construct();
	}


}