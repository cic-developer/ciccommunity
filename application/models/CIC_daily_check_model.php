<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_daily_check_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */

class CIC_daily_check_model extends CI_Model
{
	/**
	 * Initialise the model, tie into the CodeIgniter superobject and
	 * try our best to guess the table name.
	 */
	public function __construct()
	{
		parent::__construct();
	}

    function checkDaily($mem_id){
        $now = date('Y-m-d');
        $this->db->where('mem_id', $mem_id);
        $this->db->where('dc_date', $now);
        $result = $this->db->get('cic_daily_check')->result();
        if($result){
            return false;
        }else{
            return true;
        }
    }

    function insertDailyCheck($mem_id, $ip, $vp_point, $cp_point)
    {
        $now = date('Y-m-d');
        $vp_result = true;
        $cp_result = true;

        if($vp_point){
            $set = array(
                'dc_date'   => $now,
                'mem_id'    => $mem_id,
                'dc_ip'     => $ip,
                'dc_point'  => $vp_point,
                'dc_point_type' => 'vp'
            );

            $vp_result = $this->db->insert('cic_daily_check', $set);
        }

        if($cp_point){
            $set = array(
                'dc_date'   => $now,
                'mem_id'    => $mem_id,
                'dc_ip'     => $ip,
                'dc_point'  => $cp_point,
                'dc_point_type' => 'cp'
            );

            $cp_result = $this->db->insert('cic_daily_check', $set);
        }

        return ($vp_result && $cp_result);
    }
}
?>