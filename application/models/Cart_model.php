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
    function insertCustomer($data){
        $data['date'] = date("Y-m-d H:i:s");
        $insert = $this->db->insert('custable', $data);
        return $insert ? $this->db->insert_id() : false;
    }
    function insertOrder($data){
        $data['created'] = date("Y-m-d H:i:s");
        $insert = $this->db->insert('orders', $data);
        return $insert ? $this->db->insert_id() : false;
    }
    function insertOrderItems($data = array()){
        $insert = $this->db->insert_batch('order_items', $data);
        return $insert ? TRUE : FALSE;
    }
    function getOrder($id){
        $this->db->select('o.*, c.name, c.email, c.phone, c.address');
        $this->db->from('orders as o');
        $this->db->join('custable as c', 'c.id = o.customer_id', 'left');
        $this->db->where('o.id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        
        // Get order items
        $this->db->select('i.*, p.image, p.name, p.price');
        $this->db->from('order_items as i');
        $this->db->join('products as p', 'p.id = i.product_id', 'left');
        $this->db->where('i.order_id', $id);
        $query2 = $this->db->get();
        $result['items'] = ($query2->num_rows() > 0)?$query2->result_array():array();
        
        // Return fetched data
        return !empty($result)?$result:false;
    }
}
?>