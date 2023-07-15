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
    $tanggal_dari = $this->input->post('tanggal_dari') ?? '';
    $tanggal_sampai = $this->input->post('tanggal_sampai') ?? '';
    $jenis_transfer = $this->input->post('jenis_transfer') ?? '';
    $id_label_transfer = $this->input->post('id_label_transfer') ?? '';
    $label_transfer = $this->input->post('label_transfer') ?? '';

    $query = $this->db->select('transfer.*, wakil_keluarga, no_rumah, 
    nama_blok, sub_blok, label_transfer')
      ->from('transfer')
      ->join('keluarga', 'keluarga.id_keluarga = transfer.id_keluarga')
      ->join('label_transfer', 'label_transfer.id_label_transfer = transfer.id_label_transfer')
      ->join('detail_blok', 'detail_blok.id_detail_blok = keluarga.id_detail_blok')
      ->join('blok', 'blok.id_blok = detail_blok.id_blok');

      if ($tanggal_dari != '')
        $query->where('Date(waktu) >=', $tanggal_dari);
      
      if ($tanggal_sampai != '')
        $query->where('Date(waktu) <=', $tanggal_sampai);

      if ($jenis_transfer != '')
        $query->where('jenis_transfer', $jenis_transfer);
      
      if ($id_label_transfer != '')
        $query->where('transfer.id_label_transfer', $id_label_transfer);

      $transfers = $query->get()->result_array();

    $query_total_nominal = $this->db->select_sum('nominal');
    if ($tanggal_dari != '')
        $query_total_nominal->where('Date(waktu) >=', $tanggal_dari);
      
    if ($tanggal_sampai != '')
      $query_total_nominal->where('Date(waktu) <=', $tanggal_sampai);

    if ($jenis_transfer != '')
      $query_total_nominal->where('jenis_transfer', $jenis_transfer);
    
    if ($id_label_transfer != '')
      $query_total_nominal->where('transfer.id_label_transfer', $id_label_transfer);
    
    $total_nominal = $query_total_nominal->get('transfer')->row_array()['nominal'];
    
    $data_konten['transfers'] = $transfers;
    $data_konten['tanggal_dari'] = $tanggal_dari;
    $data_konten['tanggal_sampai'] = $tanggal_sampai;
    $data_konten['jenis_transfer'] = $jenis_transfer;
    $data_konten['id_label_transfer'] = $id_label_transfer;
    $data_konten['label_transfer'] = $label_transfer;
    $data_konten['total_nominal'] = $total_nominal;
    
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

    if ($data_transfer['jenis_transfer'] == 'pengeluaran') {
      $data_transfer['nominal'] = $data_transfer['nominal'] * -1;
    }

    $query = $this->db
      ->where('id_transfer', $id_transfer)
      ->update('transfer', $data_transfer);
    $data['pesan'] = 'data transfer berhasil diubah';
    echo json_encode($data);
  }

  public function hapus($id_transfer) {
    $query = $this->db
      ->where('id_transfer', $id_transfer)
      ->delete('transfer');

    $this->session->set_flashdata('status', 'sukses');
    $this->session->set_flashdata('pesan', "data transfer dengan id transfer $id_transfer berhasil dihapus");
    
    redirect($_SERVER['HTTP_REFERER']);
  }

}