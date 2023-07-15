<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Label_Transfer extends CI_Controller {

  public $menu_aktif = 'label_transfer';

  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->form_validation->set_rules('label_transfer', 'label transfer', 'required');
  }

  public function index() {
    $label_transfers = $this->db->get('label_transfer')->result_array();
    $data_konten['label_transfers'] = $label_transfers;
    $data['konten'] = $this->load->view('label_transfer/index.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    // $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
  }

  public function tambah() {
    // $data_konten['label_transfers'] = $label_transfers;
    $data_konten = [];
    $data['konten'] = $this->load->view('label_transfer/tambah.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    // $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
  }

  public function proses_tambah() {
    $is_valid = $this->form_validation->run();
    if (!$is_valid) {
      $data['validasi'] = $this->form_validation->error_array();
      $data['pesan'] = 'masih ada inputan yang tidak valid';
      $this->output->set_status_header(400);
      echo json_encode($data);
      return;
    }
    $dataLabelTransfer = [
      'label_transfer' => $this->input->post('label_transfer')
    ];
    $this->db->insert('label_transfer', $dataLabelTransfer);
    $data['pesan'] = 'data label transfer berhasil ditambahkan';
    echo json_encode($data);
  }

  public function edit($id_label_transfer) {
    $data_transfer = $this->db
      ->where('id_label_transfer', $id_label_transfer)
      ->get('label_transfer')->row_array();
    $data_konten['data_transfer'] = $data_transfer;
    $data['konten'] = $this->load->view('label_transfer/edit.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    // $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
  }

  public function proses_edit($id_label_transfer) {
    $is_valid = $this->form_validation->run();
    if (!$is_valid) {
      $data['validasi'] = $this->form_validation->error_array();
      $data['pesan'] = 'masih ada inputan yang tidak valid';
      $this->output->set_status_header(400);
      echo json_encode($data);
      return;
    }
    $dataLabelTransfer = [
      'label_transfer' => $this->input->post('label_transfer')
    ];

    $query = $this->db
      ->where('id_label_transfer', $id_label_transfer)
      ->update('label_transfer', $dataLabelTransfer);
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