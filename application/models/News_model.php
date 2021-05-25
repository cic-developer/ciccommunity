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

    public $allow_order = array('news_id desc', 'comp_id', 'news_title', 'news_content', 'news_reviews desc', 'news_hot', );

    function __construct()
    {
        parent::__construct();
    }

    public function get_news_list($limit = '', $offset = '', $where = '', $category_id = '', $orderby = '', $sfield = '', $skeyword = '', $sop = 'OR')
    {
		if ( ! in_array(strtolower($orderby), $this->allow_order)) {
			$orderby = 'news_id desc';
		}
		
		$sop = (strtoupper($sop) === 'AND') ? 'AND' : 'OR';
		if (empty($sfield)) {
			$sfield = array('news_title', 'news_contents');
		}
		
		$search_where = array();
		$search_like = array();
		$search_or_like = array();
		if ($sfield && is_array($sfield)) {
			foreach ($sfield as $skey => $sval) {
				$ssf = $sval;
				if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
					if (in_array($ssf, $this->search_field_equal)) {
						$search_where[$ssf] = $skeyword;
					} else {
						$swordarray = explode(' ', $skeyword);
						foreach ($swordarray as $str) {
							if (empty($ssf)) {
								continue;
							}
							if ($sop === 'AND') {
								$search_like[] = array($ssf => $str);
							} else {
								$search_or_like[] = array($ssf => $str);
							}
						}
					}
				}
			}
		} else {
			$ssf = $sfield;
			if ($skeyword && $ssf && in_array($ssf, $this->allow_search_field)) {
				if (in_array($ssf, $this->search_field_equal)) {
					$search_where[$ssf] = $skeyword;
				} else {
					$swordarray = explode(' ', $skeyword);
					foreach ($swordarray as $str) {
						if (empty($ssf)) {
							continue;
						}
						if ($sop === 'AND') {
							$search_like[] = array($ssf => $str);
						} else {
							$search_or_like[] = array($ssf => $str);
						}
					}
				}
			}
		}

		$this->db->select('news.*, ');
		$this->db->from($this->_table);
		$this->db->join('company', 'news.comp_id = company.comp_id', 'left');
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}

		$this->db->order_by($orderby);
		if ($limit) {
			$this->db->limit($limit, $offset);
		}
		$qry = $this->db->get();
		$result['list'] = $qry->result_array();
		

		$this->db->select('count(*) as rownum');
		$this->db->from($this->_table);
		// $this->db->join('member', 'news.comp_id = company.mem_id', 'left');
		if ($where) {
			$this->db->where($where);
		}
		if ($search_where) {
			$this->db->where($search_where);
		}
		// if ($category_id) {
		// 	if (strpos($category_id, '.')) {
		// 		$this->db->like('post_category', $category_id . '', 'after');
		// 	} else {
		// 		$this->db->group_start();
		// 		$this->db->where('post_category', $category_id);
		// 		$this->db->or_like('post_category', $category_id . '.', 'after');
		// 		$this->db->group_end();
		// 	}
		// }
		if ($search_like) {
			foreach ($search_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->like($skey, $sval);
				}
			}
		}
		if ($search_or_like) {
			$this->db->group_start();
			foreach ($search_or_like as $item) {
				foreach ($item as $skey => $sval) {
					$this->db->or_like($skey, $sval);
				}
			}
			$this->db->group_end();
		}
		$qry = $this->db->get();
		$rows = $qry->row_array();
		$result['total_rows'] = $rows['rownum'];

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

    public function update($news_id)
    {
        $where = array(
            'news_id' => $news_id,
        );
        $this->db->where($where);
        $this->db->set($updatedata);

        return $this->db->update($this->_table);
    }
}