<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class acl extends CI_Model {

    function access($access) {
        $row = $this->db->from('v_acl')->where(array('sys_group_name' => $this->session->userdata('sys_group_name'), 'sys_page_act' => $access))->count_all_results();
        if ($row == 1 || $this->session->userdata('sys_group_name') == 'admin' || strstr($access, 'public')) {
            return true;
        } else {
            return false;
        }
    }

    function privillage($privillage, $page, $function = NULL) {
        $this->load->database();
        
        $where['sys_group_id'] = $this->session->userdata('sys_group_id');
        $where['sys_privillage'] = $privillage;
        $where['sys_page'] = $page;

        if ($function == NULL)
            $row = $this->db->from('v_acl')->where($where)->count_all_results();
        else
            $row = $this->db->from('v_acl')->where($where)->like('sys_access',$function)->count_all_results();

        //echo $this->db->last_query();
        if ($row >= 1 || $this->session->userdata('sys_group_name') == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    function view($uri)
    {
        
    }
    
    function url($url) {
        $row = $this->db->from('v_acl')->where(array('sys_group_name' => $this->session->userdata('sys_group_name'), 'sys_page_url' => $access))
                        ->or_like('sys_group_name', 'public')->count_all_results();
        if ($row > 0 || $this->session->userdata('sys_group_name') == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    function is_login() {
        if ($this->session->userdata('username') == NULL)
            echo '<html><head><meta HTTP-EQUIV="REFRESH" content="0; url=' . site_url('user/login') . '"></head></html>';
    }

}