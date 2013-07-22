<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends CI_Model {

    function insert($action, $row, $table, $phase = 1) {
        $data = array('sys_log_action' => $action,
            'sys_user_id' => $this->session->userdata('sys_user_id'),
            'sys_log_query' => $this->db->last_query(),
            'sys_log_row' => $row,
            'sys_log_time' => '"CURRENT_TIMESTAMP"',
            'sys_log_table' => $table,
            'sys_log_phase' => $phase);
        $this->db->insert('sys_log', $data);
        $this->update_time_stamp();
    }

    function update_time_stamp() {
        $this->db->set('sys_log_time', "CURRENT_TIMESTAMP", false);
        $this->db->where('sys_log_id',  $this->db->insert_id());
        $this->db->update('sys_log');
    }

}