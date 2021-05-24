<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class News extends CB_Controller
{
    public $pagedir = 'cicconfigs/news';

    protected $models = array('News');


    protected $modelname = 'News_model';


    protected $helpers = array('form', 'array',);


    function __construct()
    {
        parent::__construct();

        $this->load->library(array('pagination', 'querystring')); 
    }

    public function index()
    {
        $eventname = 'event_admin_news_index';
        $this->load->event($eventname);
        $view = array();
        $view['view'] = array();
        
        $view['view']['event']['before'] = Events::trigger('before', $eventname);

		$param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = 'post_id';
		$forder = 'desc';
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');
        
        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;
        
        $this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id');
        $this->{$this->modelname}->search_field_equal = array('news_id', 'comp_id');
        $this->{$this->modelname}->allow_order_field = array('news_id');
        
        $where = array();
        $result = $this->{$this->modelname}
        ->get_news_list($per_page, $offset, $where, '', $findex, $forder, $sfield, $skeyword);
        $list_num = $result['total_rows'] = ($page - 1) * $per_page;
		if (element('list', $result)) {
			foreach (element('list', $result) as $key => $val) {
				$result['list'][$key]['post_display_name'] = display_username(
					element('post_userid', $val),
					element('post_nickname', $val)
				);
				$result['list'][$key]['board'] = $board = $this->board->item_all(element('brd_id', $val));
				$result['list'][$key]['num'] = $list_num--;
				if ($board) {
					$result['list'][$key]['boardurl'] = board_url(element('brd_key', $board));
					$result['list'][$key]['posturl'] = post_url(element('brd_key', $board), element('post_id', $val));
				}
				$result['list'][$key]['category'] = '';
				if (element('post_category', $val)) {
					$result['list'][$key]['category'] = $this->Board_category_model->get_category_info(element('brd_id', $val), element('post_category', $val));
				}
				if (element('post_image', $val)) {
					$imagewhere = array(
						'post_id' => element('post_id', $val),
						'pfi_is_image' => 1,
					);
					$file = $this->Post_file_model->get_one('', '', $imagewhere, '', '', 'pfi_id', 'ASC');
					$result['list'][$key]['thumb_url'] = thumb_url('post', element('pfi_filename', $file), 80);
				} else {
					$result['list'][$key]['thumb_url'] = get_post_image_url(element('post_content', $val), 80);
				}
			}
		}

        $view['view']['data'] = $result;

        $view['view']['primary_key'] = $this->{$this->modelname}->primary_key;

        $config['base_url'] = admin_url($this->pagedir) . '/' . '?' . $param->replace('page');
		$config['total_rows'] = $result['total_rows'];
		$config['per_page'] = $per_page;
		$this->pagination->initialize($config);
		$view['view']['paging'] = $this->pagination->create_links();
		$view['view']['page'] = $page;


        $search_option = array('news_title' => '제목', 'news_content' => '본문', 'comp_id' => '신문사');
		$view['view']['skeyword'] = ($sfield && array_key_exists($sfield, $search_option)) ? $skeyword : '';
		$view['view']['search_option'] = search_option($search_option, $sfield);
		$view['view']['listall_url'] = admin_url($this->pagedir);
		$view['view']['list_delete_url'] = admin_url($this->pagedir . '/listdelete/?' . $param->output());
		$view['view']['list_trash_url'] = admin_url($this->pagedir . '/listtrash/?' . $param->output());
        
        $view['view']['event']['before_layout'] = Events::trigger('before_layout', $eventname);

        $layoutconfig = array('layout' => 'layout', 'skin' => 'Searchcoin');
		$view['layout'] = $this->managelayout->admin($layoutconfig, $this->cbconfig->get_device_view_type());
		$this->data = $view;
		$this->layout = element('layout_skin_file', element('layout', $view));
		$this->view = element('view_skin_file', element('layout', $view));
    }

    public function delete_news(){
        $eventname = 'event_admin_news_delete';
        $this->load->event($eventname);

        Events::trigger('before', $eventname);

        if ($this->input->news('chk') && is_array($this->input->news('chk'))) {
            foreach ($this->input->news('chk') as $val) {
                if ($val) {
                    $this->news->delete_news($val);
                }
            }
        }
        Events::trigger('after', $eventname);

        $this->session->set_flashdata(
            'message',
            '정상적으로 삭제되었습니다.'
        );
        $param =& $this->querystring;
        $redirecturl = admin_url($this->pagedir . '?' . $param->output());
        redirect($redirecturl);
    }

    public function update_news_enable_0()
    {
        $where = array(
            'news_id' => $news_id,
        );
        $updatedata = array(
            'news_enable' => 0,
        );
        $this->db->where($where);
        $this->db->set($updatedata);

        return $this->db->update($this->_table);
    }

    public function update_news_enable_1()
    {
        $where = array(
            'news_id' => $news_id,
        );
        $updatedata = array(
            'news_enable' => 1,
        );
        $this->db->where($where);
        $this->db->set($updatedata);

        return $this->db->update($this->_table);
    }

    public function update_news_show_0()
    {
        $where = array(
            'news_id' => $news_id,
        );
        $updatedata = array(
            'news_show' => 0,
        );
        $this->db->where($where);
        $this->db->set($updatedata);

        return $this->db->update($this->_table);
    }

    public function update_news_show_1()
    {
        $where = array(
            'news_id' => $news_id,
        );
        $updatedata = array(
            'news_show' => 1,
        );
        $this->db->where($where);
        $this->db->set($updatedata);

        return $this->db->update($this->_table);
    }

}