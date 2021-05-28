<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DailyCheck class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/**
 * 출석체크 controller 입니다.
 */
class DailyCheck extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_daily_check');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('querystring', 'point'));
	}

    public function index()
    {
        $mem_id = (int) $this->member->item('mem_id');

		$view = array();
		$view['view'] = array();
        
        // if(!$mem_id || is_numeric($mem_id)){
        //     alert('유저 정보가 없습니다.\n로그인후 다시 시도해주세요' , '/');
        // }
		$layoutconfig = array(
			'path' => 'dailycheck',
			'layout' => 'layout',
			'skin' => 'index',
			'layout_dir' => 'cic_sub',
			'mobile_layout_dir' => 'cic_sub',
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
			'page_title' => '출석체크',
		);

		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

    function ajax_dailyCheck(){
        $mem_id = (int) $this->member->item('mem_id');
        $now = date('Y-m-d H:i:s');
        $ip = $this->input->ip_address();

        if(!$mem_id || is_numeric($mem_id)){
            $ajax_result = array('error' => '유저 정보가 없습니다.\n다시 로그인후 시도해주세요', 'code' => 1100);
            exit(json_encode($ajax_result));
        }

        $this->load->model(
			array(
				'CIC_vp_model',
				'CIC_cp_model',
				'CIC_vp_config_model',
				'CIC_cp_config_model',
			)
		);

        $vp_point = element('vpc_value' ,$this->CIC_vp_config_model->get_one('','',"vpc_id = 3 AND vpc_enable = 1"));
        $cp_point = element('cpc_value' ,$this->CIC_cp_config_model->get_one('','',"cpc_id = 3 AND cpc_enable = 1"));
        
        $vp_result = true;
        $cp_result = true;

        if($this->CIC_daily_check_model->checkDaily($mem_id)){
            $this->db->trans_start();
            if($this->CIC_daily_check_model->insertDailyCheck($mem_id, $ip, $vp_point, $cp_point)){
                if($vp_point){
                    $vp_result = $this->point->insert_vp(
                        $mem_id,
                        $vp_point,
                        $now . ' 출석체크 '.$vp_point.' VP 지급',
                        'dailyCheck',
                        $now,
                        '출석체크'
                    );
                }
    
                if($cp_point){
                    $cp_result = $this->point->insert_cp(
                        $mem_id,
                        $cp_point,
                        $now . ' 출석체크 '.$cp_point.' CP 지급',
                        'dailyCheck',
                        $now,
                        '출석체크'
                    );
                }
            }else{
                $ajax_result = array('error' => '이미 출석체크 하셨습니다.', 'code' => 1101);
                exit(json_encode($ajax_result));
            }
            $this->db->trans_complete();

            $ajax_result = array('success' => '출석이 완료되었습니다.');
            exit(json_encode($ajax_result));
        }
    }
}

?>