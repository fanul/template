<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Browse extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->session->userdata('username') == NULL)
            redirect('public/login', 'refresh');
    }

    public function index() {
        /*
          $this->load->helper('path');
          $opts = array(
          // 'debug' => true,
          'roots' => array(
          array(
          'driver' => 'LocalFileSystem',
          'path' => set_realpath('./document'),
          'URL' => site_url(site_url('document'))
          // more elFinder options here
          )
          )
          );
          $this->load->library('elfinder_lib', $opts);
         * 
         */
        $this->load->view('main_browse');
    }

    public function elfinder() {

        $this->load->helper('path');
        $opts = array(
            // 'debug' => true, 
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => set_realpath('./document'),
                    'URL' => site_url('document')
                // more elFinder options here
                )
            )
        );
        $this->load->library('elfinder_lib', $opts);

        /*
          $this->load->library('elfinder_lib');
          $conn = new elFinderConnector(new elFinder(array(
          'roots' => array(
          array(
          'driver' => 'LocalFileSystem',
          'path' => './document',
          'URL' => base_url('document') . '/',
          )
          )
          )));
          $conn->run();
         * 
         */
    }

    /*
      public function index() {
      $gridId = "tabel-browsecontrol";
      $searchId = "searchbrowsecontrol";
      $output['title'] = 'Data Master Group Control';

      $colModel['dc_browse_id'] = array('Id Group', 100, TRUE, 'center', 0, TRUE);
      $colModel['dc_browse_name'] = array('Nama Group', 100, TRUE, 'center', 1);
      $colModel['dc_browse_det'] = array('Detail', 100, TRUE, 'center', 1);

      $gridParams = array(
      'width' => 'auto',
      'height' => 250,
      'rp' => 10,
      'rpOptions' => '[10,20,30,40,50]',
      'pagestat' => 'Menampilkan: {from} sampai {to} dari {total} Track Type.',
      'blockOpacity' => 0.5,
      'showTableToggleBtn' => false,
      'singleSelect' => false,
      'hide' => 'true'
      );
      $buttons[] = array('Pilih Semua', 'add', 'databrowsecontrol');
      $buttons[] = array('Reset Pilihan', 'delete', 'databrowsecontrol');
      $buttons[] = array('separator');

      if ($this->acl->access('dc-browse-add'))
      $buttons[] = array('Tambah Data', 'add', 'databrowsecontrol');
      if ($this->acl->access('dc-browse-edit'))
      $buttons[] = array('Edit Data', 'edit', 'databrowsecontrol');
      if ($this->acl->access('dc-browse-delete'))
      $buttons[] = array('Hapus Data', 'delete', 'databrowsecontrol');

      // advanced search
      $params = '';
      /*
      if (isset($_POST['dc_browse_name']) && !is_null($_POST['dc_browse_name']) && $_POST['dc_browse_name'] != '') {
      $params .= 'dc_browse_name=' . $_POST['name_selector'] . '=' . $_POST['dc_browse_name'] . '&';
      $output['dc_browse_name'] = $_POST['dc_browse_name'];
      $output['collapsed'] = 1;
      }
      if (isset($_POST['dc_browse_detail']) && !is_null($_POST['dc_browse_detail']) && $_POST['dc_browse_detail'] != '') {
      $params .= 'dc_browse_detail=' . $_POST['detail_selector'] . '=' . $_POST['dc_browse_detail'] . '&';
      $output['dc_browse_detail'] = $_POST['dc_browse_detail'];
      $output['collapsed'] = 1;
      }
      $param = substr($params, 0, -1);
     */

    // coloring
    /*
      $gridColor['index'] = 3;
      $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');


      $site = site_url("dc/browse/datatable/" . $params);

      $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
      $grid_js = build_grid_js($gridId, $site, $colModel, 'dc_browse_id', 'asc', $gridParams, $buttons, $onsubmit);

      $output['js_grid'] = $grid_js;


      if (isset($_POST['nocache'])) {

      if (isset($_POST['name_selector']))
      $output['name_selector'] = $_POST['name_selector'];

      if (isset($_POST['detail_selector']))
      $output['detail_selector'] = $_POST['detail_selector'];

      $this->load->view('main_browse', $output);
      }
      else
      redirect(base_url(), 'refresh');
      }
     */
    public function datatable($param = NULL) {
        $valid_fields = array('dc_browse_name', 'dc_browse_det');
        $this->flexigrid->validate_post('dc_browse_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('dc_browse', 'dc_browse_id', $param);

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
            $record_items[] = array($row->dc_browse_id, $row->dc_browse_id, $row->dc_browse_name, $row->dc_browse_det);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $output['title'] = 'Tambah Track Type';
        $output['browsecontrol'] = '';
        $output['tombol'] = 'Tambah';
        $output['kode_disable'] = '';
        $output['form'] = '';
        $output['send_url'] = site_url("dc/browse/add");
        //$output['karyawan_nik'] = $this->generate_nik();
        $this->load->view('form_browse', $output);
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('dc_browse', 'dc_browse_id', $id);
        $output['title'] = 'Edit Group';

        $output['dc_browse_id'] = $record->dc_browse_id;
        $output['dc_browse_name'] = $record->dc_browse_name;
        $output['dc_browse_det'] = $record->dc_browse_det;

        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'dc_browse_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("dc/browse/edit");
        $this->load->view('form_browse', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('dc_browse', 'dc_browse_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("dc/browse/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('dc_browse', 'dc_browse_id', $value);
            $text .= 'nama: ' . $detail->dc_browse_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-browsecontrol").flexReload();';
        $output['send_url'] = site_url("dc/browse/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('dc_browse', 'dc_browse_id', $value);
            $text .= 'nama: ' . $detail->dc_browse_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-browsecontrol").flexReload();';
        $output['send_url'] = site_url("dc/browse/status");
        $this->load->view('form_change', $output);
    }

    public function add() {

        $data['dc_browse_name'] = $this->input->post('box_browse_name');
        $data['dc_browse_det'] = $this->input->post('box_browse_det');

        $id = $this->db->insert('dc_browse', $data);

        $this->log->insert("Menambahkan Track Type " . $data['dc_browse_name'], $id, 'dc_browse');

        echo 'ok';
    }

    public function edit() {

        $data['dc_browse_name'] = $this->input->post('box_browse_name');
        $data['dc_browse_det'] = $this->input->post('box_browse_det');


        $id = $this->db->update('dc_browse', $data, array('dc_browse_id' => $this->input->post('box_browse_id')));

        $this->log->insert("Mengedit Track Type " . $data['dc_browse_name'], $id, 'dc_browse');

        echo 'ok';
    }

    public function delete() {
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $record = $this->query->get_detail('dc_browse', 'dc_browse_id', $value);
            $id = $this->db->delete('dc_browse', array('dc_browse_id' => $value));

            $this->log->insert("Menghapus Group " . $record->dc_browse_name, $id, 'dc_browse');
        }
        echo 'ok';
    }

    public function status() {

        $data['dc_browse_status'] = $this->input->post('wfstatus_change');
        $str = $this->input->post('items');

        $text = '';
        $items = explode('|', substr($str, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('dc_browse', 'dc_browse_id', $value);
            $id = $this->db->update('dc_browse', $data, array('dc_browse_id' => $value));
            $this->log->insert("Update Status Group " . $detail->dc_browse_name, $id, 'dc_browse');
        }

        echo 'ok';
    }

    public function popup($id) {
        $output['url'] = site_url('dc\browse\cetak_individu_pdf' . '\\' . $id);
        $this->load->view('popup', $output);
    }

    public function printing($id) {
        $params = explode('PRINTING', $id);
        if (count($params) > 1) {
            $via = $this->my_encrypt->decode($params[1]);
            $id = $this->my_encrypt->decode($params[0]);

            $record = $this->query->get_detail('dc_browse', 'dc_browse_id', $id);
            $output['data'] = $record;
            $output['id'] = $id;

            switch ($via) {
                case 'Web':
                    $this->load->view('print\print_browse', $output);
                    break;
                case 'Web - Auto Print':
                    $output['auto'] = true;
                    $this->load->view('print\print_browse', $output);
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

        $record = $this->query->get_detail('dc_browse', 'dc_browse_id', $id);
        $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_browse', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('dc_browse', 'dc_browse_id', $id);

        $this->load->library('pxl');
        $laporan = new PHPExcel();
        $laporan->getProperties()->setTitle("Daftar Pelanggaran Karyawan")->setDescription("Laporan");
        $laporan->setActiveSheetIndex(0);
        $worksheet1 = 'Daftar ';
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
