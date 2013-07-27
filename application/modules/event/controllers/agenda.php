<?php

if (!defined('BASEPATH'))
    exit('No Direct Script Allowed');

class Agenda extends CI_Controller {

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
          $this->load->view('main_agenda');
      }

      public function manage() {
        $gridId = "tabel-agendacontrol";
        $searchId = "searchagendacontrol";
        $output['title'] = 'Data Master Agenda Control';

        $colModel['agenda_id'] = array('Id Group', 100, TRUE, 'center', 0, TRUE);
        $colModel['event_type_name'] = array('Tipe Agenda', 100, TRUE, 'center', 1);
        $colModel['agenda_name'] = array('Nama Agenda', 100, TRUE, 'center', 1);
        $colModel['agenda_det'] = array('Detail', 100, TRUE, 'center', 1);
        $colModel['agenda_start_date'] = array('Mulai', 100, TRUE, 'center', 1);
        $colModel['agenda_end_date'] = array('Berakhir', 100, TRUE, 'center', 1);
        $colModel['agenda_cost'] = array('Biaya', 100, TRUE, 'center', 1);

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
        $buttons[] = array('Pilih Semua', 'add', 'dataagendacontrol');
        $buttons[] = array('Reset Pilihan', 'delete', 'dataagendacontrol');
        $buttons[] = array('separator');


        $buttons[] = array('Tambah Data', 'add', 'dataagendacontrol');

        $buttons[] = array('Edit Data', 'edit', 'dataagendacontrol');

        $buttons[] = array('Hapus Data', 'delete', 'dataagendacontrol');

        // advanced search
        $params = '';
        /*
          if (isset($_POST['agenda_name']) && !is_null($_POST['agenda_name']) && $_POST['agenda_name'] != '') {
          $params .= 'agenda_name=' . $_POST['name_selector'] . '=' . $_POST['agenda_name'] . '&';
          $output['agenda_name'] = $_POST['agenda_name'];
          $output['collapsed'] = 1;
          }
          if (isset($_POST['agenda_detail']) && !is_null($_POST['agenda_detail']) && $_POST['agenda_detail'] != '') {
          $params .= 'agenda_detail=' . $_POST['detail_selector'] . '=' . $_POST['agenda_detail'] . '&';
          $output['agenda_detail'] = $_POST['agenda_detail'];
          $output['collapsed'] = 1;
          }
          $param = substr($params, 0, -1);
         */

        // coloring
        /*
          $gridColor['index'] = 3;
          $gridColor['condition'] = array('Suspend'=>'black','Idle'=>'green');
         */

          $site = site_url("event/agenda/datatable/" . $params);

          $onsubmit = 'function(){$("#' . $gridId . '").flexOptions({params: [{name:"callId", value:"' . $gridId . '"}].concat($("#' . $searchId . '").serializeArray())});return true}';
          $grid_js = build_grid_js($gridId, $site, $colModel, 'agenda_id', 'asc', $gridParams, $buttons, $onsubmit);

          $output['js_grid'] = $grid_js;

          if (isset($_POST['name_selector']))
            $output['name_selector'] = $_POST['name_selector'];

        if (isset($_POST['detail_selector']))
            $output['detail_selector'] = $_POST['detail_selector'];

        $this->load->view('main_manage_agenda', $output);
    }

    public function datatable($param = NULL) {
        $valid_fields = array('event_type_name', 'agenda_name', 'agenda_det', 'agenda_start_date_indo',
            'agenda_end_date_indo', 'agenda_cost');
        $this->flexigrid->validate_post('agenda_id', 'desc', $valid_fields);
        $records = $this->query->get_list_table('v_agenda', 'agenda_id', $param);

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
            $record_items[] = array($row->agenda_id, $row->agenda_id,
                $row->event_type_name, $row->agenda_name, $row->agenda_det, $row->agenda_start_date_indo,
                $row->agenda_end_date_indo, $row->agenda_cost);
        }

        $this->output->set_output($this->flexigrid->json_build($records['record_count'], $record_items));
    }

    public function prepare_add() {
        $header = getallheaders();
        if (isset($header['AJAX'])) {
            $output['title'] = 'Tambah Track Type';
            $output['agendacontrol'] = '';
            $output['tombol'] = 'Tambah';
            $output['kode_disable'] = '';
            $output['form'] = '';
            $output['send_url'] = site_url("event/agenda/add");
            //$output['karyawan_nik'] = $this->generate_nik();
            $this->load->view('form_agenda2', $output);
        }
        else
            redirect(base_url());
    }

    public function prepare_edit() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('v_agenda', 'agenda_id', $id);
        $output['title'] = 'Edit Group';

        $output['agenda_id'] = $record->agenda_id;
        $output['event_type_id'] = $record->event_type_id;
        $output['agenda_name'] = $record->agenda_name;
        $output['agenda_det'] = $record->agenda_det;
        $output['agenda_start_date_indo'] = $record->agenda_start_date_indo;
        $output['agenda_end_date_indo'] = $record->agenda_end_date_indo;
        $output['agenda_cost'] = $record->agenda_cost;


        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Update';
        $output['form'] = form_input(array('name' => 'agenda_id_old', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("event/agenda/edit");
        $this->load->view('form_agenda', $output);
    }

    public function prepare_print() {
        $id = $this->input->post('id');
        $record = $this->query->get_detail('agenda', 'agenda_id', $id);
        $output['title'] = 'Printing Group';
        $output['data_master'] = 'print_type_encrypt';
        $output['kode_disable'] = 'disabled';
        $output['tombol'] = 'Print';
        $output['form'] = form_input(array('id' => 'print_id', 'name' => 'print_id', 'value' => $id, 'type' => 'hidden'));
        $output['send_url'] = site_url("dc/agenda/printing/" . $this->my_encrypt->encode($id));
        $this->load->view('form_print', $output);
    }

    public function prepare_delete() {

        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('agenda', 'agenda_id', $value);
            $text .= 'nama: ' . $detail->agenda_name . '<br>';
        }

        $output['text'] = $text;
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-agendacontrol").flexReload();';
        $output['send_url'] = site_url("event/agenda/delete");
        $this->load->view('form_delete', $output);
    }

    public function prepare_status() {
        $id = $this->input->post('ids');

        $text = '';
        $items = explode('|', substr($id, 0, -1));

        foreach ($items as $item => $value) {
            $detail = $this->query->get_detail('agenda', 'agenda_id', $value);
            $text .= 'nama: ' . $detail->agenda_name . '<br>';
        }

        $output['text'] = $text;
        $output['data_master'] = 'change_status';
        $output['form'] = form_input(array(
            'name' => 'items',
            'id' => 'items',
            'value' => $id,
            'type' => 'hidden'));
        $output['function'] = '$("#tabel-agendacontrol").flexReload();';
        $output['send_url'] = site_url("event/agenda/status");
        $this->load->view('form_change', $output);
    }

    public function add() {

        if(!isset($_POST['box_is_forever']))
            $data['agenda_end_date'] = date_format(date_create($this->input->post('box_agenda_end_date_indo')), 'Y-m-d');

        $data['agenda_start_date'] = date_format(date_create($this->input->post('box_agenda_start_date_indo')), 'Y-m-d');
        $data['agenda_start_time'] = $this->input->post('box_agenda_start_time');
        $data['agenda_end_time'] = $this->input->post('box_agenda_end_time');


        $data['event_type_id'] = $this->input->post('box_event_type_id');
        $data['agenda_name'] = $this->input->post('box_agenda_name');
        $data['agenda_det'] = $this->input->post('box_agenda_det');
        $data['agenda_cost'] = $this->input->post('box_agenda_cost');
        $data['sys_user_id'] = $this->session->userdata('sys_user_id');

        $repeat['hari'] ='';
        $repeat['minggu'] = '';
        $repeat['bulan'] = '';
        $repeat['tahun'] = '';

        if(isset($_POST['box_agenda_repeat']) && $_POST['box_agenda_repeat']!='')
        {
            $every = $this->input->post('box_agenda_repeat');

            if($every=='hari')
            {
                $repeat['hari'] = $this->input->post('box_agenda_freq');
            }
            else if($every=='minggu')
            {
                $repeat['minggu'] = $this->input->post('box_agenda_freq');
            }
            else if($every=='bulan')
            {
                $repeat['bulan'] = $this->input->post('box_agenda_freq');
            }            
            else if($every=='tahun')
            {
                $repeat['tahun'] = $this->input->post('box_agenda_freq');
            }
            $data['agenda_repeat'] = $every;
        }

        $data['agenda_repeat_desk'] = json_encode($repeat);
        $data['agenda_occurrence_desk'] = $this->input->post('box_repeat_int');

        
        if(isset($_POST['box_is_forever']))
            $data['agenda_occurrence'] = 'selamanya';
        else if(isset($_POST['box_is_repeat_t']))
           $data['agenda_occurrence'] = 'sampai-tanggal';        
       else if(isset($_POST['box_is_repeat_n']))
        $data['agenda_occurrence'] = 'n-kali';

    $id = $this->db->insert('agenda', $data);

    $this->log->insert("Menambahkan Track Type " . $data['agenda_name'], $id, 'agenda');

        //print_r($data);
    echo 'ok';
}

public function edit() {

 if(!isset($_POST['box_is_forever']))
    $data['agenda_end_date'] = date_format(date_create($this->input->post('box_agenda_end_date_indo')), 'Y-m-d');

$data['agenda_start_date'] = date_format(date_create($this->input->post('box_agenda_start_date_indo')), 'Y-m-d');
$data['agenda_start_time'] = $this->input->post('box_agenda_start_time');
$data['agenda_end_time'] = $this->input->post('box_agenda_end_time');


$data['event_type_id'] = $this->input->post('box_event_type_id');
$data['agenda_name'] = $this->input->post('box_agenda_name');
$data['agenda_det'] = $this->input->post('box_agenda_det');
$data['agenda_cost'] = $this->input->post('box_agenda_cost');
$data['sys_user_id'] = $this->session->userdata('sys_user_id');

$repeat['hari'] ='';
$repeat['minggu'] = '';
$repeat['bulan'] = '';
$repeat['tahun'] = '';

if(isset($_POST['box_agenda_repeat']) && $_POST['box_agenda_repeat']!='')
{
    $every = $this->input->post('box_agenda_repeat');

    if($every=='hari')
    {
        $repeat['hari'] = $this->input->post('box_agenda_freq');
    }
    else if($every=='minggu')
    {
        $repeat['minggu'] = $this->input->post('box_agenda_freq');
    }
    else if($every=='bulan')
    {
        $repeat['bulan'] = $this->input->post('box_agenda_freq');
    }            
    else if($every=='tahun')
    {
        $repeat['tahun'] = $this->input->post('box_agenda_freq');
    }
    $data['agenda_repeat'] = $every;
}

$data['agenda_repeat_desk'] = json_encode($repeat);
$data['agenda_occurrence_desk'] = $this->input->post('box_repeat_int');


if(isset($_POST['box_is_forever']))
    $data['agenda_occurrence'] = 'selamanya';
else if(isset($_POST['box_is_repeat_t']))
   $data['agenda_occurrence'] = 'sampai-tanggal';        
else if(isset($_POST['box_is_repeat_n']))
    $data['agenda_occurrence'] = 'n-kali';

$id = $this->db->update('agenda', $data, array('agenda_id' => $this->input->post('box_agenda_id')));

$this->log->insert("Mengedit Track Type " . $data['agenda_name'], $id, 'agenda');

echo 'ok';
}

public function delete() {
    $str = $this->input->post('items');

    $text = '';
    $items = explode('|', substr($str, 0, -1));

    foreach ($items as $item => $value) {
        $record = $this->query->get_detail('agenda', 'agenda_id', $value);
        $id = $this->db->delete('agenda', array('agenda_id' => $value));

        $this->log->insert("Menghapus Group " . $record->agenda_name, $id, 'agenda');
    }
    echo 'ok';
}

public function status() {

    $data['agenda_status'] = $this->input->post('wfstatus_change');
    $str = $this->input->post('items');

    $text = '';
    $items = explode('|', substr($str, 0, -1));

    foreach ($items as $item => $value) {
        $detail = $this->query->get_detail('agenda', 'agenda_id', $value);
        $id = $this->db->update('agenda', $data, array('agenda_id' => $value));
        $this->log->insert("Update Status Group " . $detail->agenda_name, $id, 'agenda');
    }

    echo 'ok';
}

public function popup($id) {
    $output['url'] = site_url('dc\agenda\cetak_individu_pdf' . '\\' . $id);
    $this->load->view('popup', $output);
}

public function printing($id) {
    $params = explode('PRINTING', $id);
    if (count($params) > 1) {
        $via = $this->my_encrypt->decode($params[1]);
        $id = $this->my_encrypt->decode($params[0]);

        $record = $this->query->get_detail('agenda', 'agenda_id', $id);
        $output['data'] = $record;
        $output['id'] = $id;

        switch ($via) {
            case 'Web':
            $this->load->view('print\print_agenda', $output);
            break;
            case 'Web - Auto Print':
            $output['auto'] = true;
            $this->load->view('print\print_agenda', $output);
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

    $record = $this->query->get_detail('agenda', 'agenda_id', $id);
    $output['data'] = $record;
        $file_pdf = $this->load->view('print\print_agenda', $output, TRUE); //Save as variable
        pdf_create($file_pdf, 'Printing');
    }

    public function printing_excel($id) {
        $record = $this->query->get_detail('agenda', 'agenda_id', $id);

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

    function generate_event($input) {
        $output = array(
            'id' => $input->agenda_id,
            'title' => $input->agenda_name,
            'start' => $input->agenda_start_date,
            'end' => $input->agenda_end_date,
            'allDay' => false,
        //'allDay' => ($input->allDay) ? true : false,
        //'className' => "cat{$repeats}",
        //'editable' => true,
            'repeat_i' => $input->agenda_repeat_int,
            'repeat_f' => $input->agenda_repeat_freq,
            'repeat_e' => $input->agenda_repeat_end
            );

        return $output;
    }

    function get_agenda_event($start, $end) {


     $query = "SELECT * from v_agenda WHERE
     (
        (agenda_start_date >= '$start' AND agenda_end_date < '$end') OR
        (agenda_end_date >= '$start' AND agenda_end_date < '$end') OR
        (agenda_start_date <= '$start' AND agenda_end_date >= '$end') OR
        (agenda_start_date >= '$start' AND agenda_start_date <= '$end' AND agenda_end_date >= '$start') OR
        (agenda_start_date < '$end' AND agenda_repeat !='' AND (agenda_end_date='' OR ISNULL(agenda_end_date)))
        )
ORDER BY agenda_start_date;
";
return $this->db->query($query)->result();
}

public function process_events($events, $start, $end, $readonly=null)
{
    if ($events) {
        $output = array();
        foreach ($events as $event) {
            $event->agenda_view_start = $start;
            $event->agenda_view_end = $end;
            $event = $this->process_event($event, $readonly, true);
            if (is_array($event)) {
                foreach ($event as $repeat) {
                    array_push($output, $repeat);
                }
            } else {
                array_push($output, $event);
            }
        }
        $this->render_json($output);
        return $output;
    }        
}

function process_event($input, $readonly = false, $queue = false) {
    $output = array();
    if ($repeats = $this->generate_repeating_event($input)) {
        foreach ($repeats as $repeat) {
            array_push($output, $this->generate_event($repeat));
        }
    } else {
        if($input->agenda_repeat=='')
        {
            $input->agenda_start_date = $input->agenda_start_date.' '.$input->agenda_start_time;
            $input->agenda_end_date = $input->agenda_end_date.' '.$input->agenda_end_time;
            array_push($output, $this->generate_event($input));
        }
    }
    return $output;
    //$this->render_json($output);
}

function generate_repeating_event($event) {

    $repeat_desk = json_decode($event->agenda_repeat_desk);

    if ($event->agenda_repeat == "hari") {
        $event->agenda_repeat_int =0;
        $event->agenda_repeat_freq = $repeat_desk->hari;
    }
    if ($event->agenda_repeat == "bulan") {
        $event->agenda_repeat_int =2;        
        $event->agenda_repeat_freq = $repeat_desk->bulan;
    }
    if ($event->agenda_repeat == "minggu") {
        $event->agenda_repeat_int =1;                
        $event->agenda_repeat_freq = $repeat_desk->minggu;
    }
    if ($event->agenda_repeat == "tahun") {
        $event->agenda_repeat_int =3;                        
        $event->agenda_repeat_freq = $repeat_desk->tahun;
    }

    if ($event->agenda_occurrence == "n-kali") {
        if($event->agenda_repeat_int == 0){
            $ext = "days";
        }
        if($event->agenda_repeat_int == 1){
            $ext = "weeks";
        }
        if($event->agenda_repeat_int == 2){
            $ext = "months";
        }
        if($event->agenda_repeat_int == 3){
            $ext = "years";
        }
        $event->agenda_repeat_end =  date('Y-m-d',strtotime("+" . $event->agenda_occurrence_desk*$event->agenda_repeat_freq . " ".$ext));
    } else if ($event->agenda_occurrence == "selamanya") {
        $event->agenda_repeat_end = "2111-11-11";
    } else if ($event->agenda_occurrence == "sampai-tanggal") {
        $event->agenda_repeat_end = $event->agenda_end_date;
    }

    if ($event->agenda_repeat_freq) {
        $event_start = strtotime($event->agenda_start_date.' '.$event->agenda_start_time);
        $event_duration = strtotime($event->agenda_start_date.' '.$event->agenda_end_time);
        $event_end = strtotime($event->agenda_end_date.' '.$event->agenda_end_time);
        $repeat_end = strtotime($event->agenda_repeat_end) + 86400;
        $view_start = strtotime($event->agenda_view_start);
        $view_end = strtotime($event->agenda_view_end);

        $repeats = array();

        while ($event_start < $repeat_end) {
            if ($event_start >= $view_start && $event_start <= $view_end) {
                $event = clone $event; // clone event details and override dates
                $event->agenda_start_date = date('Y-m-d H:i:s', $event_start);
                $event->agenda_end_date = date('Y-m-d H:i:s', $event_duration);
                array_push($repeats, $event);
            }
            $event_start = $this->get_next_date($event_start, $event->agenda_repeat_freq, $event->agenda_repeat_int);
            $event_duration= $this->get_next_date($event_duration, $event->agenda_repeat_freq, $event->agenda_repeat_int);
        }
        return $repeats;
    }
    return false;
}

function get_next_date($date, $freq, $int) {
    if ($int == 0)
        return strtotime("+" . $freq . " days", $date);
    if ($int == 1)
        return strtotime("+" . $freq . " weeks", $date);
    if ($int == 2)
        return get_next_month($date, $freq);
    if ($int == 3)
        return get_next_year($date, $freq);
}

function get_next_month($date, $n = 1) {
    $newDate = strtotime("+{$n} months", $date);
    // adjustment for events that repeat on the 29th, 30th and 31st of a month
    if (date('j', $date) !== (date('j', $newDate))) {
        $newDate = strtotime("+" . $n + 1 . " months", $date);
    }
    return $newDate;
}

function get_next_year($date, $n = 1) {
    $newDate = strtotime("+{$n} years", $date);
    // adjustment for events that repeat on february 29th
    if (date('j', $date) !== (date('j', $newDate))) {
        $newDate = strtotime("+" . $n + 3 . " years", $date);
    }
    return $newDate;
}

function render_json($output) {
    header("Content-Type: application/json");
    echo json_encode($this->cleanse_output($output));
}


function cleanse_output($output) {
    if (is_array($output)) {
        array_walk_recursive($output, create_function('&$val', '$val = trim(stripslashes($val));'));
    } else {
        $output = stripslashes($output);
    }
    return $output;
}

function parse_json($output)
{
    print_r($output);
    return str_replace('][', ',', $json);
}

public function get_basic($start, $end) {
    $query = "select * from v_agenda 
    where agenda_start_date >= '$start' and agenda_start_date <= '$end'";
    return $this->db->query($query)->result();
}

function get_agenda_alt($start, $end) {

    $query = "SELECT * from v_agenda WHERE
    (
        (agenda_start_date >= '$start' AND agenda_start_date <= '$end') AND
        (agenda_end_date >= '$start') OR
        (agenda_start_date<= '$end' AND agenda_repeat<>'' AND (agenda_end_date='' OR ISNULL(agenda_end_date)))
        )
ORDER BY agenda_start_date;
";
return $this->db->query($query)->result();
}

public function generate_calendar_json() {

    $start = date('Y-m-d', $this->input->post('start'));
    $end = date('Y-m-d', $this->input->post('end'));

        //echo $start.' - '.$end;

    $record = $this->get_agenda_event($start, $end);
    $this->process_events($record, $start, $end);
     //   echo $this->db->last_query();
        //$record = $this->query->get_list_basic('v_agenda');
        //print_r($record);


        // $record = $this->get_agenda_alt($start, $end);
        // $json = array();
        // foreach ($record as $item) {
        //     $json[] = array(
        //         'id' => $item->agenda_id,
        //         'title' => $item->agenda_name,
        //         'start' => $item->agenda_start_date.' '.$item->agenda_start_time,
        //         'end' => $item->agenda_end_date.' '.$item->agenda_end_time,
        //         'allDay' => false,
        //     );
        // }

        // header("Content-Type: application/json");
        // echo json_encode($json);
}

}

?>
