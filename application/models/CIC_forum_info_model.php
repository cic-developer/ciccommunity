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

    // // get_repart_ratio는 포럼에서 1 cp당 n cp를 지급해야 하는 비율이 나옵니다.
    // // 만일 frm_additional_value(cp 가산 지급률)이 지정되어 있지 않은 경우 가산 지급률 없이 계산됩니다.
    // function get_repart_ratio($repart_cp = 0, $pst_id = 0, $win_option = 0){
    //     // $repart_cp : 보상가능한 실제 최대 cp, controller에서 계산되어 나와야 합니다.
    //     // $pst_id : post table의 post_id를 통해 cic_forum, cic_forum_info table과 join하여 필요한 데이터를 가져온다.
    //     if($repart_cp && $pst_id && $win_option){
    //         $this->db->where('pst_id', $pst_id);
    //         $_view_data = $this->db->get('cic_forum_view')->row_array();
    //         if($_view_data && is_array($_view_data)){
    //             if(($_add_value = element('frm_additional_value', $_view_data))){
    //                 $_max_timestamp = element('max_timestamp',$_view_data);
                    
    //             }else{

    //             }

    //             $this->db->where('pst_id', $pst_id);
    //             $this->db->group_by('pst_id');
    //             $_list = $this->db->get('cic_forum_cp')->result_array();

    //         }else{
    //             return false;
    //         }
    //     }else{
    //         return false;
    //     }

    // }
}