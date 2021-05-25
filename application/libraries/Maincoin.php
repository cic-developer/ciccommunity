<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Maincoin class
 *
 * Copyright (c) RSTEAM <www.rs-team.com>
 *
 * @author RSTEAM (developer@rs-team.com)
 */

/**
 * 거래소에서 API를 통해 데이터를 받아오는 라이브러리입니다.
 */

class Maincoin
{
    function __construct()
    {
    }

    private function get_hotbitkorea_data($coin_id, $market="KRW"){
        $url = "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}/{$market}&period=86400";
        $result = get_curl($url);
        if($result === FALSE) return array();
        if($result && is_array($result)){
            foreach($result as $val){
                if($val['target'] != $market) continue;
                return array(
                    'price' => $val['last'],
                    'volume' => $val['volume']*$val['last'],
                    'change_rate' => $val['market'] ? (($result['open'] - $result['last']) / $result['open'] * 100) : 0,
                );
            }
        }
        return array();
    }

    private function get_coingecko_data($coin_id, $market="KRW", $exchange_id=""){
        $url = "https://api.coingecko.com/api/v3/exchanges/{$exchange_id}/tickers?coin_ids={$coin_id}";
        $result = get_curl($url);
        if($result === FALSE) return array();
        if($result && is_array($result)){
            foreach($result as $val){
                if($val['target'] != $market) continue;
                return array(
                    'price' => $val['last'],
                    'volume' => $val['volume']*$val['last'],
                    'change_rate' => $val['market'] ? (($result['open'] - $result['last']) / $result['open'] * 100) : 0,
                );
            }
        }
        return array();
    }

    private function get_curl($url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
            return FALSE;
        }
        //convert json to php array or object
        $array = json_decode($response, true);
        return $array;
    }
}
?>