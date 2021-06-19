<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_cp_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */

class Mem_recommeder_model extends CB_Model
{

	/**
	 * 테이블명
	 */
	public $_table = 'mem_recommender';

	/**
	 * 사용되는 테이블의 프라이머리키
	 */
	public $primary_key = 'no'; // 사용되는 테이블의 프라이머리키

	function __construct()
	{
		parent::__construct();
	}

    function get_recommend_list($type = 'rec'){
        if($type == 'rec'){
            $this->db->where('rmd_rec_cp', 0);
            $this->db->where('rmd_rec_vp', 0);
        }else if($type == 'reg'){
            $this->db->where('rmd_cp', 0);
            $this->db->where('rmd_vp', 0);
        }else{
            return false;
        }
        $this->db->join('member AS rec_mem', 'mem_recommender.mem_rec_userid = rec_mem.mem_userid');
        $this->db->join('member AS user_mem', 'mem_recommender.mem_userid = user_mem.mem_userid');
        $this->db->select('mem_recommender.*, rec_mem.mem_nickname AS rec_nickname, user_mem.mem_nickname AS usr_nickname');
        $result['list'] = $this->db->get('mem_recommender')->result_array();
        if(!$result['list']){
            return false;
        }
        $result['total_rows'] = count($result['list']);
        return $result;
    }
}
