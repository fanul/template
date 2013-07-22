<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Notif extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function prepare_notif($id) {
        $record = $this->query->get_detail('sys_notif', 'sys_notif_id', $id);
        $output['sys_notif_message'] = $record->sys_notif_message;
        $output['title'] = 'Notifikasi';
        $this->load->view('form_notif', $output);
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
        $record = $this->query->get_detail('v_user', 'sys_user_id', $id);
        $output['title'] = 'Edit Profile';
        //print_r($record);
        $output['sys_user_id'] = $record->sys_user_id;
        $output['sys_profile_full_name'] = $record->sys_profile_full_name;
        $output['sys_profile_nick_name'] = $record->sys_profile_nick_name;
        $output['sys_profile_address'] = $record->sys_profile_address;
        $output['sys_profile_phone'] = $record->sys_profile_phone;
        $output['sys_profile_hp'] = $record->sys_profile_hp;
        $output['sys_profile_birth_date'] = $record->sys_profile_birth_date_indo;
        $output['sys_profile_birth_place'] = $record->sys_profile_birth_place;
        $output['sys_profile_ktp'] = $record->sys_profile_ktp;
        $output['sys_profile_nik'] = $record->sys_profile_nik;
        $output['sys_profile_pict'] = $record->sys_profile_pict;
        $output['sys_profile_email'] = $record->sys_profile_email;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'sys_user_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("public/profile/editprofile");
        $this->load->view('form_profile', $output);
    }

    public function editprofile() {

        //$data['sys_user_id'] = $this->input->post('wfsys_user_id');
        $data['sys_profile_full_name'] = $this->input->post('wfsys_profile_full_name');
        $data['sys_profile_nick_name'] = $this->input->post('wfsys_profile_nick_name');
        $data['sys_profile_address'] = $this->input->post('wfsys_profile_address');
        $data['sys_profile_phone'] = $this->input->post('wfsys_profile_phone');
        $data['sys_profile_hp'] = $this->input->post('wfsys_profile_hp');
        $data['sys_profile_birth_date'] = date_format(date_create($this->input->post('wfsys_profile_birth_date')), 'Y-m-d');
        $data['sys_profile_birth_place'] = $this->input->post('wfsys_profile_birth_place');
        $data['sys_profile_ktp'] = $this->input->post('wfsys_profile_ktp');
        $data['sys_profile_nik'] = $this->input->post('wfsys_profile_nik');
        $data['sys_profile_pict'] = $this->input->post('wfsys_profile_pict');
        $data['sys_profile_email'] = $this->input->post('wfsys_profile_email');

        $id = $this->db->update('sys_profile', $data, array('sys_user_id' => $this->input->post('wfsys_user_id')));

        $this->log->insert("Mengupdate Profile dengan ID" . $this->input->post('wfsys_user_id'), $id, 'profile');

        echo 'ok';
    }

}

?>
