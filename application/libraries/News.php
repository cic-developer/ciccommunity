<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * News table 을 주로 관리하는 class 입니다.
 */

class News extends CI_Controller
{
    private $CI;
    private $news_id;
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

        // if($news_id){
        //     $this->CI->load->
        // }
    }
}