<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Baisc helper
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

/**
 * 포럼 배너 가져오기
 */
if ( ! function_exists('forum_banner_image_url')) {
	function forum_banner_image_url($img = '', $width = '', $height = '')
	{
		if (empty($img)) {
			return false;
		}
		is_numeric($width) OR $width = '';
		is_numeric($height) OR $height = '';

		return thumb_url('forum_banner', $img, $width, $height);
	}
}