<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Maincoin helper
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/**
 * 코인 가격 가져오기
 */
if ( ! function_exists('get_coin_price')) {

	function get_coin_price($api, $coin_id, $exchange)
	{
        switch($api){
            case 'coingecko':{
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}&period=86400",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 90,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET"
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if($err){
                    return array();
                }
                //convert json to php array or object
                $array = json_decode($response, true);
                $result = $array['result'];
                if($result){
                    return array(
                        'price' => $result['last'],
                        'volume' => $result['deal'],
                        'change_rate' => $result['open'] ? (($result['open'] - $result['last']) / $result['open'] * 100) : 0,
                    );
                } else {
                    return array();
                }
            }
            break;

            case 'hotbit_korea': {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}&period=86400",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 90,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET"
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if($err){
                    return array();
                }
                //convert json to php array or object
                $array = json_decode($response, true);
                $result = $array['result'];
                if($result){
                    return array(
                        'price' => $result['last'],
                        'volume' => $result['deal'],
                        'change_rate' => $result['open'] ? (($result['open'] - $result['last']) / $result['open'] * 100) : 0,
                    );
                } else {
                    return array();
                }
            }
            break;

            default: {
                return array();
            }
        }
	}
}
