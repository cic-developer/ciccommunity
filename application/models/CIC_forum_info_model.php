<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_forum_info_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
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

    public function forum_midway_closing($pst_id)
    {
        $where = array(
            'pst_id' => $pst_id,
        );
        $updatedata = array(
            'frm_bat_close_datetime' => date('Y-m-d H:i:s'),
            'frm_close_datetime' => date('Y-m-d H:i:s'),
        ); 

        return $this->update('', $updatedata, $where);
    }
}