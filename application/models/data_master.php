<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_master extends CI_Model {

    public function sex() {
        $array[] = '';
        $array['Laki - Laki'] = 'Laki - Laki';
        $array['Perempuan'] = 'Perempuan';
        return $array;
        //return array("", "Laki - Laki", "Perempuan");
    }

    public function pendidikan() {
        $array[] = '';
        $array['SD'] = 'SD';
        $array['SMP'] = 'SMP';
        $array['SMA'] = 'SMA';
        $array['D3'] = 'D3';
        $array['S1'] = 'S1';
        $array['S2'] = 'S2';
        return $array;
        //return array("", 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2');
    }

    public function mariage() {
        $array[] = '';
        $array['Belum Menikah'] = 'Belum Menikah';
        $array['Menikah'] = 'Menikah';
        return $array;
        //return array("", 'Belum Menikah', 'Menikah');
    }

    public function status_kontrak() {
        $array[] = '';
        $array['Berjangka'] = 'Berjangka';
        $array['Tetap'] = 'Tetap';
        return $array;
        //return array("", 'Belum Menikah', 'Menikah');
    }

    public function agama() {
        $array[] = '';
        $array['Islam'] = 'Islam';
        $array['Katolik'] = 'Katolik';
        $array['Protestan'] = 'Protestan';
        $array['Budha'] = 'Budha';
        $array['Hindu'] = 'Hindu';
        $array['Konghucu'] = 'Konghucu';
        return $array;
        //return array('', 'Islam', 'Katolik', 'Protestan', 'Budha', 'Hindu', 'Konghucu');
    }

    public function darah() {
        $array[] = '';
        $array['A'] = 'A';
        $array['B'] = 'B';
        $array['AB'] = 'AB';
        $array['O'] = 'O';
        return $array;
        //return array('', 'A', 'B', 'AB', 'O');
    }

    public function pakaian() {
        $array[] = '';
        $array['S'] = 'S';
        $array['M'] = 'M';
        $array['L'] = 'L';
        $array['XL'] = 'XL';
        $array['XXL'] = 'XXL';
        return $array;
        //return array('', 'S', 'M', 'L', 'XL');
    }

    public function romawi_bulan() {
        $array[] = '';
        $array[] = 'I';
        $array[] = 'II';
        $array[] = 'III';
        $array[] = 'IV';
        $array[] = 'V';
        $array[] = 'VI';
        $array[] = 'VII';
        $array[] = 'VIII';
        $array[] = 'IX';
        $array[] = 'X';
        $array[] = 'XI';
        $array[] = 'XII';
        return $array;
    }

    public function relation() {
        $array[] = '';
        $array['orangtua'] = 'orangtua';
        $array['anak'] = 'anak';
        $array['saudara'] = 'saudara';
        $array['istri/suami'] = 'istri/suami';
        return $array;
        //return array('', 'Orangtua', 'anak', 'saudara', 'istri/suami');
    }

    public function bulan_indonesia() {
        $array[] = '';
        $array[] = 'Januari';
        $array[] = 'Februari';
        $array[] = 'Maret';
        $array[] = 'April';
        $array[] = 'Mei';
        $array[] = 'Juni';
        $array[] = 'Juli';
        $array[] = 'Agustus';
        $array[] = 'September';
        $array[] = 'Oktober';
        $array[] = 'November';
        $array[] = 'Desember';
        return $array;
    }

        public function worktype() {

            // 1 = datang kerja
            // 2 = pulang istirahat
            // 3 = kembali istirahat
            // 5 = pulang kerja
            // 6 = ijin
            // 7 = tugas kerja

        $array[] = '';
        $array['1'] = 's';
        $array[''] = 'SMP';
        $array['SMA'] = 'SMA';
        $array['D3'] = 'D3';
        $array['S1'] = 'S1';
        $array['S2'] = 'S2';
        return $array;
        //return array("", 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2');
    }

    public function karyawan_status() {
        $array[] = '';
        $array['aktif'] = 'aktif';
        $array['tidak-aktif'] = 'tidak-aktif';
        $array['pensiun'] = 'pensiun';
        return $array;
        //return array('', 'Orangtua', 'anak', 'saudara', 'istri/suami');
    }

    /* ^^^^^ starter above ^^^^^^^^ */
    /* ^^^^^ addition below ^^^^^^^^ */

    public function travel($where = null) {
        $this->db->select('travel_id, travel_nama');
        if (!is_null($where))
            $this->db->where($where);
        $query = $this->db->get('travel');
        return $query->result();
    }

    public function combo_travel($select = null, $where = null) {
        if (!is_null($where))
            $this->db->where($where);
        $query = $this->db->get('travel');

        $list = '<option value=""></option>';
        foreach ($query->result() as $row) {
            if ($select == $row->travel_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $list .= "<option value='" . $row->travel_id . "' $selected>" . $row->travel_nama . "</option>";
        }
        return $list;
    }

    public function combo_instansi($select = null, $where = null) {
        if (!is_null($where))
            $this->db->where($where);
        $query = $this->db->get('instansi');

        $list = '<option value=""></option>';
        foreach ($query->result() as $row) {
            if ($select == $row->instansi_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $list .= "<option value='" . $row->instansi_id . "' $selected>" . $row->instansi_nama . "</option>";
        }
        return $list;
    }

    public function combo_klien($select = null, $where = null) {
        if (!is_null($where))
            $this->db->where($where);
        $query = $this->db->get('klien');

        $list = '<option value=""></option>';
        foreach ($query->result() as $row) {
            if ($select == $row->klien_id) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $list .= "<option value='" . $row->klien_id . "' $selected>" . $row->klien_nama . "</option>";
        }
        return $list;
    }

    public function status() {
        $array[] = '';
        $array['ORD'] = 'Pemesanan Transaksi';
        $array['TKR'] = 'Tiket Siap Diproses';
        $array['TKC'] = 'Tiket Sedang Diproses';
        $array['TKT'] = 'Tiket OK';
        $array['TLX'] = 'Tiket Dibatalkan';
        $array['TLT'] = 'Time Limit Habis';
        return $array;
    }

    public function combo_status($select = null) {
        $status = $this->status();
        $list = '';
        foreach ($status as $key => $val) {
            if ($select == $key) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $list .= "<option value='$key' $selected>$val</option>";
        }
        return $list;
    }

    public function title() {
        $array[] = '';
        $array['Mr'] = 'Mr';
        $array['Mrs'] = 'Mrs';
        $array['Ms'] = 'Ms';
        $array['Mstr'] = 'Mstr';
        $array['Miss'] = 'Miss';
        return $array;
    }

    public function combo_title($select = null) {
        $title = $this->title();
        $list = '';
        foreach ($title as $key => $val) {
            if ($select == $key) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $list .= "<option value='$key' $selected>$val</option>";
        }
        return $list;
    }

    public function change_status() {
        $array[] = '';
        $array['Idle'] = 'Idle';
        $array['Suspend'] = 'Suspend';
        return $array;
    }

    public function print_type_encrypt() {
        $array[$this->my_encrypt->encode('Web')] = 'Web';
        $array[$this->my_encrypt->encode('Web - Auto Print')] = 'Web - Auto Print';
        $array[$this->my_encrypt->encode('Pdf')] = 'Pdf';
        $array[$this->my_encrypt->encode('Excel')] = 'Excel';
        return $array;
    }

    public function print_type() {
        $array['Web'] = 'Web';
        $array['Web - Auto Print'] = 'Web - Auto Print';
        $array['Pdf'] = 'Pdf';
        $array['Excel'] = 'Excel';
        return $array;
    }

    public function user_type() {
        $array[''] = '';
        $array['Outsource'] = 'Outsource';
        $array['Kontrak'] = 'Kontrak';
        $array['Staff'] = 'Staff';
        $array['Spv'] = 'Spv';
        $array['Manajer'] = 'Manajer';
        return $array;
    }

    public function event_repeat() {
        $array[''] = '';
        $array['hari'] = 'hari';
        $array['minggu'] = 'minggu';
        $array['bulan'] = 'bulan';
        $array['tahun'] = 'tahun';
        return $array;
    }

    public function group_list() {
        $query = $this->query->get_list_basic('sys_group');
        return $query;
    }

    public function track_type_list() {
        $query = $this->query->get_list_basic('hr_track_type');
        return $query;
    }

    public function event_type_list() {
        $query = $this->query->get_list_basic('event_type');
        return $query;
    }

    public function selector($data_master) {
        switch ($data_master) {
            case 'change_status': return $this->change_status();
                break;
            case 'print_type': return $this->print_type();
                break;
            case 'print_type_encrypt': return $this->print_type_encrypt();
                break;
            case 'user_type': return $this->user_type();
                break;

            default:
                break;
        }
    }

    public function list_master_dir($dir = './application/modules/') {
        $result[] = '';

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                    $result[] = $value;
            }
        }
        return $result;
    }

    public function list_master_page($dir = './application/modules/') {
        $result = array();

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (!is_dir($dir . DIRECTORY_SEPARATOR . $value))
                    $result[] = substr($value, 0, -4);
            }
        }
        return $result;
    }

    public function list_master_function($dir = './application/modules/', $filename = NULL) {

        $result = array();

        require_once($dir);
        $classname = ucfirst($filename);
        $class = get_class_methods($classname);
        
        foreach ($class as $key => $value) {
            if(!in_array($value, array('__construct','index')))
            $result[] = $value;
        }
        return $result;
    }

}