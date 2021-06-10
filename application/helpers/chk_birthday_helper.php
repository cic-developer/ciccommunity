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
 * 만 나이를 계산
 */

if(! function_exists('international_age')){
    function international_age($year, $mon, $day){
        $now_y = date('Y');
		$now_m = date('m');
		$now_d = date('d');


        if($mon < $now_m){
            $age = $now_y - $year;
        }else if($mon === $now_m){
            if($day <= $now_d)
            $age = $now_y - $year;
            else
            $age = $now_y - $year-1;
        }else{
            $age = $now_y - $year-1;
        }
        return $age;
    }
}