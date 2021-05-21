<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class News extends CI_Controller
{
    private $CI;
	private $admin;
	private $call_admin;
    
    function __construct()
	{
		$this->CI = & get_instance();
	}

    public function get_news($news_id = 0)
    {
        if(empty($news_id)){
            return false;
        }

        if($news_id){
            $this->CI->load->model('News_model');
            $news = $this->CI->News_model->get_one('', '', $where);
        } else {
            return false;
        }

        if(element('news_id', $news)){
            $this->
        }
    }
}