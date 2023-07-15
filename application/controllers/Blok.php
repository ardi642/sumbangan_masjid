<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blok extends CI_Controller {

  public $menu_aktif = 'blok';

  public function __construct() {
      parent::__construct();
      // $this->load->library('form_validation');
      // $this->load->model('M_mahasiswa');
  }

  public function index() {

    $bloks = $this->db->get('blok')->result_array();
    $columns = (count($bloks) > 0) ? array_keys($bloks[0]) : [];
    $data_konten['bloks'] = $bloks;
    $data_konten['columns'] = $columns;
    $data_konten['flashdata'] = $this->session->flashdata();
    $data['konten'] = $this->load->view('blok/index.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('blok/index.js', null, TRUE);

    $this->load->view('template', $data);
    // var_dump($nama_blok);
    

  }

  public function tambah() {
    $this->form_validation->set_rules('nama_blok', 'Blok Rumah', 
    'required|is_unique[blok.nama_blok]');
    $validasi = $this->form_validation->run();

    // jika ada data yang dikirim dan validasinya benar
    if (count($_POST) > 0 AND $validasi) {
      $this->db->trans_begin();

      $data['nama_blok'] = $this->input->post('nama_blok');
      $result1 = $this->db->insert('blok', $data);

      $id_blok = $this->db->insert_id();

      $result2 = $this->db->insert('detail_blok', [
        'id_blok' => $id_blok,
        'sub_blok' => ''
      ]);
      if (!$result1 OR !$result2) {
        $this->db->trans_rollback();
        $error_message = $this->db->error()['message'];
        echo "Error Database : <br> {$error_message}";
        exit();
      }
      $this->db->trans_commit();
      $this->session->set_flashdata('status', 'berhasil');
      $this->session->set_flashdata('nama_blok', $data['nama_blok']);
      redirect(base_url( uri_string() ));
      exit();
    }

    $data_konten['flashdata'] = $this->session->flashdata();
    $data['konten'] = $this->load->view('blok/tambah', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('blok/tambah.js', null, TRUE);

    $this->load->view('template', $data);
    // var_dump($nama_blok);
    

  }

  public function edit($id_blok) {
    $this->form_validation->set_rules('nama_blok', 'Blok Rumah', 
    'required|is_unique[blok.nama_blok]');
    $validasi = $this->form_validation->run();

    $nama_blok = $this->db->get_where('blok', ['id_blok' => $id_blok])
              ->row_array()['nama_blok'];

    // jika ada data yang dikirim dan validasinya benar
    if (count($_POST) > 0 AND $validasi) {
      $data['nama_blok'] = $this->input->post('nama_blok');

      $this->db->where('id_blok', $id_blok);
      $result = $this->db->update('blok', $data);
      if (!$result) {
        $error_message = $this->db->error()['message'];
        echo "Error Database : <br> {$error_message}";
        exit();
      }
      $this->session->set_flashdata('status', 'berhasil');
      $this->session->set_flashdata('nama_blok_awal', $nama_blok);
      redirect(base_url( uri_string() ));
      exit();
    }

    $data_konten['status'] = $this->session->flashdata('status');
    $data_konten['nama_blok_awal'] = $this->session->flashdata('nama_blok_awal');
    $data_konten['nama_blok_sekarang'] = $nama_blok;
    $data['konten'] = $this->load->view('blok/edit', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('blok/edit.js', null, TRUE);

    $this->load->view('template', $data);
    // var_dump($nama_blok);
    

  }

  public function hapus($id_blok) {
    $this->db->db_debug = FALSE;
    $nama_blok = $this->db->get_where('blok', ['id_blok' => $id_blok])
    ->row_array()['nama_blok'];
    $this->db->where('id_blok', $id_blok);
    $result = $this->db->delete('blok');
    $error_message = $this->db->error()['message'];
    $error_code = $this->db->error()['code'];

    $this->db->db_debug = TRUE;


    if ($error_code == 1451) {
      $this->session->set_flashdata('status', 'gagal');
      $this->session->set_flashdata('nama_blok', $nama_blok);
      redirect('/blok');
      exit();
    }

    if (!$result) {
      
      echo "Error Database : <br> {$error_message}";
      exit();
    }

    $this->session->set_flashdata('status', 'berhasil');
    $this->session->set_flashdata('nama_blok', $nama_blok);
    redirect('/blok');
  }
}
