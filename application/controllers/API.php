<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->library('form_validation');
  }

  public function get_label_transfer() {
    $q = $this->input->get('q') ?? '';
    $query = $this->db->select('*')
      ->from('label_transfer')
      ->like('label_transfer', $q)
      ->get();
    $result = $query->result_array();
    $json = json_encode($result);
    echo $json;
  }

  public function get_keluarga() {
    $id_detail_blok = $this->input->get('id_detail_blok') ?? '';
    $id_blok = $this->input->get('id_blok') ?? '';
    $no_rumah = $this->input->get('no_rumah') ?? '';
    $query = $this->db->select('keluarga.*, detail_blok.id_blok, nama_blok, sub_blok')
      ->from('keluarga')
      ->join('detail_blok', 'detail_blok.id_detail_blok = keluarga.id_detail_blok')
      ->join('blok', 'blok.id_blok = detail_blok.id_blok');

    if ($id_blok != "") {
      $query->where('detail_blok.id_blok', $id_blok);
    }
    if ($id_detail_blok != "") {
      $query->where('detail_blok.id_detail_blok', $id_detail_blok);
    }
    if ($no_rumah != "") {
      $query->where('no_rumah', $no_rumah);
    }
    $query = $query->get();
    $result = $query->result_array();
    $json = json_encode($result);
    echo $json;
  }

  public function get_blok() {
    $q = $this->input->get('q') ?? '';
    $query = $this->db->select('*')
      ->from('blok')
      ->like('nama_blok', $q)
      ->get();
    $result = $query->result_array();
    $json = json_encode($result);
    echo $json;
  }

  public function get_detail_blok() {
    $sub_blok = $this->input->get('sub_blok') ?? '';
    $id_blok = $this->input->get('id_blok') ?? '';
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
