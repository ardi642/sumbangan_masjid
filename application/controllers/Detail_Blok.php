<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_Blok extends CI_Controller {

  public $menu_aktif = 'blok rumah';

  public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
      $this->load->model('M_mahasiswa');
  }

  public function detail($id_blok) {
    $details = $this->db->get_where('detail_blok', ['id_blok' => $id_blok])->result_array();


    // mengambil data produk dan kategori dengan id yang sesuai
    $query = $this->db
      ->select('detail_blok.id_detail_blok, blok.nama_blok, detail_blok.sub_blok')
      ->from('detail_blok')
      ->join('blok', 'detail_blok.id_blok = blok.id_blok')
      ->where('detail_blok.id_blok', $id_blok)
      ->get();
    $details = $query->result_array();
    
    $columns = (count($details) > 0) ? array_keys($details[0]) : [];
    $data_konten['details'] = $details;
    $data_konten['columns'] = $columns;
    $data_konten['flashdata'] = $this->session->flashdata();
    $data_konten['id_blok'] = $id_blok;
    $data['konten'] = $this->load->view('detail_blok/detail.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('detail_blok/detail.js', null, TRUE);

    $this->load->view('template', $data);

  }

  public function tambah($id_blok) {
    $nama_blok = $this->db->get_where('blok', ['id_blok' => $id_blok])
                ->row_array()['nama_blok'];
    if (count($_POST) > 0) {
      $this->db->db_debug = FALSE;
      
      $data['id_blok'] = $id_blok;
      $data['sub_blok'] = $this->input->post('sub_blok');
      $result = $this->db->insert('detail_blok', $data);
      $error_code = $this->db->error()['code'];
      
      $this->db->db_debug = TRUE;
      
      if ($error_code == 1062) {
        $this->session->set_flashdata('status', 'gagal');
        $this->session->set_flashdata('nama_blok_gagal', $nama_blok);
        $this->session->set_flashdata('sub_blok_gagal', $data['sub_blok']);
        redirect(base_url( uri_string() ));
        exit();  
      }

      if (!$result) {
        $error_message = $this->db->error()['message'];
        echo "Error Database : <br> {$error_message}";
        exit();
      }

      $this->session->set_flashdata('status', 'berhasil');
      $this->session->set_flashdata('sub_blok', $data['sub_blok']);
      redirect(base_url( uri_string() ));
      exit();
    }

    $data_konten['flashdata'] = $this->session->flashdata();
    $data_konten['id_blok'] = $id_blok;
    $data_konten['nama_blok'] = $nama_blok;
    $data['konten'] = $this->load->view('detail_blok/tambah.php', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('detail_blok/tambah.js', null, TRUE);

    $this->load->view('template', $data);

  }

  public function edit($id_detail_blok) {

    $query = $this->db
    ->select('detail_blok.id_detail_blok, blok.nama_blok, detail_blok.sub_blok, detail_blok.id_blok')
    ->from('detail_blok')
    ->join('blok', 'detail_blok.id_blok = blok.id_blok')
    ->where('detail_blok.id_detail_blok', $id_detail_blok)
    ->get();
    
    $detail = $query->row_array();
    $id_blok = $detail['id_blok'];
    $nama_blok = $detail['nama_blok'];
    $sub_blok = $detail['sub_blok']; 
    // var_dump($detail);
    // die();  
    // jika ada data yang dikirim dan validasinya benar
    if (count($_POST) > 0) {
      $this->db->db_debug = FALSE;
      
      $data['sub_blok'] = $this->input->post('sub_blok');
      $this->db->where('id_detail_blok', $id_detail_blok);
      $result = $this->db->update('detail_blok', $data);
      $error_code = $this->db->error()['code'];
      
      $this->db->db_debug = TRUE;
      
      if ($error_code == 1062) {
        $this->session->set_flashdata('status', 'gagal');
        $this->session->set_flashdata('sub_blok_awal', $data['sub_blok']);
        redirect(base_url( uri_string() ));
        exit();  
      }

      if (!$result) {
        $error_message = $this->db->error()['message'];
        echo "Error Database : <br> {$error_message}";
        exit();
      }

      $this->session->set_flashdata('status', 'berhasil');
      $this->session->set_flashdata('sub_blok_awal', $sub_blok);
      redirect(base_url( uri_string() ));
      exit();
    }

    $data_konten['status'] = $this->session->flashdata('status');
    $data_konten['id_blok'] = $id_blok;
    $data_konten['nama_blok'] = $nama_blok;
    $data_konten['sub_blok_awal'] = $this->session->flashdata('sub_blok_awal');
    $data_konten['sub_blok_sekarang'] = $sub_blok;
    $data['konten'] = $this->load->view('detail_blok/edit', $data_konten, TRUE);

    $data['menus'] = $this->config->item('menus');
    $data['menu_aktif'] = $this->menu_aktif;
    $data['js'] = $this->load->view('detail_blok/edit.js', null, TRUE);

    $this->load->view('template', $data);

  }

  public function hapus($id_detail_blok) {
    $this->db->db_debug = FALSE;
    $detail_blok = $this->db->get_where('detail_blok', ['id_detail_blok' => $id_detail_blok])
              ->row_array();
    $sub_blok = $detail_blok['sub_blok'];
    $id_blok = $detail_blok['id_blok'];

    $this->db->get_where('detail_blok', ['id_blok' => $id_blok]);
    $jumlah_sub_blok = $this->db->where(['id_blok' => $id_blok])
          ->from("detail_blok")->count_all_results();
    
    $this->db->trans_begin();
    
    $this->db->where('id_detail_blok', $id_detail_blok);
    $result1 = $this->db->delete('detail_blok');
    $result2 = TRUE;
    if ($jumlah_sub_blok == 1) {
      $this->db->where('id_blok', $id_blok);
      $result2 = $this->db->delete('blok');
    }

    $this->db->db_debug = TRUE;
    $error_code = $this->db->error()['code'];
    
    if ($error_code == 1451) {  
      $this->session->set_flashdata('status', 'gagal');
      $this->session->set_flashdata('sub_blok_gagal', $sub_blok);
      $url_sebelumnya = $_SERVER['HTTP_REFERER'];
      redirect($url_sebelumnya);
      exit();
    }

    if (!$result1 OR !$result2) {
      $this->db->trans_rollback();
      $error_message = $this->db->error()['message'];      
      echo "Error Database : <br> {$error_message}";
      exit();
    }

    $this->db->trans_commit();
    $this->session->set_flashdata('status', 'berhasil');
    $this->session->set_flashdata('sub_blok', $sub_blok);
    $url_sebelumnya = $_SERVER['HTTP_REFERER'];
    if ($jumlah_sub_blok == 1) $url = base_url('blok');
    else $url = $url_sebelumnya;
    redirect($url);
    
  }
}
