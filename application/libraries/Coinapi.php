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

class Coinapi extends CI_Controller
{
    private $CI;
    private $usd_price = 0;
    private $jpy_price = 0;
    private $jpyusd_price = 0;
    private $binance_data = array();
    private $upbit_data = array();
	function __construct()
	{
		$this->CI = & get_instance();
        $this->get_overseas_krw_price();
    }

    public function get_main_data(){
        $this->CI->load->model(
            array(
                'CIC_maincoin_exchange_model',
                'CIC_maincoin_coin_model',
                'Member_extra_vars_model'
            )
        );
        
		if ($this->CI->member->is_member() === false) {
            //기본값 리턴
            $exchange =  $this->CI->CIC_maincoin_exchange_model->get_default_list();
            $coin =  $this->CI->CIC_maincoin_coin_model->get_default_list();
		} else {
            $user_maincoin_data = $this->CI->Member_extra_vars_model->item($this->CI->member->is_member(), 'mem_maincoin');
            if(!$user_maincoin_data || !is_array(json_decode($user_maincoin_data, true))){
                //기본값 리턴
                $exchange = $this->CI->CIC_maincoin_exchange_model->get_default_list();
                $coin = $this->CI->CIC_maincoin_coin_model->get_default_list();
            } else {
                $decoded_data = json_decode($user_maincoin_data, true);
                $exchange = $this->CI->CIC_maincoin_exchange_model->get_user_list($decoded_data['exchange']);
                $coin = $this->CI->CIC_maincoin_coin_model->get_user_list($decoded_data['coin']);
            }
        }

        $first_block = array();
        foreach($exchange as $thisExchange){
            $thisCoinDetail = $coin[0]['coin_detail'][$thisExchange['cme_idx']];
            if($coin[0]['coin_detail'][$thisExchange['cme_idx']]){
                $coin_id = $coin[0]['coin_detail'][$thisExchange['cme_idx']]['cmcd_coin_id'];
                $market = $coin[0]['coin_detail'][$thisExchange['cme_idx']]['cmcd_coin_market'];
                $first_block[] = $this->get_coin_data($thisExchange['cme_id'], $coin_id, $market);
            } else {
                $first_block[] = array();
            }
        }


        $return_data = array(
            'exchange' => $exchange,
            'coin' => $coin,
            'money' => $decoded_data && isset($decoded_data['money']) ? $decoded_data['money'] : 'krw',
            'first_block' => $first_block,
        );
        return $return_data;
    }

    public function get_select_data($symbol){
        $this->CI->load->model(
            array(
                'CIC_maincoin_exchange_model',
                'CIC_maincoin_coin_model',
                'Member_extra_vars_model'
            )
        );
        $coin =  $this->CI->CIC_maincoin_coin_model->get_select($symbol);
        $return_data = array(
            'exchange' => array(),
            'data' => array(),
        );
        if(!$coin) return FALSE;
		if ($symbol == 'PER') {
            $coinDetail = $coin['coin_detail'];
            foreach($coinDetail as $thisDetail){
                $exchange = $thisDetail['cme_id'];
                $coin_id = $thisDetail['cmcd_coin_id'];
                $market = $thisDetail['cmcd_coin_market'];
                $return_data['exchange'][] = $thisDetail;
                $return_data['data'][] = $this->get_coin_data($exchange, $coin_id, $market);
            }
            return $return_data;
		}

        //개별 정보 세팅되있는지 확인
        if($this->CI->member->is_member()){
            $user_maincoin_data = $this->CI->Member_extra_vars_model->item($this->CI->member->is_member(), 'mem_maincoin');
            if($user_maincoin_data){
                $decoded_data = json_decode($user_maincoin_data, true);
            }
        }
        
        //거래소 목록 정리
        if(isset($decoded_data) && isset($decoded_data['exchange'])){
            $exchange = $this->CI->CIC_maincoin_exchange_model->get_user_list($decoded_data['exchange']);
        } else {
            $exchange = $this->CI->CIC_maincoin_exchange_model->get_default_list();
        }

        $return_data['exchange'] = $exchange;
        $return_data['money'] = $decoded_data && isset($decoded_data['money']) ? $decoded_data['money'] : 'krw';
        foreach($exchange as $thisExchange){
            $thisCoinDetail = $coin['coin_detail'][$thisExchange['cme_idx']];
            if($coin['coin_detail'][$thisExchange['cme_idx']]){
                $coin_id = $coin['coin_detail'][$thisExchange['cme_idx']]['cmcd_coin_id'];
                $market = $coin['coin_detail'][$thisExchange['cme_idx']]['cmcd_coin_market'];
                $return_data['data'][] = $this->get_coin_data($thisExchange['cme_id'], $coin_id, $market);
            } else {
                $return_data['data'][] = array();
            }
        }

        return $return_data;
    }
    
    public function get_coin_data($exchange="", $coin_id, $market="KRW"){
        switch($exchange){

            case 'bithumb':{
                return $this->get_bithumb_data($coin_id, $market);
            }
            break;

            case 'upbit':{
                return $this->get_upbit_data($coin_id, $market);
            }
            break;

            case 'hotbit_korea':{
                return $this->get_hotbitkorea_data($coin_id, $market);
            }
            break;

            case 'coinbit':{
                return $this->get_coinbit_data($coin_id, $market);
            }
            break;

            case 'coinone':{
                return $this->get_coinone_data($coin_id);
            }
            break;

            case 'korbit':{
                return $this->get_korbit_data($coin_id, $market);
            }
            break;

            case 'gdac':{
                return $this->get_gdac_data($coin_id, $market);
            }
            break;

            case 'bitflyer':{
                return $this->get_bitflyer_data($coin_id);
            }
            break;

            case 'binance':{
                return $this->get_binance_data($coin_id, $market);
            }
            break;

            case 'bitfinex':{
                return $this->get_bitfinex_data($coin_id);
            }
            break;

            case 'okex':{
                return $this->get_okex_data($coin_id, $market);
            }
            break;

            case 'huobi':{
                return $this->get_huobi_data($coin_id, $market);
            }
            break;

            case 'bittrex':{
                return $this->get_bittrex_data($coin_id, $market);
            }
            break;

            case 'poloniex':{
                return $this->get_poloniex_data($coin_id, $market);
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
        //허용된 market 인지 검증
        $allowed_market = array('KRW', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'KRW';
        //검증 끝

        $usd_price = $this->get_usd_price();
        $url = "https://api.bithumb.com/public/ticker/{$coin_id}_{$market}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $ticker_data = $result['data'];
        
        $url = "https://api.bithumb.com/public/transaction_history/{$coin_id}_{$market}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $price_data = $result['data'];

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }
        
        if($ticker_data && $price_data){
            return array(
                'price'         => $price_data[0]['price'],
                'price_usd'     => $price_data[0]['price']/$usd_price,
                'korea_premium' => $binance_price ? ($price_data[0]['price'] - $binance_price) / $binance_price * 100 : '',
                'volume'        => $ticker_data['acc_trade_value_24H'],
                'change_rate'   => $ticker_data['fluctate_rate_24H'],
            );
        } else {
            return array();
        }
    }

    /**
     * 업비트 에서 데이터 가져오는 함수
     */
    private function get_upbit_data($coin_id, $market="KRW"){
        //허용된 market 인지 검증
        $allowed_market = array('KRW', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'KRW';
        //검증 끝

        //기존 업비트에서 가져온 값이 있을경우 그대로 리턴
        if($coin_id=="BTC" && $market=="KRW" && isset($this->upbit_data[$coin_id])) return $this->upbit_data[$coin_id];
        $usd_price = $this->get_usd_price();
        $url = "https://api.upbit.com/v1/ticker?markets={$market}-{$coin_id}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $data = $result[0];

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }

        if($data){
            return array(
                'price'         => $data['trade_price'],
                'price_usd'     => $data['trade_price']/$usd_price,
                'korea_premium' => $binance_price ? ($data['trade_price'] - $binance_price) / $binance_price * 100 : '',
                'volume'        => $data['acc_trade_price_24h'],
                'change_rate'   => $data['signed_change_rate']*100,
            );
        } else {
            return array();
        }
    }

    /**
     * 핫빗코리아 에서 데이터 가져오는 함수
     */
    private function get_hotbitkorea_data($coin_id, $market="KRW"){
        //허용된 market 인지 검증
        $allowed_market = array('KRW', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'KRW';
        //검증 끝
        
        $usd_price = $this->get_usd_price();
        $url = "https://api.hotbit.co.kr/api/v2/market.status?market={$coin_id}/{$market}&period=86400";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $data = $result['result'];

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }

        if($data){
            return array(
                'price'         => $data['last'],
                'price_usd'     => $data['last']/$usd_price,
                'korea_premium' => $binance_price ? ($data['last'] - $binance_price) / $binance_price * 100 : '',
                'volume'        => $data['deal'],
                'change_rate'   => $data['open'] ? (($data['last'] - $data['open']) / $data['open'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 코인빗 에서 데이터 가져오는 함수
     */
    private function get_coinbit_data($coin_id, $market="KRW"){
        //허용된 market 인지 검증
        $allowed_market = array('KRW', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'KRW';
        //검증 끝
        
        $usd_price = $this->get_usd_price();
        $url = "https://production-api.coinbit.global/api/v1.0/trading_pairs/";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }

        if($result){
            foreach($result as $data){
                if($data['name'] == $coin_id.'-'.$market){
                    return array(
                        'price'         => $data['close_price'],
                        'price_usd'     => $data['close_price']/$usd_price,
                        'korea_premium' => $binance_price ? ($data['close_price'] - $binance_price) / $binance_price * 100 : '',
                        'volume'        => $data['acc_trade_value_24h'],
                        'change_rate'   => $data['signed_change_rate']*100,
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
        $usd_price = $this->get_usd_price();
        $url = "https://api.coinone.co.kr/ticker_utc?currency={$coin_id}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $data = $result;

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }

        if($data){
            return array(
                'price'         => $data['last'],
                'price_usd'     => $data['last']/$usd_price,
                'korea_premium' => $binance_price ? ($data['last'] - $binance_price) / $binance_price * 100 : '',
                'volume'        => $data['volume']*$data['last'],
                'change_rate'   => $data['yesterday_last'] ? (($data['last'] - $data['yesterday_last']) / $data['yesterday_last'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 코빗 에서 데이터 가져오는 함수
     */
    private function get_korbit_data($coin_id, $market="KRW"){
        //허용된 market 인지 검증
        $allowed_market = array('KRW');
        $market = in_array($market, $allowed_market) ? $market : 'KRW';
        //검증 끝
        
        $usd_price = $this->get_usd_price();
        $url = "https://api.korbit.co.kr/v1/ticker/detailed?currency_pair=".strtolower($coin_id)."_".strtolower($market);
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $data = $result;

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }

        if($data){
            return array(
                'price'         => $data['last'],
                'price_usd'     => $data['last']/$usd_price,
                'korea_premium' => $binance_price ? ($data['last'] - $binance_price) / $binance_price * 100 : '',
                'volume'        => $data['volume'] * $data['last'],
                'change_rate'   => $data['changePercent'],
            );
        } else {
            return array();
        }
    }

    /**
     * 지닥 에서 데이터 가져오는 함수
     */
    private function get_gdac_data($coin_id, $market="KRW"){
        //허용된 market 인지 검증
        $allowed_market = array('KRW', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'KRW';
        //검증 끝
        
        $usd_price = $this->get_usd_price();
        $url = "https://partner.gdac.com/v0.4/public/tickers/{$coin_id}%2F{$market}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        $data = $result;

        $binance_data = $this->get_binance_data($coin_id, "USDT");
        if(count($binance_data) == 0){
            $binance_price = 0;
        } else {
            $binance_price = $binance_data['price'];
        }

        if($data){
            return array(
                'price'         => $data['last'],
                'price_usd'     => $data['last']/$usd_price,
                'korea_premium' => $binance_price ? ($data['last'] - $binance_price) / $binance_price * 100 : '',
                'volume'        => $data['volume'] * $data['last'],
                'change_rate'   => $data['open'] ? (($data['last'] - $data['open']) / $data['open'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 비트플라이어 에서 데이터 가져오는 함수
     * 변화율을 구할 수 없음
     */
    private function get_bitflyer_data($coin_id){
        $jpy_price = $this->get_jpy_price();
        $jpyusd_price = $this->get_jpyusd_price();

        //거래소정보
        $url = "https://api.bitflyer.com/v1/getticker?product_code={$coin_id}_JPY";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price'         => $data['ltp'] * $jpy_price,
                'price_usd'     => $data['ltp']/$jpyusd_price,
                'volume'        => $data['volume'] * $data['ltp'] * $jpy_price,
                'change_rate'   => 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 바이낸스 에서 데이터 가져오는 함수
     */
    private function get_binance_data($coin_id, $market="USDT"){
        //허용된 market 인지 검증
        $allowed_market = array('USDT', 'BUSD', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'USDT';
        //검증 끝
        
        //기존 바이낸스에서 가져온 값이 있을경우 그대로 리턴
        if($market=="USDT" && isset($this->binance_data[$coin_id])) return $this->binance_data[$coin_id];
        $usd_price = $this->get_usd_price();

        $url = "https://api.binance.com/api/v3/ticker/24hr?symbol={$coin_id}{$market}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            $return_data = array(
                'price'         => $data['lastPrice'] * $usd_price,
                'price_usd'     => $data['lastPrice'],
                'volume'        => $data['quoteVolume'] * $usd_price,
                'change_rate'   => $data['priceChangePercent'],
            );
            //한국 프리미엄 계산을 위해 메모리에 저장
            if($market=="USDT") $this->binance_data[$coin_id] = $return_data;
            return $return_data;
        } else {
            if($market=="USDT") $this->binance_data[$coin_id] = array();
            return array();
        }
    }

    /**
     * 비트파이넥스 에서 데이터 가져오는 함수
     */
    private function get_bitfinex_data($coin_id){
        $usd_price = $this->get_usd_price();

        $url = "https://api-pub.bitfinex.com/v2/ticker/t{$coin_id}USD";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result;
        if($data){
            return array(
                'price'         => $data[6] * $usd_price,
                'price_usd'     => $data[6],
                'volume'        => $data[7] * $data[6] * $usd_price,
                'change_rate'   => $data[5] * 100,
            );
        } else {
            return array();
        }
    }

    /**
     * 오케이엑스 에서 데이터 가져오는 함수
     */
    private function get_okex_data($coin_id, $market="USDT"){
        //허용된 market 인지 검증
        $allowed_market = array('USDT', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'USDT';
        //검증 끝
        
        $usd_price = $this->get_usd_price();

        $url = "https://www.okex.com/api/v5/market/ticker?instId={$coin_id}-{$market}-SWAP";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result['data'];
        if($data){
            return array(
                'price'         => $data[0]['last'] * $usd_price,
                'price_usd'     => $data[0]['last'],
                'volume'        => $data[0]['vol24h'] * $usd_price,
                'change_rate'   => $data[0]['sodUtc0'] ? (($data[0]['last'] - $data[0]['sodUtc0']) / $data[0]['sodUtc0'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 후오비 에서 데이터 가져오는 함수
     */
    private function get_huobi_data($coin_id, $market="USDT"){
        //허용된 market 인지 검증
        $allowed_market = array('USDT', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'USDT';
        //검증 끝
        
        $usd_price = $this->get_usd_price();

        $url = "https://api.huobi.pro/market/detail?symbol=".strtolower($coin_id).strtolower($market);
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result['tick'];
        if($data){
            return array(
                'price'         => $data['close'] * $usd_price,
                'price_usd'     => $data['close'],
                'volume'        => $data['amount'] * $data['close'] * $usd_price,
                'change_rate'   => $data['open'] ? (($data['close'] - $data['open']) / $data['open'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 비트렉스 에서 데이터 가져오는 함수
     */
    private function get_bittrex_data($coin_id, $market="USD"){
        //허용된 market 인지 검증
        $allowed_market = array('USD', 'USDT', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'USD';
        //검증 끝
        
        $usd_price = $this->get_usd_price();

        $url = "https://api.bittrex.com/api/v1.1/public/getmarketsummary?market={$market}-{$coin_id}";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();
        
        $data = $result['result'];
        if($data){
            return array(
                'price'         => $data[0]['Last'] * $usd_price,
                'price_usd'     => $data[0]['Last'],
                'volume'        => $data[0]['BaseVolume'] * $usd_price,
                'change_rate'   => $data[0]['PrevDay'] ? (($data[0]['Last'] - $data[0]['PrevDay']) / $data[0]['PrevDay'] * 100) : 0,
            );
        } else {
            return array();
        }
    }

    /**
     * 폴로닉스 에서 데이터 가져오는 함수
     */
    private function get_poloniex_data($coin_id, $market="USDT"){
        //허용된 market 인지 검증
        $allowed_market = array('USDT', 'BTC');
        $market = in_array($market, $allowed_market) ? $market : 'USDT';
        //검증 끝
        
        $usd_price = $this->get_usd_price();

        $url = "https://poloniex.com/public?command=returnTicker";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 빈 배열 리턴
        if($result === FALSE) return array();

        $data = $result[$market.'_'.$coin_id];
        if($data){
            return array(
                'price'         => $data['last'] * $usd_price,
                'price_usd'     => $data['last'],
                'volume'        => $data['baseVolume'] * $usd_price,
                'change_rate'   => $data['percentChange'] * 100,
            );
        } else {
            return array();
        }
    }

    private function get_overseas_krw_price(){
        if($this->usd_price) return $this->usd_price;
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD,FRX.KRWJPY,FRX.JPYUSD";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 0 리턴
        if($result === FALSE) return 0;
        $this->usd_price = $result[0]['basePrice'];
        $this->jpy_price = $result[1]['basePrice']/100;
        $this->jpyusd_price = $result[2]['basePrice'];
    }

    private function get_usd_price(){
        if($this->usd_price) return $this->usd_price;
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 0 리턴
        if($result === FALSE) return 0;
        $this->usd_price = $result[0]['basePrice'];
        return $this->usd_price;
    }

    private function get_jpy_price(){
        if($this->jpy_price) return $this->jpy_price;
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWJPY";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 0 리턴
        if($result === FALSE) return 0;
        $this->jpy_price = $result[0]['basePrice']/100; //100엔당 가격이라 나누기100
        return $this->jpy_price;
    }

    private function get_jpyusd_price(){
        if($this->jpyusd_price) return $this->jpyusd_price;
        //환율정보
        $url = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.JPYUSD";
        $result = $this->get_curl($url);
        //curl 중 오류발생할 경우 0 리턴
        if($result === FALSE) return 0;
        $this->jpyusd_price = $result[0]['basePrice'];
        return $this->jpyusd_price;
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