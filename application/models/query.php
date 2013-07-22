<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Query extends CI_Model {

    public function get_list_table($table_name, $id, $param = NULL, $search = NULL) {

        if (!is_null($param)) {
            $filters = explode('&', $param);
            foreach ($filters as $filter) {
                if (!is_null($filter) && $filter != '') {
                    $command = explode('=', $filter);
                    switch ($command[1]) {
                        case 'lk' : $this->db->like($command[0], $command[2]);
                            break;
                        case 'nlk' : $this->db->not_like($command[0], $command[2]);
                            break;
                        case 'eq' : $this->db->where($command[0], $command[2]);
                            break;
                        case 'neq' : $this->db->where_not_in($command[0], $command[2]);
                            break;
                        case 'gt' : $this->db->where($command[0].' >',$command[2]);
                            break;
                        case 'lt' : $this->db->where($command[0].' <',$command[2]);
                            break;
                    }
                }
            }
        }

        //Build contents query
        if (!is_null($search)) {
            $this->db->where($search);
        }

        $this->db->select('*')->from($table_name);
        $this->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        if (!is_null($search)) {
            $this->db->where($search);
        }

        //Build count query
        $this->db->select('count(' . $id . ') as RECORD_COUNT')->from($table_name);
        $this->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->RECORD_COUNT;

        //Return all
        return $return;
    }

    public function get_table($table, $where) {
        return $this->db->from($table)->where($where)->get()->row();
    }

    public function count_table($table, $where) {
        return $this->db->select('*')->from($table)->where($where)->count_all_results();
    }

    public function update_lastlog($where) {
        $this->db->set('sys_user_last_login', "CURRENT_TIMESTAMP", false);
        $this->db->where($where);
        $this->db->update('sys_user');
    }

    public function get_detail($table, $kolom, $id) {
        return $this->db->where(array($kolom => $id))->from($table)->get()->row();
    }

    public function lookup_table($table, $col, $keyword) {
        return $this->db->select('*')->from($table)->where("upper(" . $col . ") LIKE upper('%" . $keyword . "%')", NULL, FALSE)->get();
    }

    //** tambahanku **//
    public function get_list_table_or($table_name, $id, $search = NULL) {
        //$table_name = "V_INTERVENSI_GAKIN_DINSOS";
        //Build contents query
        if (!is_null($search)) {
            foreach ($search as $items) {
                if (is_array($items)) {
                    foreach ($items as $item => $key)
                        $this->db->or_where($item, $key);
                }
                else
                    $this->db->or_where($items);
            }
        }
        $this->db->select('*')->from($table_name);
        $this->flexigrid->build_query();

        //Get contents
        $return['records'] = $this->db->get();

        //Build count query
        if (!is_null($search)) {
            foreach ($search as $items) {
                if (is_array($items)) {
                    foreach ($items as $item => $key)
                        $this->db->or_where($item, $key);
                }
                else
                    $this->db->or_where($items);
            }
        }
        $this->db->select('count(' . $id . ') as RECORD_COUNT')->from($table_name);
        $this->flexigrid->build_query(FALSE);
        $record_count = $this->db->get();
        $row = $record_count->row();

        //Get Record Count
        $return['record_count'] = $row->RECORD_COUNT;

        //Return all
        return $return;
    }

    public function lookup_table_or($table, $array, $filter = null, $mode = null, $more = null, $group_by=null) {
        /*
          echo $table;
          print_r($array);
          print_r($mode);
          print_r($more);
         */

          $select = "select * ";
          $from = "from " . $table;
          $where = " where ";
          $group_by = " group_by ";


        //$this->db->select('*');
        //$this->db->from($table);


        if (is_array($array)) {
            $where .= '(';
            $index = 0;
            foreach ($array as $item => $key) {
                //$this->db->or_where("upper(" ."'". $item ."'". ") LIKE upper('%" . $key . "%')");
                if ($index++ < 1)
                    $where .= " upper($item) LIKE upper('%$key%')";
                else
                    $where .= " or upper($item) LIKE upper('%$key%')";
            }
            $where .= ')';
        }

        if ($more != null)
            $this->db->where($more);

        if ($filter != null) {
            if ($mode == null) {
                //$this->db->where($filter);
                if (is_array($filter)) {
                    foreach ($filter as $item => $key) {
                        //$this->db->or_where("upper(" ."'". $item ."'". ") LIKE upper('%" . $key . "%')");
                        $where .= " and $item = '$key'";
                    }
                }
            } else {
                if (is_array($filter)) {
                    foreach ($filter as $item => $key) {
                        //$this->db->or_where("upper(" ."'". $item ."'". ") LIKE upper('%" . $key . "%')");
                        $where .= " and $item != '$key'";
                    }
                }
            }
        }

        if(!is_null($group_by))
        {
            $group_by .= $group_by.' ';
        } else $group_by = '';

        $sql = $select . $from . $where . $group_by;
        //echo $sql;
        return $this->db->query($sql);

        //return $this->db->get();
    }

    function get_list_basic($from, $where = null, $order = null, $limit = null) {
        /*
          echo $from."<br>";
          print_r($where);
          print_r($order);
          echo $limit;
         */
        $this->db->select()->from($from);

        if ($where != null)
            $this->db->where($where);

        //format dari order yang digunakan adalah $array[][nama_kolom] = mode_sorting
        if ($order != null) {
            foreach ($order as $items) {
                foreach ($items as $item => $key) {
                    $this->db->order_by($item, $key);
                }
            }
        }

        if ($limit != null) {
            if (is_array($limit)) {
                $this->db->limit($limit['start'], $limit['end']);
            }
            else
                $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }

}