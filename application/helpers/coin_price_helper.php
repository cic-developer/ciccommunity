<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coin Price helper
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/**
 * 단위를 한글로 변환(만, 억, 조)
 */
if ( ! function_exists('number_unit_to_korean')) {
	function number_unit_to_korean($number)
	{
	}
}

/**
 * 금액별 소숫점 제한 설정
 */
if ( ! function_exists('number_unit_to_korean')) {
	function number_unit_to_korean($number)
	{
	}
}

/**
 * 소숫점인데 .00 과 같이 0일경우 삭제
 */
if ( ! function_exists('claen_dot_number')) {
	function claen_dot_number($number)
	{
        return (int)$number;
	}
}

?>