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
                return get_coinbit_data($coin_id, $market);
            }
            break;

            case 'coinone':{
                return get_coinone_data($coin_id, $market);
            }
            break;

            case 'korbit':{
                return get_korbit_data($coin_id, $market);
            }
            break;

            case 'bitflyer':{
                return get_bitflyer_data($coin_id, $market);
            }
            break;

            case 'binance':{
                return get_binance_data($coin_id, $market);
            }
            break;

            case 'bitfinex':{
                return get_bitfinex_data($coin_id, $market);
            }
            break;

            case 'okex':{
                return get_okex_data($coin_id, $market);
            }
            break;

            case 'huobi':{
                return get_huobi_data($coin_id, $market);
            }
            break;

            case 'bittrex':{
                return get_bittrex_data($coin_id, $market);
            }
            break;

            case 'poloniex':{
                return get_poloniex_data($coin_id, $market);
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
        $url = "https://api.bithumb.com/public/ticker/{$market}_{$coin_id}";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $ticker_data = $result['data'];

        $url = "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}/{$market}&period=86400";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $price_data = $result['data'];

        if($ticker_data && $price_data){
            return array(
                'price' => $price_data[0]['price'],
                'volume' => $ticker_data['acc_trade_value_24H'],
                'change_rate' => $ticker_data['fluctate_rate_24H']*100,
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
                'change_rate' => $data['signed_change_rate']*100,
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

    /**
     * 코인빗 에서 데이터 가져오는 함수
     */
    private function get_coinbit_data($coin_id, $market="KRW"){
        $url = "https://production-api.coinbit.global/api/v1.0/trading_pairs/";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        if($result){
            foreach($result as $data){
                if($data['name'] == $coin_id.'-'.$market){
                    return array(
                        'price' => $data['close_price'],
                        'volume' => $data['acc_trade_volume_24h'],
                        'change_rate' => $data['signed_change_rate']*100,
                    );
                }
            }
        }

        return array();
    }

    /**
     * 코인원 에서 데이터 가져오는 함수
     */
    private function get_coinone_data($coin_id){
        $url = "https://api.coinone.co.kr/ticker?currency={$coin_id}";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price' => $data['last'],
                'volume' => $data['volume']*$data['last'],
                'change_rate' => $data['first'] ? (($data['first'] - $data['last']) / $data['first'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 코빗 에서 데이터 가져오는 함수
     */
    private function get_korbit_data($coin_id, $market="krw"){
        $url = "https://api.korbit.co.kr/v1/ticker/detailed?currency_pair=".strtolower($coin_id)."_".strtolower($market);
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price' => $data['last'],
                'volume' => $data['volume'] * $data['last'],
                'change_rate' => $data['changePercent'],
            );
        } else {
            return array();
        }
    }

    /**
     * 비트플라이어 에서 데이터 가져오는 함수
     */
    private function get_bitflyer_data($coin_id){
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWJPY";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $jpy_price = $result[0]['basePrice']/100; //100엔당 가격이라 나누기100

        //거래소정보
        $url = "https://api.bitflyer.com/v1/getticker?product_code={$coin_id}_JPY";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price' => $data['ltp'] * $jpy_price,
                'volume' => $data['volume'] * $data['ltp'] * $jpy_price,
                'change_rate' => 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 바이낸스 에서 데이터 가져오는 함수
     */
    private function get_binance_data($coin_id, $market="USDT"){
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $usd_price = $result[0]['basePrice'];

        $url = "https://api.binance.com/api/v3/ticker/24hr?symbol={$coin_id}{$market}";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price' => $data['lastPrice'] * $usd_price,
                'volume' => $data['quoteVolume'] * $usd_price,
                'change_rate' => $data['priceChangePercent'],
            );
        } else {
            return array();
        }
    }

    /**
     * 비트파이넥스 에서 데이터 가져오는 함수
     */
    private function get_bitfinex_data($coin_id){
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $usd_price = $result[0]['basePrice'];

        $url = "https://api-pub.bitfinex.com/v2/ticker/t{$coin_id}USD";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price' => $data[6] * $usd_price,
                'volume' => $data[7] * $data[6] * $usd_price,
                'change_rate' => $data[5] * 100,
            );
        } else {
            return array();
        }
    }

    /**
     * 오케이엑스 에서 데이터 가져오는 함수
     */
    private function get_okex_data($coin_id, $market="USD"){
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $usd_price = $result[0]['basePrice'];

        $url = "https://www.okex.com/api/v5/market/ticker?instId={$coin_id}-{$market}-SWAP";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result['data'];
        if($data){
            return array(
                'price' => $data[0]['last'] * $usd_price,
                'volume' => $data[0]['vol24h'] * $usd_price,
                'change_rate' => $data[0]['sodUtc0'] ? (($data[0]['sodUtc0'] - $data[0]['last']) / $data[0]['sodUtc0'] * 100) * $usd_price : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 후오비 에서 데이터 가져오는 함수
     */
    private function get_huobi_data($coin_id, $market="usdt"){
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD";
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $usd_price = $result[0]['basePrice'];

        $url = "https://api.huobi.pro/market/detail?symbol=".strtolower($coin_id).strtolower($market);
        $result = get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result['tick'];
        if($data){
            return array(
                'price' => $data['close'] * $usd_price,
                'volume' => $data['amount'] * $data['close'] * $usd_price,
                'change_rate' => $data['open'] ? (($data['open'] - $data['last']) / $data['open'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 비트렉스 에서 데이터 가져오는 함수
     */
    private function get_bittrex_data($coin_id, $market="KRW"){
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
     * 폴로닉스 에서 데이터 가져오는 함수
     */
    private function get_poloniex_data($coin_id, $market="KRW"){
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