<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 관리자 메인 controller 입니다.
 */
class Deposit extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('CIC_cp', 'Member');

	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array' );

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'member'));
	}

	/**
	 * 
	 */
	public function index()
	{
		exit;
	}

	/**
	 * insert
	 */
	public function insert()
	{
        
	}

	/**
	 * subtract
	 */
	public function subtract()
	{
        // cp 반환 기록 + member 예치금 제거

        // 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_deposit_ajax_subtract';
		$this->load->event($eventname);
        
		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
        
		$view = array();
		$view['view'] = array();
        
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

        $mem_id = (int) $this->member->item('mem_id');
        $mem_cp = $this->member->item('mem_cp');
        $mem_deposit = $this->member->item('mem_deposit');

        // 예치금 제거 + cp 반환
        if($mem_deposit){
            $arr = array(
                'mem_cp' => $mem_cp + $mem_deposit,
                'mem_deposit' => null,
            );
            $memResult = $this->Member_model->set_user_modify($mem_id, $arr);

            // cp 로그 기록
            if($memResult == 1){
                $logResult = $this->CIC_cp_model->set_cic_cp($mem_id, '', $mem_deposit, '@byself', $mem_id, '예치금 반환');

                $result = array(
                    'state' => '1',
                    'message' => '예치금이 반환 되었습니다',
                );
                exit(json_encode($result));
            }else {
                $result = array(
                    'state' => '0',
                    'message' => '예치금 반환후 로그기록에 실패하였습니다',
                );
                exit(json_encode($result));
            }
        }else {
            $result = array(
				'state' => '0',
				'message' => '반환할 예치금이 없습니다',
			);
			exit(json_encode($result));
        }
	}
}
