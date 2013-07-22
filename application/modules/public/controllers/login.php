<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        if ($this->input->post('username')) {
            $search = array('sys_user_name' => strtolower($this->input->post('username')), 'sys_user_password' => $this->input->post('pass'));
            $row = $this->query->get_table('v_user', $search);
            $count = $this->query->count_table('v_user', $search);
            $output['error'] = 'User tidak ada atau password salah';
            $output['last_query'] = $this->db->last_query();
            if ($count == 0) {
                $this->load->view('login_form', $output);
            } else {
                $session = array('username' => $row->sys_user_name,
                    'sys_profile_pict' => $row->sys_profile_pict,
                    'sys_group_id' => $row->sys_group_id,
                    'sys_user_last_login' => $row->sys_user_last_login,
                    'sys_group_name' => $row->sys_group_name,
                    'sys_user_id' => $row->sys_user_id);
                $this->session->set_userdata($session);
                $this->query->update_lastlog($search);
                redirect($row->REDIRECT_LINK);
            }
        } else {
            $this->load->view('login_form');
        }
    }

}

?>
