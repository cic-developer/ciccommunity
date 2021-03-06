<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CIC_Coin_list_model class
 *
 * Copyright (c) RsTeam <www.rs-team.com>
 *
 * @author RsTeam (developer@rs-team.com)
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

    function insertStockData($data)
    {
        if(isset($data) && !empty($data)){
            $result = $this->db->insert('cic_coin_list', $data);
            return $result;
        }
    } 
    
    function getstockData()
    {
        $result = $this->db->get('cic_coin_list');
        return $result->result_array(); 
    }

    function get_coin_list($limit ='', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {
        $search_where = array();
		$search_like = array();
		$search_or_like = array();
        $select = 'cic_coin_list.*';
        $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
        return $result;
    }

    function getonerow()
    {
        $this->db->where('clist_market', $id);
        $query = $this->db->get('cic_coin_list');
        return $query->row_array();
    }

    function get_apiList()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.upbit.com/v1/market/all",
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
        $array = json_decode($response, true);
        $refresh= $this -> input -> post('refresh');
        if($refresh){
            return $array;
        }
        else{
            return false;
        }
    }


    //GET DATA FOR CHART
    function get_histData($market)
    {
        
        //GET TIME STAMP 
        $hour = date('h:i');
        $today = strtotime("today $hour");
        $yesterday = strtotime("yesterday $hour");
        $curl = curl_init();
        if($market == "PER"){
            $url = "https://api.hotbit.co.kr/api/v2/market.kline?market=PER/KRW&start_time={$yesterday}&end_time={$today}&interval=3600";
        }else{
            $url = "https://api.upbit.com/v1/candles/minutes/60?market=KRW-{$market}&count=24";
        }    
            
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
            echo "cUrl Error :" . $err;
        }
        $array = json_decode($response, true);
        return $array;
    }
     //GET DATA FOR CHART
    function get_price($market)
    {
        $curl = curl_init();
        if($market === "PER"){
            $url = "https://api.hotbit.co.kr/api/v2/market.status_today?market=PER/KRW";
        }else{
            $url = "https://api.upbit.com/v1/ticker?markets=KRW-{$market}";
        }
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
            echo "cUrl Error :" . $err;
        }
        $array = json_decode($response, true);
        return $array;

    }
}
?>