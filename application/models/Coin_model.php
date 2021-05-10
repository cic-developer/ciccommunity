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
class Coin_model extends CB_Model
{

    /**
	 * 테이블명
	 */
	public $_table = 'cic_coin_stock';
    public $primary_key = 'coin_idx';

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

        
        $query = $this->db->get('cic_coin_stock');
        // $query = $this->db->get('cic_stocks');
        $market_ = $query->result();
        

        $curl = curl_init();
        // $market = "KRW-BTC";
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.upbit.com/v1/ticker?market=KRW-".$market,
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
        $query = $this->db->get('cic_coin_stock');
        return $query->result(); 
    }

    function getonerow(){
        $this->db->where('stk_id', $id);
        $query = $this->db->get('cic_coin_stock');
        return $query->row();
    }


    function search_coin($search){
    //     if(!empty($key)) {
    //         $this->db->where($_table, $key);
    //     }
    //     $search_ = "";
    //     if(preg_match('/\s/', $search_) > 0){
    //         $search_ = array_map('trim',array_filter(explode('', $search_)));
    //         foreach ($search_ as $key_=> $value){
    //             $this->db->or_like('foo_column', $value);
    //         }
    //     }else if($search_ !=''){
    //         $this->db->like('foo_column', $search_);
    //     }
    //     $query = $this->db->get('name_en');
    //     return $query->result();

        // $this->db->or_like('market', $search);
        // $this->db->or_like('name_en', $search);
        // $this->db->or_like('name_ko', $search);
        // $this->db->get('products');

        
    
    }

    function get_coinlist(){
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

    function dropdown_list($data){
        $this->db->where('market',$data);
        $query = $this->db->get('cic_coin_admin')->row_array();

        $query_ = $this->get_one('', '', array('market' => $data));

        if($query_['market'] == $data){
            $list = array(
                'market'  => $query_['market'],
                'name_ko' => $query_['name_ko'],
                'name_en' => $query_['name_en'],
            );

            $result = $this->db->insert('cic_coin_admin', $list);
            return $result;
        }else{
            return false;
        }
            
    }


    function reseach_coinAdmin($rowno, $rowperpage, $search=""){
        $this->db->select('*');
        $this->db->form('posts');

        if($search != ''){
            $this->db->like('market', $search);
            $this->db->or_like('name_ko', $search);
        }

        $this -> db -> limit($rowperpage, $rowno);
        $query = $this->db->get();
        return $query-> result_array();
    }

}
?>