<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class News extends CB_Controller
{
    public $pagedir = 'cicconfigs/news';

    protected $models = array('News');

    protected $modelname = 'News_model';

    protected $helpers = array('form', 'array', 'dhtml_editor');

    function __construct()
    {
        parent::__construct();

        $this->load->library(array('paginagion', 'querystring', 'form_validation','session'));
        $this->load->model(array('News_model'));
    }

    public function index()
    {
        $eventname = 'event_news_index';
        $this->load->event($eventname);

        $view = array();
        $view['view'] = array();

        $view['view']['event']['before'] = Events::trigger('before', $eventname);

        $param =& $this->querystring;
		$page = (((int) $this->input->get('page')) > 0) ? ((int) $this->input->get('page')) : 1;
		$findex = $this->input->get('findex') ? $this->input->get('findex') : $this->{$this->modelname}->primary_key;
		$forder = $this->input->get('forder', null, 'desc');
		$sfield = $this->input->get('sfield', null, '');
		$skeyword = $this->input->get('skeyword', null, '');

        $per_page = admin_listnum();
        $offset = ($page - 1) * $per_page;

        $this->{$this->modelname}->allow_search_field = array('news_id', 'news_title', 'news_content', 'comp_id');
        $this->{$this->modelname}->search_field_equal = array();
        $this->{$this->modelname}->allow_order_field = array();
    }
}