<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluarga extends CI_Controller {

  public $menu_aktif = 'keluarga';

  public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->model('M_mahasiswa');
  }

  public function index() {

    $keluargas = $this->db->select('id_keluarga, wakil_keluarga, nama_blok, sub_blok, no_rumah')
              ->from('keluarga')
              ->join('detail_blok', 'keluarga.id_detail_blok = detail_blok.id_detail_blok')
              ->join('blok', 'detail_blok.id_blok = blok.id_blok')
              ->get()
              ->result_array();
    $columns = (count($keluargas) > 0) ? array_keys($keluargas[0]) : [];
    $data_konten['keluargas'] = $keluargas;
    $data_konten['columns'] = $columns;
    $data_konten['flashdata'] = $this->session->flashdata();
    $data['konten'] = $this->load->view('keluarga/index.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('keluarga/index.js', null, TRUE);

    $this->load->view('template', $data);

  }

  public function tambah() {

    // jika ada data yang dikirim dan validasinya benar
    if (count($_POST) > 0 ) {
      $this->db->db_debug = FALSE;

      $data = $this->input->post();
      unset($data['id_blok']);
      $result = $this->db->insert('keluarga', $data);
      $error_message = $this->db->error()['message'];
      $error_code = $this->db->error()['code'];

      $this->db->db_debug = TRUE;

      if ($error_code == 1062) {
        $this->session->set_flashdata('status', 'gagal');
        redirect(base_url( uri_string() ));
        exit();  
      }

      if (!$result) {
        $error_message = $this->db->error()['message'];
        echo "Error Database : <br> {$error_message}";
        exit();
      }
      $this->session->set_flashdata('status', 'berhasil');
      redirect(base_url( uri_string() ));
      exit();
    }

    $data_konten['flashdata'] = $this->session->flashdata();
    $data['konten'] = $this->load->view('keluarga/tambah.php', $data_konten, TRUE);
    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('keluarga/tambah.js', null, TRUE);
    $this->load->view('template', $data);
  }

  public function edit($id_keluarga) {

    $keluarga = $this->db->select('id_keluarga, wakil_keluarga, nama_blok, 
                sub_blok, no_rumah, blok.id_blok, detail_blok.id_detail_blok')
              ->from('keluarga')
              ->join('detail_blok', 'keluarga.id_detail_blok = detail_blok.id_detail_blok')
              ->join('blok', 'detail_blok.id_blok = blok.id_blok')
              ->where('id_keluarga', $id_keluarga)
              ->get()
              ->row_array();

    // jika ada data yang dikirim dan validasinya benar
    if (count($_POST) > 0) {

      $this->db->db_debug = FALSE;

      $data = $this->input->post();
      unset($data['id_blok']);
      $this->db->where('id_keluarga', $id_keluarga);
      $result = $this->db->update('keluarga', $data);
      $error_code = $this->db->error()['code'];

      $this->db->db_debug = TRUE;

      if ($error_code == 1062) {
        $this->session->set_flashdata('status', 'gagal');
        redirect(base_url( uri_string() ));
        exit();  
      }

      if (!$result) {
        $error_message = $this->db->error()['message'];
        echo "Error Database : <br> {$error_message}";
        exit();
      }

      $this->session->set_flashdata('status', 'berhasil');
      redirect(base_url( uri_string() ));
      exit();
    }

    $data_konten['flashdata'] = $this->session->flashdata();
    $data_konten['keluarga'] = $keluarga;
    $data['konten'] = $this->load->view('keluarga/edit.php', $data_konten, TRUE);
    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('keluarga/edit.js', null, TRUE);

    $this->load->view('template', $data);
    // var_dump($nama_blok);
    

  }

  public function hapus($id_keluarga) {
    $this->db->db_debug = FALSE;
    $wakil_keluarga = $this->db->get_where('keluarga', ['id_keluarga' => $id_keluarga])
    ->row_array()['wakil_keluarga'];
    
    $this->db->where('id_keluarga', $id_keluarga);
    $result = $this->db->delete('keluarga');

    $error_message = $this->db->error()['message'];
    $error_code = $this->db->error()['code'];

    $this->db->db_debug = TRUE;


    if ($error_code == 1451) {
      $this->session->set_flashdata('status', 'gagal');
      $this->session->set_flashdata('wakil_keluarga', $wakil_keluarga);
      redirect('/keluarga');
      exit();
    }

    if (!$result) {
      
      echo "Error Database : <br> {$error_message}";
      exit();
    }

    $this->session->set_flashdata('status', 'berhasil');
    $this->session->set_flashdata('wakil_keluarga', $wakil_keluarga);
    redirect('/keluarga');
  }

}
