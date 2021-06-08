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
	protected $models = array('CIC_cp', 'Member', 'CIC_forum_config', 'Post');

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
     * 
     * 추가되어야 할 사항
     * 1. 예치금을 넣을 때 진행중 혹은 승인대기 글이 있는지 확인 (board id 3, 6) 해야할까? 이미 cp로 확인중인데... 흠
     * 
	 */
	public function insert()
	{
        // cp 차감 기록 + member 예치금 추가
        
        // 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_deposit_ajax_insert';
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
        $mem_cp = (double) $this->member->item('mem_cp');
        $deposit_meta = (double) $this->CIC_forum_config_model->item('forum_deposit');
        $mem_deposit = (double) $this->member->item('mem_deposit');

        if( $mem_cp - $deposit_meta < 0){
            $result = array(
                'state' => '0',
                'message' => '예치금이 부족합니다',
            );
            exit(json_encode($result));
        }
        
        // 예치금 추가 + cp 차감
        if(!$mem_deposit){
            $arr = array(
                'mem_cp' => $mem_cp - $deposit_meta,
                'mem_deposit' => $deposit_meta,
            );
            $memResult = $this->Member_model->set_user_modify($mem_id, $arr);
            
            if($memResult == 1){
                // cp 로그 기록
                $logResult = $this->CIC_cp_model->set_cic_cp($mem_id, '', -$deposit_meta, '@byself', $mem_id, '예치금 넣기');
                
                $result = array(
                    'state' => '1',
                    'message' => $deposit_meta.'cp를 예치하였습니다',
                );
                exit(json_encode($result));

            }else {
                $result = array(
                    'state' => '0',
                    'message' => 'cp 예치에 실패하였습니다',
                );
                exit(json_encode($result));
            }
        }else {
            $result = array(
				'state' => '0',
				'message' => '이미 예치된 cp가 존재합니다',
			);
			exit(json_encode($result));
        }
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

        $checktime = cdate('Y-m-d H:i:s', ctimestamp());
        $mem_id = (int) $this->member->item('mem_id');
        $mem_cp = (double) $this->member->item('mem_cp');
        $mem_deposit = (double) $this->member->item('mem_deposit');
        
        $where3 = array(
            'brd_id' => 3,
            'mem_id' => $mem_id,
            'cic_forum_info.frm_close_datetime >=' => $checktime,
        );
        $where6 = array(
            'brd_id' => 6,
            'mem_id' => $mem_id,
            'post_category' => '1',
        );
        
        $post3 = $this->Post_model->get_one('', '', $where3);
        $post6 = $this->Post_model->get_one('', '', $where6);

        if($post3 || $post6) {
            $result = array(
                'state' => '0',
                'message' => '작성된 포럼이 존재합니다',
            );
            exit(json_encode($result));
        }
        
        // 예치금 제거 + cp 반환
        if($mem_deposit){
            $arr = array(
                'mem_cp' => $mem_cp + $mem_deposit,
                'mem_deposit' => null,
            );
            $memResult = $this->Member_model->set_user_modify($mem_id, $arr);
            
            if($memResult == 1){
                // cp 로그 기록
                $logResult = $this->CIC_cp_model->set_cic_cp($mem_id, '', $mem_deposit, '@byself', $mem_id, '예치금 반환');
                
                $result = array(
                    'state' => '1',
                    'message' => '예치금이 반환 되었습니다',
                );
                exit(json_encode($result));

                // $logResult false반환값 확인 필요7
                // if($logResult == 1){
                // }else {
                //     $result = array(
                //         'state' => '0',
                //         'message' => '예치금 반환후 로그기록에 실패하였습니다',
                //     );
                //     exit(json_encode($result));
                // }
            }else {
                $result = array(
                    'state' => '0',
                    'message' => '예치금이 반환에 실패하였습니다',
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
