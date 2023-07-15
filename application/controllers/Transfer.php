<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends CI_Controller {

  public $menu_aktif = 'transfer';

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_keluarga', 'wakil keluarga', 'required');
    $this->form_validation->set_rules('jenis_transfer', 'jenis transfer', 'required');
    $this->form_validation->set_rules('id_label_transfer', 'label transfer', 'required');
    $this->form_validation->set_rules('nominal', 'nominal', 'required');
  }

  public function index() {
    $label_transfers = $this->db->get('label_transfer')->result_array();
    $data_konten['label_transfers'] = $label_transfers;
    $data['konten'] = $this->load->view('transfer/index.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    // $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
  }

  public function tambah() {
    $data_konten = [];
    $data['konten'] = $this->load->view('transfer/tambah.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    // $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
  }

  public function proses_tambah() {

    $data_transfer = json_decode($this->input->raw_input_stream, true);
    $this->form_validation->set_data($data_transfer);
    $is_valid = $this->form_validation->run();
    
    if (!$is_valid) {
      $data['validasi'] = $this->form_validation->error_array();
      $data['pesan'] = 'masih ada inputan yang tidak valid';
      $this->output->set_status_header(400);
      echo json_encode($data);
      return;
    }
    date_default_timezone_set('Asia/Jakarta');

    if ($data_transfer['jenis_transfer'] == 'pengeluaran')
      $data_transfer['nominal'] = $data_transfer['nominal'] * -1;

    $data_transfer['waktu'] = date('Y-m-d H:i:s');
    $this->db->insert('transfer', $data_transfer);
    $data['pesan'] = 'data transfer berhasil ditambahkan';
    echo json_encode($data);
  }

  public function edit($id_transfer) {
    $data_transfer = $this->db
      ->select('transfer.*, wakil_keluarga, no_rumah, nama_blok, sub_blok, label_transfer')
      ->from('transfer')
      ->join('label_transfer', 'label_transfer.id_label_transfer = transfer.id_label_transfer')
      ->join('keluarga', 'keluarga.id_keluarga = transfer.id_keluarga')
      ->join('detail_blok', 'detail_blok.id_detail_blok = keluarga.id_detail_blok')
      ->join('blok', 'blok.id_blok = detail_blok.id_blok')
      ->where('id_transfer', $id_transfer)
      ->get()->row_array();

    $data_konten['data_transfer'] = $data_transfer;
    $data['konten'] = $this->load->view('transfer/edit.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    // $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
  }

  public function proses_edit($id_transfer) {
    $data_transfer = json_decode($this->input->raw_input_stream, true);
    $this->form_validation->set_data($data_transfer);
    $is_valid = $this->form_validation->run();
    if (!$is_valid) {
      $data['validasi'] = $this->form_validation->error_array();
      $data['pesan'] = 'masih ada inputan yang tidak valid';
      $this->output->set_status_header(400);
      echo json_encode($data);
      return;
    }

    $query = $this->db
      ->where('id_transfer', $id_transfer)
      ->update('transfer', $data_transfer);
    $data['pesan'] = 'data label transfer berhasil diubah';
    echo json_encode($data);
  }

  public function hapus($id_label_transfer) {
    $this->db->db_debug = FALSE;
    $query = $this->db
      ->where('id_label_transfer', $id_label_transfer)
      ->delete('label_transfer');

    $error_code = $this->db->error()['code'];
    if ($error_code == 1451) {  
      $this->session->set_flashdata('status', 'gagal');
      $this->session->set_flashdata('pesan', "masih terdapat transfer pada label transfer tersebut");
      redirect($_SERVER['HTTP_REFERER']);
      die();
    }
    $this->db->db_debug = TRUE;

    $this->session->set_flashdata('status', 'sukses');
    $this->session->set_flashdata('pesan', "data label transfer dengan id $id_label_transfer berhasil dihapus");
    
    redirect($_SERVER['HTTP_REFERER']);
  }

}