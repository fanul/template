<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Employee extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $gridId = "tabel-employeecontrol";
        $searchId = "searchemployeecontrol";
        $output['title'] = 'Data Master Employee Control';

        $colModel['hr_employee_nik'] = array('NIK', 100, TRUE, 'center', 1);
        $colModel['hr_employee_pict'] = array('Foto', 100, TRUE, 'center', 0);
        $colModel['hr_employee_nick_name'] = array('Nama Panggilan', 100, TRUE, 'center', 1);
        $colModel['hr_employee_full_name'] = array('Nama Lengkap', 100, TRUE, 'center', 1);
        $colModel['hr_employee_phone'] = array('Phone', 100, TRUE, 'center', 1);
        $colModel['hr_employee_hp'] = array('Hp', 100, TRUE, 'center', 1);
        $colModel['hr_employee_email'] = array('Email', 100, TRUE, 'center', 1);
        $colModel['hr_employee_address'] = array('Alamat', 100, TRUE, 'center', 1);
        $colModel['hr_employee_salary'] = array('Gaji', 100, TRUE, 'center', 1);
        $colModel['hr_division_name'] = array('Departement', 100, TRUE, 'center', 1);
        $colModel['hr_role_name'] = array('Posisi', 100, TRUE, 'center', 1);

        $gridParams = array(
            'width' => 'auto',
            'height' => 250,
            'rp' => 10,
            'rpOptions' => '[10,20,30,40,50]',
            'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} Employee.',
            'blockOpacity' => 0.5,
            'showTableToggleBtn' => false,
            'singleSelect' => false,
            'hide' => 'true'
        );

        $buttons[] = array('Pilih Semua', 'add', 'dataemployeecontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'dataemployeecontrol');
        $buttons[] = array('separator');

        $buttons[] = array('Tambah Data', 'add', 'dataemployeecontrol');
        $buttons[] = array('Edit Data', 'edit', 'dataemployeecontrol');
        $buttons[] = array('Hapus Data', 'delete', 'dataemployeecontrol');

        $buttons[] = array('separator');
        $buttons[] = array('Input Keluarga', 'edit', 'dataemployeecontrol');
        $buttons[] = array('Input Trackrecord', 'edit', 'dataemployeecontrol');

        $buttons[] = array('separator');
        $buttons[] = array('Detail', 'detail', 'dataemployeecontrol');

        // advanced search
        $params = '';

        //grid options
        $gridColor = NULL;
        $onSuccess = 'getSumsum()';

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("hr/employee/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'hr_employee_nik', 'asc', $gridParams, $buttons, $onsubmit, $gridColor, $onSuccess);

        $output['js_grid'] = $grid_js;

        $this->load->view('main_employee', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('hr_employee_nik', 'hr_employee_pict', 'hr_employee_nick_name',
            'hr_employee_full_name', 'hr_employee_phone', 'hr_employee_hp', 'hr_employee_email', 'hr_employee_address', 'hr_employee_salary', 'hr_division_name', 'hr_role_name');
        $this->flexigrid->validate_post('hr_employee_nik', 'desc', $valid_fields);
        $records = $this->query->get_list_table('v_employee', 'hr_employee_nik', $param);

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
            $record_items[] = array($row->hr_employee_nik, $row->hr_employee_nik, ('<img width="100" height="100" src="' . base_url() . 'userpict/' . $row->hr_employee_pict . '">'),
                $row->hr_employee_nick_name, $row->hr_employee_full_name, $row->hr_employee_phone,
                $row->hr_employee_hp, $row->hr_employee_email, $row->hr_employee_address, $row->hr_employee_salary, $row->hr_division_name, $row->hr_role_name);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah Karyawan';
        $output['employeecontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("hr/employee/add");
        //$output['employee_nik'] = $this->generate_nik();
        $this->load->view('form_employee', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_employee', 'hr_employee_nik', $id);
        $output['title'] = 'Edit Profile';
        //print_r($record);
        $output['hr_employee_full_name'] = $record->hr_employee_full_name;
        $output['hr_employee_nick_name'] = $record->hr_employee_nick_name;
        $output['hr_employee_address'] = $record->hr_employee_address;
        $output['hr_employee_salary'] = $record->hr_employee_salary;
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

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'hr_employee_nik_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/employee/edit");
        $this->load->view('form_employee', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_employee', 'sys_employee_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/employee/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('hr_employee', 'hr_employee_nik', $value);
            $text .= 'nama: ' . $detail->hr_employee_nick_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-employeecontrol").flexReload();';
        $output['send_url'] = site_url("hr/employee/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_detail() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_employee', 'hr_employee_nik', $id);
        $output['title'] = $record->hr_employee_nick_name;
        $output['data_master'] = 'employee_type_public';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['id'] = $id;
        //$output['send_url'] = site_url("hr/employee/detail/" . $this->my_encrypt->encode($id));

        $where['hr_employee_nik'] = $id;
        $output['track_record'] = $this->query->get_list_basic('v_track_record', $where);
        $output['family'] = $this->query->get_list_basic('v_family', $where);

        $output['record'] = $record;
        $this->load->view('detail_employee', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_employee', 'sys_employee_id', $value);
            $text .= 'nama: ' . $detail->sys_employee_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-employeecontrol").flexReload();';
        $output['send_url'] = site_url("hr/employee/status");
        $this->load->view('form_change', $output);
    }

    public function add() {

        $data['hr_employee_full_name'] = $this->input->post('box_employee_full_name');
        $data['hr_employee_nick_name'] = $this->input->post('box_employee_nick_name');
        $data['hr_employee_address'] = $this->input->post('box_employee_address');
        $data['hr_employee_salary'] = $this->input->post('box_employee_salary');
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

        //$id = $this->db->update('hr_employee', $data, array('hr_employee_id' => $this->input->post('box_employee_id')));
        $id = $this->db->insert('hr_employee', $data);
        $this->log->insert("Mengupdate Profile dengan ID" . $this->input->post('wfsys_employee_id'), $id, 'profile');

        echo 'ok';
    }

    public function edit() {

        $data['hr_employee_full_name'] = $this->input->post('box_employee_full_name');
        $data['hr_employee_nick_name'] = $this->input->post('box_employee_nick_name');
        $data['hr_employee_address'] = $this->input->post('box_employee_address');
        $data['hr_employee_salary'] = $this->input->post('box_employee_salary');
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

        $id = $this->db->update('hr_employee', $data, array('hr_employee_nik' => $this->input->post('box_employee_nik')));

        $this->log->insert("Mengupdate Employee " . $data['hr_employee_nick_name'], $id, 'hr_employee');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('hr_employee', 'hr_employee_nik', $value);
            $id = $this->db->delete('hr_employee', array('hr_employee_nik' => $value));

            $this->log->insert("Menghapus employee " . $record->hr_employee_nick_name, $id, 'hr_employee');
        }
        echo 'ok';
    }

    public function status() {

        $data['sys_employee_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_employee', 'sys_employee_id', $value);
            $id = $this->db->update('sys_employee', $data, array('sys_employee_id' => $value));
            $this->log->insert("Update Status Group " . $detail->sys_employee_name, $id, 'sys_employee');
        }

        echo 'ok';
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('sys_employee', 'sys_employee_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_employee', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_employee', $output);
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

        $record = $this->query->get_detail('sys_employee', 'sys_employee_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_employee', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('sys_employee', 'sys_employee_id', $id);

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
