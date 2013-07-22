<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Family extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        $id = $this->input->post('id');

        $detail = $this->query->get_detail('v_employee', 'hr_employee_nik', $id);

        $gridId = "tabel-familycontrol";
        $searchId = "searchfamilycontrol";
        $output['title'] = 'Data Master Family Of ' . $detail->hr_employee_full_name;

        $colModel['hr_family_id'] = array('Foto', 100, TRUE, 'center', 0, TRUE);
        $colModel['hr_family_pict'] = array('Foto', 100, TRUE, 'center', 0);
        $colModel['hr_family_relation'] = array('Relasi', 100, TRUE, 'center', 1);
        $colModel['hr_family_nick_name'] = array('Nama Panggilan', 100, TRUE, 'center', 1);
        $colModel['hr_family_full_name'] = array('Nama Lengkap', 100, TRUE, 'center', 1);
        $colModel['hr_family_address'] = array('Alamat', 100, TRUE, 'center', 1);
        $colModel['hr_family_phone'] = array('Phone', 100, TRUE, 'center', 1);
        $colModel['hr_family_hp'] = array('Hp', 100, TRUE, 'center', 1);
        $colModel['hr_family_birth_place'] = array('Tempat Lahir', 100, TRUE, 'center', 1);
        $colModel['hr_family_birth_date'] = array('Tanggal Lahir', 100, TRUE, 'center', 1);
        $colModel['hr_family_ktp'] = array('Phone', 100, TRUE, 'center', 1);
        $colModel['hr_family_email'] = array('Email', 100, TRUE, 'center', 1);
        $colModel['hr_family_job'] = array('Pekerjaan', 100, TRUE, 'center', 1);

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

        $buttons[] = array('Pilih Semua', 'add', 'datafamilycontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'datafamilycontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'datafamilycontrol');
        $buttons[] = array('Edit Data', 'edit', 'datafamilycontrol');
        $buttons[] = array('Hapus Data', 'delete', 'datafamilycontrol');

        // advanced search
        $params = $id;


        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

        $site = site_url("hr/family/datatable/" . $params);

        $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
        $grid_js = build_grid_js($gridId, $site, $colModel, 'hr_family_id', 'asc', $gridParams, $buttons, $onsubmit);

        $output['js_grid'] = $grid_js;

        $output['form_main'] = form_input(array(
            'name' => 'form_main',
            'id' => 'form_main',
            'value' => $id,
            'type' => 'hidden'));
        $output['id'] = $id;


        $this->load->view('main_family', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('hr_family_id', 'hr_family_pict', 'hr_family_relation', 'hr_family_nick_name', 'hr_family_full_name', 'hr_family_address',
            'hr_family_phone', 'hr_family_hp', 'hr_family_birth_place', 'hr_family_birth_date',
            'hr_family_ktp', 'hr_family_email', 'hr_family_job');
        $this->flexigrid->validate_post('hr_family_id', 'asc', $valid_fields);
        $where['hr_employee_nik'] = $param;
        $records = $this->query->get_list_table('v_family', 'hr_family_id', NULL, $where);

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
            $record_items[] = array($row->hr_family_id, $row->hr_family_id, ('<img width="100" height="100" src="' . base_url() . 'userpict/' . $row->hr_family_pict . '">'),
                $row->hr_family_relation, $row->hr_family_nick_name, $row->hr_family_full_name, $row->hr_family_address, $row->hr_family_phone,
                $row->hr_family_hp, $row->hr_family_birth_place, $row->hr_family_birth_date_indo, $row->hr_family_ktp, $row->hr_family_email, $row->hr_family_job);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $id = $this->input->post('id');
        $output['title'] = 'Tambah Keluarga';
        $output['familycontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("hr/family/add");

        $output['form'] = form_input(array(
            'name' => 'box_employee_nik',
            'id' => 'box_employee_nik',
            'value' => $id,
            'type' => 'hidden'));
        //$output['family_nik'] = $this->generate_nik();
        $this->load->view('form_family', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_family', 'hr_family_id', $id);
        $output['title'] = 'Edit Profile';
        //print_r($record);
        $output['hr_family_full_name'] = $record->hr_family_full_name;
        $output['hr_family_nick_name'] = $record->hr_family_nick_name;
        $output['hr_family_address'] = $record->hr_family_address;
        $output['hr_family_phone'] = $record->hr_family_phone;
        $output['hr_family_hp'] = $record->hr_family_hp;
        $output['hr_family_birth_date'] = $record->hr_family_birth_date_indo;
        $output['hr_family_birth_place'] = $record->hr_family_birth_place;
        $output['hr_family_ktp'] = $record->hr_family_ktp;
        $output['hr_family_job'] = $record->hr_family_job;
        $output['hr_family_relation'] = $record->hr_family_relation;
        $output['hr_family_pict'] = $record->hr_family_pict;
        $output['hr_family_email'] = $record->hr_family_email;
        $output['hr_family_id'] = $record->hr_family_id;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'hr_family_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/family/edit");
        $this->load->view('form_family', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('sys_family', 'sys_family_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("hr/family/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('hr_family', 'hr_family_id', $value);
            $text .= 'nama: ' . $detail->hr_family_nick_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-familycontrol").flexReload();';
        $output['send_url'] = site_url("hr/family/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_detail() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_family', 'hr_family_nik', $id);
        $output['title'] = $record->hr_family_nick_name;
        $output['data_master'] = 'family_type_public';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['id'] = $id;
        //$output['send_url'] = site_url("hr/family/detail/" . $this->my_encrypt->encode($id));

        $output['record'] = $record;
        $this->load->view('detail_family', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_family', 'sys_family_id', $value);
            $text .= 'nama: ' . $detail->sys_family_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-familycontrol").flexReload();';
        $output['send_url'] = site_url("hr/family/status");
        $this->load->view('form_change', $output);
    }

    public function add() {

        $data['hr_employee_nik'] = $this->input->post('box_employee_nik');
        $data['hr_family_full_name'] = $this->input->post('box_family_full_name');
        $data['hr_family_nick_name'] = $this->input->post('box_family_nick_name');
        $data['hr_family_address'] = $this->input->post('box_family_address');
        $data['hr_family_phone'] = $this->input->post('box_family_phone');
        $data['hr_family_hp'] = $this->input->post('box_family_hp');
        $data['hr_family_birth_date'] = date_format(date_create($this->input->post('box_family_birth_date')), 'Y-m-d');
        $data['hr_family_birth_place'] = $this->input->post('box_family_birth_place');
        $data['hr_family_ktp'] = $this->input->post('box_family_ktp');
        $data['hr_family_job'] = $this->input->post('box_family_job');
        $data['hr_family_relation'] = $this->input->post('box_family_relation');
        $data['hr_family_pict'] = $this->input->post('box_family_pict');
        $data['hr_family_email'] = $this->input->post('box_family_email');

        //$id = $this->db->update('hr_family', $data, array('hr_family_id' => $this->input->post('box_family_id')));
        $id = $this->db->insert('hr_family', $data);
        $this->log->insert("Mengupdate Family dengan ID" . $this->input->post('wfsys_family_id'), $id, 'profile');

        echo 'ok';
    }

    public function edit() {

        $data['hr_family_full_name'] = $this->input->post('box_family_full_name');
        $data['hr_family_nick_name'] = $this->input->post('box_family_nick_name');
        $data['hr_family_address'] = $this->input->post('box_family_address');
        $data['hr_family_phone'] = $this->input->post('box_family_phone');
        $data['hr_family_hp'] = $this->input->post('box_family_hp');
        $data['hr_family_birth_date'] = date_format(date_create($this->input->post('box_family_birth_date')), 'Y-m-d');
        $data['hr_family_birth_place'] = $this->input->post('box_family_birth_place');
        $data['hr_family_ktp'] = $this->input->post('box_family_ktp');
        $data['hr_family_job'] = $this->input->post('box_family_job');
        $data['hr_family_relation'] = $this->input->post('box_family_relation');
        $data['hr_family_pict'] = $this->input->post('box_family_pict');
        $data['hr_family_email'] = $this->input->post('box_family_email');
        $data['hr_family_id'] = $this->input->post('box_family_id');

        $id = $this->db->update('hr_family', $data, array('hr_family_id' => $this->input->post('box_family_id')));

        $this->log->insert("Mengupdate Employee " . $data['hr_family_nick_name'], $id, 'hr_family');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('hr_family', 'hr_family_id', $value);
            $id = $this->db->delete('hr_family', array('hr_family_id' => $value));

            $this->log->insert("Menghapus family " . $record->hr_family_nick_name, $id, 'hr_family');
        }
        echo 'ok';
    }

    public function status() {

        $data['sys_family_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('sys_family', 'sys_family_id', $value);
            $id = $this->db->update('sys_family', $data, array('sys_family_id' => $value));
            $this->log->insert("Update Status Group " . $detail->sys_family_name, $id, 'sys_family');
        }

        echo 'ok';
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('sys_family', 'sys_family_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_family', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_family', $output);
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

        $record = $this->query->get_detail('sys_family', 'sys_family_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_family', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('sys_family', 'sys_family_id', $id);

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
