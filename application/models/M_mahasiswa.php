<?php 
class M_mahasiswa extends CI_model {
    public function data_mahasiswa() {
        $query = $this->db->get('mahasiswa');
        return $query->result();
    }
}
?>
