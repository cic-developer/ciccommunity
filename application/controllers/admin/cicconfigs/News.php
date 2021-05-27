<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class News extends CB_Controller
{
    public $pagedir = 'cicconfigs/news';

    protected $models = array('News', 'Company');


    protected $modelname = 'News_model';


    protected $helpers = array('form', 'array');


    function __construct()
    {
        parent::__construct();

        $this->load->library(array('pagination', 'querystring', 'cic_company')); 
    }

	public function index()
    {
 		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_news_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */

		
		
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
		$where = array(
			// 'news_show' => 1,
			// 'news_enable' => 1,
		);

		if($compid = (int) $this->input->get('comp_id')){
			$where['news.comp_id'] = $compid;
		}

		$result = $this->{$this->modelname}
			->get_news_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
				if($company) {
					$result['list'][$key]['companyurl'] = element('comp_url', $company);
					// print_r(element('news_index',$val));
					// exit;
					$result['list'][$key]['newsurl'] = element('comp_url',$company) . element('comp_segment',$company) . element('news_index',$val);
				}
				$result['list'][$key]['num'] = $list_num--;


			}
		}
		$view['view']['data'] = $result;

		$select ='comp_id, comp_name';
		$view['view']['companylist'] = $this->Company_model->get_company_list();


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('news_title' => '뉴스제목', 'news_id' => '뉴스번호', 'news_wdate' => '작성일');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['update_news_enable_0_url'] = admin_url($this->pagedir . '/update_news_enable_0/?' . $param->output());
		$view['view']['update_news_show_0_url'] = admin_url($this->pagedir . '/update_news_show_0/?' . $param->output());
		$view['view']['update_news_important_url'] = admin_url($this->pagedir . '/update_news_important/?' . $param->output());
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'index');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

	public function enable()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_news_enable';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
        $where = array(
			'news_enable ' => 0
		);

		$result = $this->{$this->modelname}
			->get_news_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('news_title' => '제목', 'news_id' => '뉴스번호',   'news_wdate' => '작성일');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['update_news_enable_1_url'] = admin_url($this->pagedir . '/update_news_enable_1/?' . $param->output());
		
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'enable');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function show()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_news_show';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
        $where = array(
			'news_show ' => 0
		);

		$result = $this->{$this->modelname}
			->get_news_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('news_title' => '제목', 'news_id' => '뉴스번호',   'news_wdate' => '작성일');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['update_news_show_1_url'] = admin_url($this->pagedir . '/update_news_show_1/?' . $param->output());
		
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'show');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function most_view_news()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_most_view_news_index';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */

		
		
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
		$where = array(
			'news_show' => 1,
			'news_enable' => 1,
			'news_reviews >' => 0,
		);

		if($compid = (int) $this->input->get('comp_id')){
			$where['news.comp_id'] = $compid;
		}

		$result = $this->{$this->modelname}
			->most_view_news($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
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
		$view['view']['data'] = $result;

		$select ='comp_id, comp_name';
		$view['view']['companylist'] = $this->Company_model->get_company_list();


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('news_title' => '뉴스제목', 'news_id' => '뉴스번호', 'news_wdate' => '작성일');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['update_news_enable_0_url'] = admin_url($this->pagedir . '/update_news_enable_0/?' . $param->output());
		$view['view']['update_news_show_0_url'] = admin_url($this->pagedir . '/update_news_show_0/?' . $param->output());
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'most_view_news');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function important()
	{
 		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_news_important';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */

		
		
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
		$where = array(
			'news_important >' => 0,
		);
		// print_r('hello');
		// exit;

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
		$view['view']['data'] = $result;

		$select ='comp_id, comp_name';
		$view['view']['companylist'] = $this->Company_model->get_company_list();


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('news_title' => '뉴스제목', 'news_id' => '뉴스번호', 'news_wdate' => '작성일');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['update_news_enable_0_url'] = admin_url($this->pagedir . '/update_news_enable_0/?' . $param->output());
		$view['view']['update_news_show_0_url'] = admin_url($this->pagedir . '/update_news_show_0/?' . $param->output());
		$view['view']['update_news_important_0_url'] = admin_url($this->pagedir . '/update_news_important_0/?' . $param->output());
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'important');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function company_config()
	{
 		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_cicconfigs_news_company_config';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		/**
		 * 페이지에 숫자가 아닌 문자가 입력되거나 1보다 작은 숫자가 입력되면 에러 페이지를 보여줍니다.
		 */
		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'news_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

		$per_page = admin_listnum();
		$offset = ($page - 1) * $per_page;
		/**
		 * 게시판 목록에 필요한 정보를 가져옵니다.
		 */


		
		$this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id', 'news_reviews', 'news_wdate'); // 검색이 가능한 필드
		$this->{$this->modelname}->search_field_equal = array('news_id'); // 검색중 like 가 아닌 = 검색을 하는 필드
		$this->{$this->modelname}->allow_order_field = array('news_id'); // 정렬이 가능한 필드
		
		$where = array(
			// 'news_show' => 1,
			// 'news_enable' => 1,
		);

		if($compid = (int) $this->input->get('comp_id')){
			$where['news.comp_id'] = $compid;
		}
		
		$result = $this->Company_model
		->get_company_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
		$list_num = $result['total_rows'] - ($page - 1) * $per_page;
		
		if (element('list', $result)) {
			// print_r(element('list', $result));
			// exit;
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
				if($company) {
					$result['list'][$key]['companyurl'] = element('comp_url', $company);
					// print_r(element('news_index',$val));
					// exit;
					$result['list'][$key]['newsurl'] = element('comp_url',$company) . element('comp_segment',$company) . element('news_index',$val);
				}
				$result['list'][$key]['num'] = $list_num--;
			}
		}
		$view['view']['data'] = $result;

		$select ='comp_id, comp_name';
		$view['view']['companylist'] = $this->Company_model->get_company_list();


		/**
		 * primary key 정보를 저장합니다
		 */
		$view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

		/**
		 * 페이지네이션을 생성합니다
		 */
		$config['base_url'] = admin_url($this->pagedir) . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;

		/**
		 * 쓰기 주소, 삭제 주소등 필요한 주소를 구합니다
		 */
		$search_option = array('comp_name' => '신문사 이름', 'comp_id' => '신문사 번호',);
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
        $view['view']['update_news_enable_0_url'] = admin_url($this->pagedir . '/update_news_enable_0/?' . $param->output());
		$view['view']['update_news_show_0_url'] = admin_url($this->pagedir . '/update_news_show_0/?' . $param->output());
		$view['view']['update_news_important_url'] = admin_url($this->pagedir . '/update_news_important/?' . $param->output());
		$view['view']['company_write_url'] = admin_url($this->pagedir . '/company_write/?' . $param->output());
		
		// 이벤트가 존재하면 실행합니다
		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		/**
		 * 어드민 레이아웃을 정의합니다
		 */
		$layoutconfig = array('layout' => 'layout', 'skin' => 'company_config');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}


	public function company_write($comp_id = 0)
	{
		$eventname = 'event_admin_ciccinfigs_update_company';
		$this->load->event($eventname);

		$view = array();
		$view['view'] = array();

		$view['view']['event']['before'] = Events::trigger('before', $eventname);

		if($comp_id) {
			$comp_id = (int) $comp_id;
			if(empty($comp_id) OR $comp_id < 1 ){
				show_404();
			}
		}

		$primary_key = $this->Company_model->primary_key;

		$getdata = array();
		if ($comp_id) {
			$getdata = $this->Company_model->get_one($comp_id);
		} else {
			// 기본값 설정
		}

		$this->load->library('form_validation');

		$config = array(
			array(
				'field' => 'comp_url',
				'lable' => 'URL',
				'rules' => 'prep_url|valid_url',
			),
			array(
				'field' => 'comp_segment',
				'lable' => 'Segment',
				'rules' => 'trim|required|min_length[2]|max_length[30]',
			),
			array(
				'field' => 'comp_active',
				'lable' => '활성화',
				'rules' => 'trim|required|[0 === 비활성화 , 1 === 활성화 ]',
			),
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {

			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);
			$updatedata = array(
				'comp_name' => $this->input->post('comp_name', null, ''),
				'comp_url' => $this->input->post('comp_url', null, ''),
				'comp_segment' => $this->input->post('comp_segment', null, ''),
				'comp_active' => $this->input->post('comp_active', null, ''),
			);

			if ($this->input->post($primary_key)) {
				$this->Company_model->update($this->input->post($primary_key), $updatedata);
				$this->session->set_flashdata(
					'message',
					'정상적으로 수정되었습니다'
				);
			}
			$redirecturl = admin_url($this->pagedir);
			redirect($redirecturl);
		}
		
		$param =& $this->querystring;
		$getdata = array();
		if ($comp_id) {
			$getdata = $this->Company_model->get_one($comp_id);
		} else {
			// 기본값 설정
		}

		$view['view']['data'] = $getdata;
		$view['view']['list_url'] = admin_url($this->pagedir . '?' . $param->output());

		$view['view']['primary_key'] = $primary_key;

		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$layoutconfig = array('layout' => 'layout', 'skin' => 'company_write');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

	public function company_write_exchange($comp_id = 0)
	{
		
		$eventname = 'event_admin_ciccinfigs_maincoin_coin';
		$this->load->event($eventname);

		
		$view = array();
		$view['view'] = array();
		
		$view['view']['event']['before'] = Events::trigger('before', $eventname);
		print_r($comp_id);
		exit;
		
		// $comp_id = (int) $comp_id;
		// if (empty($comp_id) OR $comp_id < 1) {
		// 		show_404();
		// }

		$primary_key = $this->Company_model->primary_key;
		
		$param =& $this->querystring;
		$findex = 'comp_id';
		$forder = 'desc';
		
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'comp_id',
				'label' => '신문사 id',
				'rules' => 'trim|is_natural_no_zero',
			),
		);
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() === false) {

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formrunfalse'] = Events::trigger('formrunfalse', $eventname);

		} else {
			/**
			 * 유효성 검사를 통과한 경우입니다.
			 * 즉 데이터의 insert 나 update 의 process 처리가 필요한 상황입니다
			 */

			// 이벤트가 존재하면 실행합니다
			$view['view']['event']['formruntrue'] = Events::trigger('formruntrue', $eventname);

			$updatedata = $this->input->post();

			// $this->Company_model->update_exchange($updatedata);
			$view['view']['alert_message'] = '정상적으로 저장되었습니다';
		}

		$this->CIC_maincoin_coin_model->allow_order_field = array('comp_id');

		$where = array(
		);

		$result = $this->Company_model->get_one($comp_id);
		$view['view']['data'] = $result;



		$view['view']['primary_key'] = $this->Company_model->primary_key;

		$view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

		$layoutconfig = array('layout' => 'layout', 'skin' => 'company_write');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
	}

    public function update_news_enable_0()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_update_news_enable_0';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */

		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->News_model->update_news_enable_0($val);
				}
			}
		}

		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);

		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 비활성화 되었습니다.'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		redirect($redirecturl);
	}

	public function update_news_enable_1()
	{
		// 이벤트 라이브러리를 로딩합니다
		$eventname = 'event_admin_update_news_enable_1';
		$this->load->event($eventname);

		// 이벤트가 존재하면 실행합니다
		Events::trigger('before', $eventname);
		/**
		 * 체크한 게시물의 삭제를 실행합니다
		 */
		if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
			foreach ($this->input->post('chk') as $val) {
				if ($val) {
					$this->News_model->update_news_enable_1($val);
				}
			}
		}
		// 이벤트가 존재하면 실행합니다
		Events::trigger('after', $eventname);
		/**
		 * 삭제가 끝난 후 목록페이지로 이동합니다
		 */
		$this->session->set_flashdata(
			'message',
			'정상적으로 비활성화 되었습니다.'
		);
		$param =& $this->querystring;
		$redirecturl = admin_url($this->pagedir . '?' . $param->output());
		redirect($redirecturl);
	}

	public function update_news_show_0()
    {
        $eventname = 'event_admin_news_delete';
        $this->load->event($eventname);

        Events::trigger('before', $eventname);

        if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
            foreach ($this->input->post('chk') as $val) {
                if ($val) {
                    $this->News_model->update_news_show_0($val);
                }
            }
        }

        Events::trigger('after', $eventname);

        $this->session->set_flashdata(
            'message',
            '공개 설정으로 변경되었습니다.'
        );
        $param =& $this->querystring;
        $redirecturl = admin_url($this->pagedir . '?' . $param->output());
        redirect($redirecturl);
    }

	public function update_news_show_1()
    {
        $eventname = 'event_admin_news_delete';
        $this->load->event($eventname);

        Events::trigger('before', $eventname);

        if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
            foreach ($this->input->post('chk') as $val) {
                if ($val) {
                    $this->News_model->update_news_show_1($val);
                }
            }
        }

        Events::trigger('after', $eventname);

        $this->session->set_flashdata(
            'message',
            '공개 설정으로 변경되었습니다.'
        );
        $param =& $this->querystring;
        $redirecturl = admin_url($this->pagedir . '?' . $param->output());
        redirect($redirecturl);
    }

	public function update_news_important()
	{
		$eventname = 'event_admin_news_delete';
        $this->load->event($eventname);

        Events::trigger('before', $eventname);

        if ($this->input->post('chk') && is_array($this->input->post('chk'))) {
            foreach ($this->input->post('chk') as $val) {
                if ($val) {
                    $this->News_model->upadte_news_important($val);
                }
            }
        }

        Events::trigger('after', $eventname);

        $this->session->set_flashdata(
            'message',
            '주요 뉴스로 선정되었습니다.'
        );
        $param =& $this->querystring;
        $redirecturl = admin_url($this->pagedir . '?' . $param->output());
        redirect($redirecturl);
	}
}