<?php
class Cart_model extends CI_Model
{
    function products(){
        $getprods = $this->db->get('products');
        return $getprods->result();
    }
    function addCart($id){
        $this->db->SELECT('id, name, price');
        $this->db->where('id', $id);
        $getcart = $this->db->get('products');
        return $getcart->row();
    }
}
?>