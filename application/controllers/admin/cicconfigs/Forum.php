<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forum class
 */

/**
 * 관리자>CIC 설정>포럼관리 controller 입니다.
 */
class Forum extends CB_Controller
{
    /**
	 * 관리자 페이지 상의 현재 디렉토리입니다
	 * 페이지 이동시 필요한 정보입니다
	 */
    public $pagedir = 'cicconfigs/forum';

    /**
	 * 모델을 로딩합니다
	 */
    protected $models = array('Forum_model');

    /**
	 * 이 컨트롤러의 메인 모델 이름입니다
	 */
    protected $modelname = 'Forum_model_model';

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
     * 
     */
    public function index()
    {
        print_r("hi");
        exit;
    }
}