<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-usercontrol";
        $searchId = "searchusercontrol";
        $output['title'] = 'Data Master User Control';

        $colModel['sys_user_id'] = array('Id User', 100, TRUE, 'center', 0, TRUE);
        $colModel['sys_user_name'] = array('Nama', 100, TRUE, 'center', 1);
        $colModel['sys_user_password'] = array('Password', 100, TRUE, 'center', 1);
        $colModel['sys_user_last_login_indo'] = array('Last Login', 100, TRUE, 'center', 1);
        $colModel['sys_user_type'] = array('Type', 100, TRUE, 'center', 1);
        $colModel['hr_employee_nik'] = array('NIK', 100, TRUE, 'center', 1);
        $colModel['hr_employee_nick_name'] = array('Nama Panggilan', 100, TRUE, 'center', 1);


        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} User.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );

        $buttons[] = array('Pilih Semua', 'add', 'datausercontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datausercontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datausercontrol');

        $buttons[] = array('Edit Data', 'edit', 'datausercontrol');

        $buttons[] = array('Hapus Data', 'delete', 'datausercontrol');

        $buttons[] = array('separator');

        $buttons[] = array('Edit Profil', 'edit', 'datausercontrol');
        $buttons[] = array('separator');

        $buttons[] = array('Print', 'print', 'datausercontrol');

        $buttons[] = array('Link', 'link', 'datausercontrol');

        // advanced search
        $params = '';


        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("admin/user/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'sys_user_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        $this->load->view('main_user', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('sys_user_name', 'sys_user_password', 'sys_user_last_login_indo', 'sys_user_type',
            'hr_employee_nik', 'hr_employee_nick_name');
        $this->flexigrid->validate_post('sys_user_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('v_user', 'sys_user_id', $param);

        $this->output->set_header($this->config->item('json_header'));
        $result = $records['records']->result();


        if (!is_null($param) && $result == NULL) {
            $record_items[] = array();
            $records['record_count'] = 0;
        } else if (!is_null($param)) {
            $records['record_count'] = count($result);
        } else if ($result == NULL)
            $record_items[] = array();

        foreach ($result as $row) {
            $record_items[] = array($row->sys_user_id, $row->sys_user_id, $row->sys_user_name, $row->sys_user_password,
                $row->sys_user_last_login_indo, $row->sys_user_type, $row->hr_employee_nik, $row->hr_employee_nick_name);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah User';
        $output['usercontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("admin/user/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_user', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_user', 'sys_user_id', $id);
        $output['title'] = 'Edit Group';
        //print_r($record);
        $output['sys_user_id'] = $record->sys_user_id;
        $output['sys_user_name'] = $record->sys_user_name;
        $output['sys_user_password'] = $record->sys_user_password;
        $output['sys_user_last_login'] = $record->sys_user_last_login_indo;
        $output['sys_user_type'] = $record->sys_user_type;
        $output['sys_group_id'] = $record->sys_group_id;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'sys_user_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/user/edit");
        $this->load->view('form_user', $output);
    }

    public function prepare_link() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_user', 'sys_user_id', $id);
        $output['title'] = 'Edit Group';
        //print_r($record);
        $output['sys_user_id'] = $record->sys_user_id;
        $output['sys_user_name'] = $record->sys_user_name;
        $output['sys_user_password'] = $record->sys_user_password;
        $output['sys_user_last_login'] = $record->sys_user_last_login_indo;
        $output['sys_user_type'] = $record->sys_user_type;
        $output['sys_group_id'] = $record->sys_group_id;
        $output['hr_employee_nik'] = $record->hr_employee_nik;
        $output['hr_employee_nick_name'] = $record->hr_employee_nick_name;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'sys_user_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/user/link");
        $this->load->view('form_link_profile', $output);
    }

    public function link() {

        if ($this->input->post('box_delete_link') != '') {
            $delete = $this->input->post('box_delete_link');
            $data['sys_user_id'] = NULL;
            if ($delete = 'user')
                $id = $this->db->update('hr_employee', $data, array('sys_user_id' => $this->input->post('box_user_id')));
            else if ($delete = 'employee')
                $id = $this->db->update('hr_employee', $data, array('hr_employee_nik' => $this->input->post('box_employee_nik')));
        } else {
            $data['sys_user_id'] = $this->input->post('box_user_id');
            $id = $this->db->update('hr_employee', $data, array('hr_employee_nik' => $this->input->post('box_employee_nik')));
        }

        $this->log->insert("Mengupdate Link User ke Employee " . $data['sys_user_id'], $id, 'sys_user');

        echo 'ok';
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_user', 'sys_user_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/user/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_user', 'sys_user_id', $value);
            $text .= 'nama: ' . $detail->sys_user_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-usercontrol").flexReload();';
        $output['send_url'] = site_url("admin/user/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_user', 'sys_user_id', $value);
            $text .= 'nama: ' . $detail->sys_user_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-usercontrol").flexReload();';
        $output['send_url'] = site_url("admin/user/status");
        $this->load->view('form_change', $output);
    }

    public function add() {
        $data['sys_user_name'] = $this->input->post('box_user_name');
        $data['sys_user_password'] = md5($this->input->post('box_user_password'));
        $data['sys_user_last_login'] = date_format(date_create($this->input->post('box_user_last_login')), 'Y-m-d h:i:s');
        $data['sys_user_type'] = $this->input->post('box_user_type');
        $data['sys_group_id'] = $this->input->post('box_group_id');

        if (is_null($data['sys_user_password']) || $data['sys_user_password'] == '')
            $data['sys_user_password'] = md5('user1234');

        $id = $this->db->insert('sys_user', $data);
        $this->log->insert("Menambahkan User " . $data['sys_user_name'], $id, 'sys_user');

        $order[]['sys_user_id'] = 'desc';
        $detail = $this->query->get_list_basic('sys_user', null, $order, 1);

        //$id = $this->db->insert('sys_profile', array('sys_user_id' => $detail[0]->sys_user_id));
        //$id = $this->db->insert('hr_employee', array('sys_user_id' => $detail[0]->sys_user_id));
        $this->log->insert("Menambahkan User " . $data['sys_user_name'], $id, 'sys_profile');

        echo 'ok';
    }

    public function edit() {
        $data['sys_user_name'] = $this->input->post('box_user_name');
        $data['sys_user_last_login'] = date_format(date_create($this->input->post('box_user_last_login')), 'Y-m-d h:i:s');
        $data['sys_user_type'] = $this->input->post('box_user_type');
        $data['sys_group_id'] = $this->input->post('box_group_id');

        $detail = $this->query->get_detail('sys_user', 'sys_user_id', $this->input->post('box_user_id'));

        if (is_null($this->input->post('box_user_password')) || $this->input->post('box_user_password') == '')
            $data['sys_user_password'] = md5('user1234');
        else if ($this->input->post('box_user_password') == $detail->sys_user_password)
            $data['sys_user_password'] = $this->input->post('box_user_password');
        else
            $data['sys_user_password'] = md5($this->input->post('box_user_password'));


        $id = $this->db->update('sys_user', $data, array('sys_user_id' => $this->input->post('box_user_id')));

        $this->log->insert("Mengupdate User " . $data['sys_user_name'], $id, 'sys_user');

        echo 'ok';
    }

    public function prepare_editprofile() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_employee', 'hr_employee_nik', $id);
        $output['title'] = 'Edit Profile';
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
        $output['hr_employee_enter_date'] = $record->hr_employee_enter_date_indo;
        $output['hr_employee_out_date'] = $record->hr_employee_out_date_indo;
        $output['hr_employee_status'] = $record->hr_employee_status;
        $output['hr_employee_pict'] = $record->hr_employee_pict;
        $output['hr_employee_email'] = $record->hr_employee_email;
        $output['hr_employee_salary'] = $record->hr_employee_salary;


        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'hr_employee_nik', 'value' => $output['hr_employee_nik'], 'type' => 'hidden'));
        $output['send_url'] = site_url("admin/user/editprofile");
        $this->load->view('form_profile', $output);
    }

    public function editprofile() {

        //$data['sys_user_id'] = $this->input->post('box_user_id');
        $data['hr_employee_full_name'] = $this->input->post('box_employee_full_name');
        $data['hr_employee_nick_name'] = $this->input->post('box_employee_nick_name');
        $data['hr_employee_address'] = $this->input->post('box_employee_address');
        $data['hr_employee_phone'] = $this->input->post('box_employee_phone');
        $data['hr_employee_hp'] = $this->input->post('box_employee_hp');
        $data['hr_employee_birth_date'] = date_format(date_create($this->input->post('box_employee_birth_date')), 'Y-m-d');
        $data['hr_employee_birth_place'] = $this->input->post('box_employee_birth_place');
        $data['hr_employee_ktp'] = $this->input->post('box_employee_ktp');
        $data['hr_employee_nik'] = $this->input->post('box_employee_nik');
        $data['hr_employee_enter_date'] = date_format(date_create($this->input->post('box_employee_enter_date')), 'Y-m-d');
        $data['hr_employee_out_date'] = date_format(date_create($this->input->post('box_employee_out_date')), 'Y-m-d');
        $data['hr_employee_status'] = $this->input->post('box_employee_status');
        $data['hr_employee_pict'] = $this->input->post('box_employee_pict');
        $data['hr_employee_email'] = $this->input->post('box_employee_email');
        $data['hr_employee_salary'] = $this->input->post('box_employee_salary');


        $id = $this->db->update('hr_employee', $data, array('hr_employee_nik' => $this->input->post('box_employee_nik_old')));

        $this->log->insert("Mengupdate Profile dengan ID" . $this->input->post('box_user_id'), $id, 'profile');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('sys_user', 'sys_user_id', $value);
            $id = $this->db->delete('sys_user', array('sys_user_id' => $value));

            $this->log->insert("Menghapus user " . $record->sys_user_name, $id, 'sys_user');
        }
        echo 'ok';
    }

    public function status() {

        $data['sys_user_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_user', 'sys_user_id', $value);
            $id = $this->db->update('sys_user', $data, array('sys_user_id' => $value));
            $this->log->insert("Update Status Group " . $detail->sys_user_name, $id, 'sys_user');
        }

        echo 'ok';
    }

    public function search_employee() {
        $keyword = $this->input->post('term');

        $data['response'] = 'false';

        $search['hr_employee_nik'] = $keyword;
        $search['hr_employee_nick_name'] = $keyword;
        $search['hr_employee_full_name'] = $keyword;
        $query = $this->query->lookup_table_or('v_employee', $search);

        if ($query->num_rows() > 0) {
            $data['response'] = 'true';
            $data['message'] = array();
            foreach ($query->result() as $row) {
                $data['message'][] = array('label' => $row->hr_employee_nik, 'nama' => $row->hr_employee_nick_name);
            }
        }
        echo json_encode($data);
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('sys_user', 'sys_user_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_user', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_user', $output);
                    break;
                case 'Pdf' :
                    $this->printing_pdf($id);
                    break;
                case 'Excel' :
                    $this->printing_excel($id);
                    break;
                default: break;
            }
        } else
            show_404();
    }

    public function printing_pdf($id) {
        $this->load->helper('pdf');

        $record = $this->query->get_detail('sys_user', 'sys_user_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_user', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('sys_user', 'sys_user_id', $id);

        $this->load->library('pxl');
        $laporan = new PHPExcel();
        $laporan->getProperties()->setTitle("Laporan ")->setDescription("Laporan");
        $laporan->setActiveSheetIndex(0);
        $worksheet1 = 'laporan Loh ';
        $laporan->getActiveSheet()->setTitle($worksheet1);
        $laporan->getActiveSheet()->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(6);
        $laporan->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $laporan->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $laporan->getActiveSheet()->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

        $laporan->getActiveSheet()->setCellValue("A1", "Laporan");
        $laporan->getActiveSheet()->mergeCells('A1:L1');
        $laporan->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $laporan->getActiveSheet()->getStyle('A1')->getFont()->setSize(25);

        // ** border
        $myBorder = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $allBorder = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );

        $row = 2;

        foreach ($record as $item => $value) {
            $laporan->getActiveSheet()->setCellValue("A" . $row++, $value);
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($laporan, 'Excel5');
        $objWriter->save('php://output');
    }

    public function notification() {
        
    }

}

?>
