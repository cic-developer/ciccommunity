<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * RS Baisc helper
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */


/**
 * ALERT MESSAGE 가 있을 경우 html 으로 감싸서 보여주기
 */
if ( ! function_exists('rs_show_alert_message')) {
	function rs_show_alert_message($message = '', $html1 = '', $html2 = '')
	{
		if (empty($message)) {
			return false;
		}

		$result = $html1 . $message . $html2;
		return $result;
	}
}


