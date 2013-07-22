<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_user', 'sys_user_id', $id);
        $output['title'] = 'Edit Group';
        //print_r($record);
        $output['sys_user_id'] = $record->sys_user_id;
        $output['sys_user_name'] = $record->sys_user_name;
        $output['sys_user_password'] = $record->sys_user_password;
        $output['sys_user_type'] = $record->sys_user_type;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'sys_user_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("public/profile/edit");
        $this->load->view('form_user', $output);
    }

    public function edit() {
        $data['sys_user_name'] = $this->input->post('wfsys_user_name');
        $data['sys_user_last_login'] = date_format(date_create($this->input->post('wfsys_user_last_login')), 'Y-m-d h:i:s');
        $data['sys_user_type'] = $this->input->post('wfsys_user_type');
        $data['sys_group_id'] = $this->input->post('wfsys_group_id');

        $detail = $this->query->get_detail('sys_user', 'sys_user_id', $this->input->post('wfsys_user_id'));

        if (is_null($this->input->post('wfsys_user_password')) || $this->input->post('wfsys_user_password') == '')
            $data['sys_user_password'] = 'user1234';
        else if ($this->input->post('wfsys_user_password') == $detail->sys_user_password)
            $data['sys_user_password'] = $this->input->post('wfsys_user_password');
        else
            $data['sys_user_password'] = md5($this->input->post('wfsys_user_password'));

        $id = $this->db->update('sys_user', $data, array('sys_user_id' => $this->input->post('wfsys_user_id')));

        $this->log->insert("Mengupdate User " . $data['sys_user_name'], $id, 'sys_user');

        echo 'ok';
    }

    public function prepare_editprofile() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_employee', 'sys_user_id', $id);
        $output['title'] = 'Edit Profile';
        if ($record != null) {
            //print_r($record);
            $output['sys_user_id'] = $record->sys_user_id;
            $output['hr_employee_full_name'] = $record->hr_employee_full_name;
            $output['hr_employee_nick_name'] = $record->hr_employee_nick_name;
            $output['hr_employee_address'] = $record->hr_employee_address;
            $output['hr_employee_phone'] = $record->hr_employee_phone;
            $output['hr_employee_hp'] = $record->hr_employee_hp;
            $output['hr_employee_birth_date'] = $record->hr_employee_birth_date_indo;
            $output['hr_employee_birth_place'] = $record->hr_employee_birth_place;
            $output['hr_employee_ktp'] = $record->hr_employee_ktp;
            $output['hr_employee_nik'] = $record->hr_employee_nik;
            $output['hr_employee_pict'] = $record->hr_employee_pict;
            $output['hr_employee_email'] = $record->hr_employee_email;

            $output['kode_disable'] = 'disabled';
            $output['tombol'] = 'Update';
            $output['form'] = form_input(array('name' => 'sys_user_id_old', 'value' => $id, 'type' => 'hidden'));
            $output['send_url'] = site_url("public/profile/editprofile");
            $this->load->view('form_profile', $output);
        }
        else
        {
            $output['message'] = 'user tidak punya link profile';
            $this->load->view('error_page', $output);
        }
    }

    public function editprofile() {

        //$data['sys_user_id'] = $this->input->post('wfsys_user_id');
        $data['hr_profile_full_name'] = $this->input->post('box_employee_full_name');
        $data['hr_profile_nick_name'] = $this->input->post('box_employee_nick_name');
        $data['hr_profile_address'] = $this->input->post('box_employee_address');
        $data['hr_profile_phone'] = $this->input->post('box_employee_phone');
        $data['hr_profile_hp'] = $this->input->post('box_employee_hp');
        $data['hr_profile_birth_date'] = date_format(date_create($this->input->post('box_employee_birth_date')), 'Y-m-d');
        $data['hr_profile_birth_place'] = $this->input->post('box_employee_birth_place');
        $data['hr_profile_ktp'] = $this->input->post('box_employee_ktp');
        $data['hr_profile_nik'] = $this->input->post('box_employee_nik');
        $data['hr_profile_pict'] = $this->input->post('box_employee_pict');
        $data['hr_profile_email'] = $this->input->post('box_employee_email');

        $id = $this->db->update('sys_profile', $data, array('sys_user_id' => $this->input->post('box_user_id')));

        $this->log->insert("Mengupdate Profile dengan ID" . $this->input->post('wfsys_user_id'), $id, 'profile');

        echo 'ok';
    }

}

?>
