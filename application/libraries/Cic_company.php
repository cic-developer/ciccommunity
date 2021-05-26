<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cic_company extends CI_Controller
{
    private $CI;
    private $company_id;
	private $admin;
	private $call_admin;
    
    function __construct()
	{
		$this->CI = & get_instance();
	}
    public function get_company($comp_id = 0)
    {
        if(empty($comp_id)){
            return false;
        }

        if($comp_id){
            $this->CI->load->model('Company_model');
            $company = $this->CI->Company_model->get_one($comp_id);
        } else {
            return false;
        }

        if (element('comp_id', $company)) {
            $this->comany_id[element('comp_id', $company)] = $company;
        }
    }

    public function item_all($comp_id = 0)
    {
        $comp_id = (int) $comp_id;
        if(empty($comp_id) OR $comp_id < 1) {
            return false;
        }
        if ( ! isset($this->company_id[$comp_id])) {
            $this->get_news($comp_id, '');
        }
        if ( ! isset($this->company_id[$comp_id])) {
            return false;
        }

        return $this->company_id[$comp_id];
    }


    public function delete_company($comp_id = 0)
    {
        $comp_id = (int) $comp_id;
        if(empty($comp_id) OR $comp_id < 1){
            return false;
        }

        $this->CI->laod->model(
            array(
                'Company_model',
            )
        );

        $comp = $this->CI->Company_model->get_one($comp_id);
    }
}