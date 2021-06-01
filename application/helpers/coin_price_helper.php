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
        if(!$number) return '';
        $BIG_ORDER = ["", "만", "억", "조"];
        $str = "";
        for($i = count($BIG_ORDER) - 1; $i >= 0; --$i){
            $unit = pow(10000, $i);
            $part = floor($number / $unit);
            if($part > 0){
                $str .= $part . $BIG_ORDER[$i];
                if($i == 2) break; // *조 **억 또는 *억
                if($i == 1) break; // **만
            }
            $number %= $unit;	
        }
        return $str;
	}
}

/**
 * 최대소숫점 지정 가능
 */
if ( ! function_exists('rs_number_format')) {
	function rs_number_format($number, $demicals = 0, $default = '')
	{
        if(!$number) return $default;
        $value = number_format($number, $demicals);
        if($value && $demicals > 0 && strpos($value, '.') !== FALSE){
            $check = TRUE;
            while($check){
                //문제없으면 반복종료
                $check = FALSE;

                $last_value = substr($value, -1);
                //마지막 문자가 0이나 . 일경우 삭제
                if($last_value === '0' || $last_value == '.'){
                    if($last_value === '0'){
                        $check = TRUE;
                    }
                    $value = substr($value, 0, -1);
                }
            }
        }
        return $value;
	}
}

/**
 * 가격 가져올때 demical 설정
 */
if ( ! function_exists('rs_get_price')) {
	function rs_get_price($number, $money='krw', $default='')
	{
        if(!$number) return $default;
        switch($money){
            case 'usd':{
                if($number >= 100){
                    $value = rs_number_format($number, 2);
                } else if($number >= 1){
                    $value = rs_number_format($number, 4);
                } else {
                    $value = rs_number_format($number, 6);
                }
            } 
            break;

            case 'krw':
            default :{
                if($number >= 100){
                    $value = rs_number_format($number);
                } else if($number >= 10){
                    $value = rs_number_format($number, 1);
                } else if($number >= 1){
                    $value = rs_number_format($number, 2);
                } else {
                    $value = rs_number_format($number, 3);
                }
            }
        }
        return $value;
	}
}


?>