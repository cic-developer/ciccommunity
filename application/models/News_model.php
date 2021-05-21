<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * News model class
 *
 * Copyright (c) CIBoard <www.ciboard.co.kr>
 *
 * @author CIBoard (develop@ciboard.co.kr)
 */

class News_model extends CB_Model
{
    public $_table = 'news';

    public $primary_key = 'news_id';
    
    public $cache_prefix = 'news/news-model-get-';

    public $cache_time = 86400;

    function __construct()
    {
        parent::__construct();

        check_cache_dir('news');
    }

    public function get_news_list($where = '')
    {
        $result = $this->get('','', $where, '', 0 , 'new_order', 'ASC');
        return $result;
    }

    public function get_one($primary_value = '', $select = '', $where = '')
    {
        $use_cache = false;
        if($primary_value && empty($select) && empty($where)){
            $use_cache = true;
        }

        if($use_cache) {
            $cachename = $this->cache_prefix . $primary_value;
            if( ! $result = $this->cache->get($cachename)){
                $result = parent::get_one($primary_value);
                $this->cache->save($cachename, $result, $this->cache_time);
            }
        }else{
            $result = parent::get_one($primary_value, $select, $where);
        }
        return $result;
    }

    public function delete($primary_value = '', $where = '')
    {
        if( empty($primary_value)){
            return false;
        }
        $result = parent::delete($primary_value);
        $this->cache->delete($this->cache_prefix . $primary_value);
        return $result;
    }

    public function update($primary_value = '', $updatedata = '', $where = '')
    {
        if (empty($primary_value)){
            return false;
        }

        $result = parent::update($primary_value, $updatedata);
        if($result) {
            $this->cache->delete($this->cache_prefix . $primary_value);
        }
        return $result;
    }
}