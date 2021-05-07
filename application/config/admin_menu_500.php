<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *--------------------------------------------------------------------------
 *Admin Page 에 보일 메뉴를 정의합니다.
 *--------------------------------------------------------------------------
 *
 * Admin Page 에 새로운 메뉴 추가시 이곳에서 수정해주시면 됩니다.
 *
 */


$config['admin_page_menu']['service'] =
	array(
		'__config'					=> array('플러그인', 'fa-laptop'),
		'menu'						=> array(
			'attendancecfg'			=> array('출석체크', ''),
		),
	);