<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_Sumbangan extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
  }

  public function get_keluarga() {
    $wakil_keluarga = $this->input->get('wakil_keluarga') ?? '';
    $id_blok = $this->input->get('id_blok') ?? '';
    $id_detail_blok = $this->input->get('id_detail_blok') ?? '';
    // var_dump($this->input->get());
    $this->db->select('keluarga.*, detail_blok.sub_blok, blok.id_blok, blok.nama_blok')
      ->from('keluarga')
      ->join('detail_blok', 'keluarga.id_detail_blok = detail_blok.id_detail_blok')
      ->join('blok', 'detail_blok.id_blok = blok.id_blok')
      ->like('keluarga.wakil_keluarga', $wakil_keluarga);
    
    if ($id_blok != '')
      $this->db->where('blok.id_blok', $id_blok);
    
    if ($id_detail_blok != '')
      $this->db->where('detail_blok.id_detail_blok', $id_detail_blok);
    
    $query = $this->db->get();
    $result = $query->result_array();
    $json = json_encode($result);
    echo $json;
  }

  public function get_jenis_sumbangan() {
    $jenis_sumbangan = $this->input->get('q') ?? '';
    $this->db->select('*')->from('jenis_sumbangan');
    
    if ($jenis_sumbangan != '')
    $this->db->like('jenis_sumbangan', $jenis_sumbangan);

    $result = $this->db->get()->result_array();
    $json = json_encode($result);
    echo $json;
  }

  public function get_blok() {
    $nama_blok = $this->input->get('nama_blok') ?? '';
    $query = $this->db->select('*')
      ->from('blok')
      ->like('nama_blok', $nama_blok)
      ->get();
    $result = $query->result_array();
    $json = json_encode($result);
    echo $json;
  }

  public function get_detail_blok() {
    $id_blok = $this->input->get('id_blok') ?? '';
    $sub_blok = $this->input->get('sub_blok') ?? '';
    $query = $this->db->select('*')
      ->from('detail_blok')
      ->where('id_blok', $id_blok)
      ->like('sub_blok', $sub_blok)
      ->get();
    $result = $query->result_array();
    $json = json_encode($result);
    echo $json;
  }

}
