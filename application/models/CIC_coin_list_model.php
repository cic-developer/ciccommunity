<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Coin class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
 */

/**
 * 권한이 있는지 없는지 판단하는 class 입니다.
 */
class CIC_Coin_list_model extends CB_Model
{

    /**
	 * 테이블명
	 */
	public $_table = 'cic_coin_list';
    public $primary_key = 'clist_market';

    function __construct()
    {
        parent::__construct();

        check_cache_dir('coin');
    }
	/**
	 * Get RealTime Coin Price
	 */

	function get_price($market)
	{
        $curl = curl_init();
        // $clist_market = "KRW-BTC";
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.bithumb.com/public/ticker/{$market}_KRW",
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
            echo "cUrl Error :" . $err;
        }
     
        //convert json to php array or object
        $array = json_decode($response, true);
        // print_r($array);
        return $array;
	}


    function act_price($clist_market)
	{
        $curl = curl_init();
        // $clist_market = "KRW-BTC";
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.bithumb.com/public/transaction_history/" .$clist_market. "_KRW",
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
            echo "cUrl Error :" . $err;
        }
        //convert json to php array or object
        $array = json_decode($response, true);
       // print_r($array);
        return $array;
	}
    
    function insertStockData($data){
        if(isset($data) && !empty($data)){
            $result = $this->db->insert('cic_coin_list', $data);
            return $result;
        }
    } 


    function getstockData(){
        $result = $this->db->get('cic_coin_list');
        return $result->result_array(); 
    }
   
    function get_coin_list($limit ='', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR'){
        $search_where = array();
		$search_like = array();
		$search_or_like = array();
        $select = 'cic_coin_list.*';
        $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
        return $result;
    }

    function getonerow(){
        $this->db->where('clist_market', $id);
        $query = $this->db->get('cic_coin_list');
        return $query->row_array();
    }

    function retrieve_api(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            // CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/list?markets?vs_currency=KRW",
            CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=KRW&order=market_cap_desc&per_page=300&page=1&sparkline=false",
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
            echo "cUrl Error :" . $err;
        }
        $refresh = $this -> input -> post('refresh');
        // convert json to php array or object
        $arr = json_decode($response, true);
        // print_r($arr['id']);
        if(is_array($arr) || is_object($arr)){
            while($arr = $value){
                print_r($value['id']);
                $curl_ = curl_init();
                curl_setopt_array($curl_, array(
                    CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/" .$value['id']. "?tickers=false&market_data=false&community_data=false&developer_data=false&sparkline=false",
                    // CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/bitcoin?tickers=false&market_data=false&community_data=false&developer_data=false&sparkline=false",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 90,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET"   
                    
                ));
                $response = curl_exec($curl_);
                $err = curl_error($curl_);

                curl_close($curl_);

                if($err){
                    echo "cUrl Error :" . $err;
                }
                $array = json_decode($response, true);
                $refresh = $this -> input -> post('refresh');
                // print_r($data);
                if(is_array($array) || is_object($array) ){
                    // convert json to php array or object
                    return $array;
                }
            }   
        }     
    // function get_apiList(){
 }   //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         // CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/list?markets?vs_currency=KRW",
    //         CURLOPT_URL => "https://api.coingecko.com/api/v3/coins/markets?vs_currency=KRW&order=market_cap_desc&per_page=300&page=1&sparkline=false",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 90,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "GET"   
            
    //     ));

    //     $response = curl_exec($curl);
    //     $err = curl_error($curl);

    //     curl_close($curl);

    //     if($err){
    //         echo "cUrl Error :" . $err;
    //     }
    //     $refresh = $this -> input -> post('refresh');
    //     // convert json to php array or object
    //     $array = json_decode($response, true);
    //     if(is_array($array)){
    //         // print_r($array);
    //         return $array;
    //     }
        
    // }

}
?>