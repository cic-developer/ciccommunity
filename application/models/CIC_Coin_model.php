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
class CIC_Coin_model extends CB_Model
{

    /**
	 * 테이블명
	 */
	public $_table = 'cic_coin_stock';
    public $primary_key = 'market';

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
        // $market = "KRW-BTC";
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.upbit.com/v1/ticker?markets=KRW-".$market,
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
        return $array[0];
	}
    
    function insertStockData($data){

        if(isset($data) && !empty($data)){
            $result = $this->db->insert('cic_coin_stock', $data);
            return $result;
        }
    } 


    function getstockData(){
        $result = $this->db->get('cic_coin_stock');
        return $result->result_array(); 
    }

    function get_coin_list($limit ='', $offset = '', $where = '', $like = '', $findex = '', $forder = '', $sfield = '', $skeyword = '', $sop = 'OR'){
        $search_where = array();
		$search_like = array();
		$search_or_like = array();
        $select = 'cic_coin_stock.*';
        $result = $this->_get_list_common($select, $join, $limit, $offset, $where, $like, $findex, $forder, $sfield, $skeyword, $sop);
        return $result;
    }

    function getonerow(){
        $this->db->where('market', $id);
        $query = $this->db->get('cic_coin_stock');
        return $query->row();
    }
    
    
    function insert_admin_list($data){

    $result = $this->db->insert('cic_coin_admins', $data);

    return $result;
        
    }


    function retrieve_api(){
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

        //convert json to php array or object
        $array = json_decode($response, true);
        return $array;
    
    }

}
?>