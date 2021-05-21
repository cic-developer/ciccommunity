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
}