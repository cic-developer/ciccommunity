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
    public function get_data($exchange="", $coin_id, $market="KRW"){
        switch($exchange){

            case 'bithumb':{

            }
            break;

            case 'upbit':{

            }
            break;

            case 'hotbit_korea':{
                return get_hotbitkorea_data($coin_id, $market);
            }
            break;

            case 'coinbit':{

            }
            break;

            case 'coinone':{

            }
            break;

            case 'korbit':{

            }
            break;

            case 'bitflyer':{

            }
            break;

            case 'binance':{

            }
            break;

            case 'bitfinex':{

            }
            break;

            case 'okex':{

            }
            break;

            case 'huobi':{

            }
            break;

            case 'bittrex':{

            }
            break;

            case 'poloniex':{

            }
            break;

            default:{
                return array();
            }
        }
    }

    /**
     * 빗썸 에서 데이터 가져오는 함수
     */
    private function get_bithumb_data($coin_id, $market="KRW"){
        $url = "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}/{$market}&period=86400";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result['result'];
        if($data){
            return array(
                'price' => $data['last'],
                'volume' => $data['deal'],
                'change_rate' => $data['open'] ? (($data['open'] - $data['last']) / $data['open'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 업비트 에서 데이터 가져오는 함수
     */
    private function get_upbit_data($coin_id, $market="KRW"){
        $url = "https://api.upbit.com/v1/ticker?markets={$market}-{$coin_id}";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result[0];
        if($data){
            return array(
                'price' => $data['trade_price'],
                'volume' => $data['acc_trade_price_24h'],
                'change_rate' => $data['signed_change_rate'],
            );
        } else {
            return array();
        }
    }

    /**
     * 핫빗코리아 에서 데이터 가져오는 함수
     */
    private function get_hotbitkorea_data($coin_id, $market="KRW"){
        $url = "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}/{$market}&period=86400";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result['result'];
        if($data){
            return array(
                'price' => $data['last'],
                'volume' => $data['deal'],
                'change_rate' => $data['open'] ? (($data['open'] - $data['last']) / $data['open'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    // /**
    //  * Coingecko 에서 데이터 가져오는 함수
    //  */
    // private function get_coingecko_data($coin_id, $market="KRW", $exchange_id=""){
    //     $url = "https://api.coingecko.com/api/v3/exchanges/{$exchange_id}/tickers?coin_ids={$coin_id}";
    //     $result = get_curl($url);
    //     //curl 중 오류발생할 경우 빈 배열 리턴
    //     if($result === FALSE) return array();

    //     $data = $result['tickers'];
    //     if($data && is_array($data)){
    //         foreach($data as $val){
    //             if($val['target'] != $market) continue;
    //             return array(
    //                 'price' => $val['last'],
    //                 'volume' => $val['volume']*$val['last'],
    //                 'change_rate' => 0,
    //             );
    //         }
    //     }
    //     return array();
    // }

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