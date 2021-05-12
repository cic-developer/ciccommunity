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

        
        $query = $this->db->get('cic_coin_stock');
        // $query = $this->db->get('cic_stocks');
        $market_ = $query->result();
        

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

    // function getrecord($search = ''){
    //     $this->db->select('count(*) as allcount');
    //     $this->db->form('post');
        
    //     if($search != ''){
    //         $this->db->like('market', $search);
    //         $this->db->or_like('name_ko', $search);
    //     }
    //     $query = $this->db->get();
    //     $result = $query->result_array();
    //     return $result[0]['allcount'];
    //     }

}
?>