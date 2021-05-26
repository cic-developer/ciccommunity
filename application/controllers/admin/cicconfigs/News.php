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

		);

		if($compid = (int) $this->input->get('comp_id')){
			$where['comp_id'] = $compid;
		}

		$result = $this->{$this->modelname}
			->get_news_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);

		$list_num = $result['total_rows'] - ($page - 1) * $per_page;

		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				// $result['list'][$key]['company'] = $company = $this->cic_company->item_all(element('comp_id', $val));
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
}