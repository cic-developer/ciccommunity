<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Contactus class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/** 
 * 문의 담당하는 controller 입니다.
 */
class Contactus extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	// protected $models = array('Contactus');

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
		$this->load->library(array('pagination', 'querystring'));
	}


	/**
	 * 출석체크 페이지입니다
	 */
	public function index()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_attendance_index';
		$this->load->event($eventname);

		/**
		 * 로그인이 필요한 페이지입니다
		 */
		required_user_login();
		
		if ( ! $this->cbconfig->item('use_attendance')) {
			alert('이 웹사이트는 출석체크 기능을 사용하지 않습니다');
		}
		$_date = $this->input->get('date') ? cdate('Y-m-01', strtotime($this->input->get('date'))) : cdate('Y-m-01');
		$start_week = cdate('w', strtotime($_date)); 		// 1. 시작 요일
		$total_day = cdate('t', strtotime($_date)); 		// 2. 현재 달의 총 날짜
		$total_day_lastmonth = cdate('t', strtotime('-1 month', strtotime($_date))); 		// 2. 현재 달의 총 날짜
		$total_week = ceil(($total_day + $start_week) / 7); // 3. 현재 달의 총 주차
		$after_date = 1;
		$before_date = $total_day_lastmonth - $start_week + 1;

		//달력데이터
		$view = array(
			'_date' 				=> $_date,
			'start_week' 			=> $start_week,
			'total_day' 			=> $total_day,
			'total_day_lastmonth' 	=> $total_day_lastmonth,
			'total_week' 			=> $total_week,
			'after_date' 			=> $after_date,
			'before_date' 			=> $before_date,
		);

		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		$attendance_default_memo = str_replace(
			array("\r\n", "\r", "\n"),
			"\n",
			$this->cbconfig->item('attendance_default_memo')
		);
		$default_memo = explode("\n", $attendance_default_memo);
		shuffle($default_memo);
		$view['view']['default_memo'] = $default_memo;
		
		// 한달동안 출석내역
		$view['view']['my_attend'] = $this->Attendance_model->get_this_month_attend($_date);
		$date = $this->input->get('date') ? $this->input->get('date') : cdate('Y-m-d');
		if (strlen($date) !== 10) {
			$date = cdate('Y-m-d');
		}
		$arr = explode('-', $date);
		if (checkdate(element(1, $arr), element(2, $arr), element(0, $arr)) === false) {
			$date = cdate('Y-m-d');
		}
		$view['view']['date'] = $date;
		$view['view']['date_format'] = cdate('Y년 m월 d일', strtotime($date));
		$view['view']['lastday'] = cdate('t', strtotime($date));
		$view['view']['ym'] = substr($date,0,7);
		$view['view']['d'] = substr($date,8,2);
		$view['view']['lastmonth'] = cdate('Y-m-d', strtotime(substr($date,0,8) . '01') - 86400);
		$view['view']['nextmonth'] = ($view['view']['ym'] < cdate('Y-m'))
			? cdate('Y-m-d', strtotime(substr($date,0,8) . cdate('t', strtotime($date))) + 86400) : '';

		$view['view']['canonical'] = site_url('attendance');

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 레이아웃을 정의합니다
		 */
		$page_title = $this->cbconfig->item('site_meta_title_attendance');
		$meta_description = $this->cbconfig->item('site_meta_description_attendance');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_attendance');
		$meta_author = $this->cbconfig->item('site_meta_author_attendance');
		$page_name = $this->cbconfig->item('site_page_name_attendance');

		$layoutconfig = array(
			'path' => 'attendance',
			'layout' => 'layout',
			'skin' => 'attendance',
			'layout_dir' => $this->cbconfig->item('layout_attendance'),
			'mobile_layout_dir' => $this->cbconfig->item('mobile_layout_attendance'),
			'use_sidebar' => $this->cbconfig->item('sidebar_attendance'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_attendance'),
			'skin_dir' => $this->cbconfig->item('skin_attendance'),
			'mobile_skin_dir' => $this->cbconfig->item('mobile_skin_attendance'),
			'page_title' => $page_title,
			'meta_description' => $meta_description,
			'meta_keywords' => $meta_keywords,
			'meta_author' => $meta_author,
			'page_name' => $page_name,
		);
		$view['layout'] = $this->managelayout->front($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

}
