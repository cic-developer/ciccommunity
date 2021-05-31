<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Board_post class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 게시판 목록과 게시물 열람 페이지에 관한 controller 입니다.
 */
class News extends CB_Controller
{

	/**
	 * 모델을 로딩합니다
	 */
	protected $models = array('News', 'Company');


	protected $modelname = 'News_model';


	/**
	 * 헬퍼를 로딩합니다
	 */
	protected $helpers = array('form', 'array', 'number');

	function __construct()
	{
		parent::__construct();

		/**
		 * 라이브러리를 로딩합니다
		 */
		$this->load->library(array('pagination', 'querystring', 'accesslevel', 'videoplayer', 'point', 'cic_company'));
	}


	/**
	 * 게시판 목록입니다.
	 */
	public function index()
	{
		/* 최초 뉴스 접속시 주요뉴스를 불러오는 인덱스 입니다.
		*/

		$eventname = 'event_news_post_list';
		$this->load->event($eventname);
		
		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
		$where = array(
			'news_reviews >' => 0,
			// 'news_important >' => 0,
		);
		if($compid = (int) $this->input->get('comp_id')){
			$where['news.comp_id'] = $compid;
		}
		$most_view = $this->{$this->modelname}
		->most_view_news($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $most_view['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $most_view)) {
			foreach (element('list', $most_view) as $key => $val) {
				$most_view['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
				if($company) {
					$most_view['list'][$key]['companyurl'] = element('comp_url', $company);
					$most_view['list'][$key]['newsurl'] = element('comp_url',$company) . element('comp_segment',$company) . element('news_index',$val);
				}
				$most_view['list'][$key]['num'] = $list_num--;
			}
		}
		// print_r($most_view);
		// exit;
		
		$where = array(
			// 'news_reviews >' => 0,
			'news_important >' => 0,
		);

		if($compid = (int) $this->input->get('comp_id')){
			$where['news.comp_id'] = $compid;
		}
		
		$result = $this->{$this->modelname}
		->important_news($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
				if($company) {
					$result['list'][$key]['companyurl'] = element('comp_url', $company);
					$result['list'][$key]['newsurl'] = element('comp_url',$company) . element('comp_segment',$company) . element('news_index',$val);
				}
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		// 	print_r($result);
		// exit;

		$view['view']['most_view'] = $most_view;
		$view['view']['data'] = $result;
		
		
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$page_title = $this->cbconfig->item('site_meta_title_news');
		$meta_description = $this->cbconfig->item('site_meta_description_news');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_news');
		$meta_author = $this->cbconfig->item('site_meta_author_news');
		$page_name = $this->cbconfig->item('site_page_name_news');
		
		$layoutconfig = array(
			'path' => 'news',
			'layout' => 'layout',
			'skin' => 'news',
			'layout_dir' => 'cic_sub',
			'mobile_layout_dir' => 'cic_sub',
			'use_sidebar' => $this->cbconfig->item('sidebar_news'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_news'),
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
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

	public function latestnews()
	{
		$eventname = 'event_news_post_list';
		$this->load->event($eventname);
		
		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
		
		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
		$where = array(
			'news_reviews >' => 0,
			// 'news_important >' => 0,
		);
		$most_view = $this->{$this->modelname}
		->most_view_news($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $most_view['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $most_view)) {
			foreach (element('list', $most_view) as $key => $val) {
				// $most_view['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
				// if($company) {
					// $most_view['list'][$key]['companyurl'] = element('comp_url', $company);
					// print_r(element('news_index',$val));
					// exit;
					// $most_view['list'][$key]['newsurl'] = element('comp_url',$company) . element('comp_segment',$company) . element('news_index',$val);
				// }
				$most_view['list'][$key]['num'] = $list_num--;
			}
		}
		// print_r($most_view);
		// exit;
		
		$where = array(
		);

		if($compid = (int) $this->input->get('comp_id')){
			$where['news.comp_id'] = $compid;
		}
		
		$result = $this->{$this->modelname}
		->latest_news($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				// $result['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
				// if($company) {
					// $result['list'][$key]['companyurl'] = element('comp_url', $company);
					// print_r(element('news_index',$val));
					// exit;
					// $result['list'][$key]['newsurl'] = element('comp_url',$company) . element('comp_segment',$company) . element('news_index',$val);
				// }
				$result['list'][$key]['num'] = $list_num--;
			}
		}

		// 	print_r($result);
		// exit;

		$view['view']['most_view'] = $most_view;
		$view['view']['data'] = $result;
		
		
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$page_title = $this->cbconfig->item('site_meta_title_news');
		$meta_description = $this->cbconfig->item('site_meta_description_news');
		$meta_keywords = $this->cbconfig->item('site_meta_keywords_news');
		$meta_author = $this->cbconfig->item('site_meta_author_news');
		$page_name = $this->cbconfig->item('site_page_name_news');
		
		$layoutconfig = array(
			'path' => 'news',
			'layout' => 'layout',
			'skin' => 'latestnews',
			'layout_dir' => 'cic_sub',
			'mobile_layout_dir' => 'cic_sub',
			'use_sidebar' => $this->cbconfig->item('sidebar_news'),
			'use_mobile_sidebar' => $this->cbconfig->item('mobile_sidebar_news'),
			'skin_dir' => 'cic',
			'mobile_skin_dir' => 'cic',
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