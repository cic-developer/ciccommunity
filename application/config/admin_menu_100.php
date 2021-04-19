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


$config['admin_page_menu']['cicconfigs'] =
	array(
		'__config'					=> array('CIC 설정', 'fa-gears'), // 1차 메뉴, 순서대로 (메뉴명, 아이콘클래스(font-awesome))
		'menu'						=> array(
			'Point/VPconfig'		=> array('VP 설정', 'id="VPconfig"'), // 2차 메뉴, 순서대로 (메뉴명, a태그에 속성 부여)
			'Point/CPconfig'		=> array('CP 설정', 'id="CPconfig"'), // 2차 메뉴, 순서대로 (메뉴명, a태그에 속성 부여)
			'Point/config'			=> array('명예포인트 설정', 'id="POIconfig"'),
			'banner'				=> array('배너 설정', ''),
		),
	);
