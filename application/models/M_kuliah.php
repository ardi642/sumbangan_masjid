<?php 
class M_kuliah extends CI_model {
    public function select() {
        $query = $this->db->get('mahasiswa');
        var_dump($this->db->last_query());
        return $query->result_array();
    }
}
?>
