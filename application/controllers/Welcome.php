<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent :: __construct();
		$this->load->helper('form');
		$this->load->model("cart_model");
		$this->load->library('cart');
	
	}

	public function index()
	{
		$this->load->view('header');
		$this->load->view('welcome_message');
	}
	public function products()
	{
		$data = array();
		$data["product"] = $this->cart_model->products();
		$this->load->view('products', $data);
	}
	public function addToCart()
	{
		$id = json_decode($_POST['prod_id']);
		$prods = $this->cart_model->addCart($id);
		$data = array(
						'id' => $prods->id,
						'name' => $prods->name,
						'qty' => 1,
						'price' => $prods->price
					);
		$this->cart->insert($data);
		echo $this->cart->total_items();
		redirect('welcome/cart');
	}

	public function cart(){
		$data['cartItems'] = $this->cart->contents();
		//echo json_encode($data);
		$this->load->view('header',$data);
		$this->load->view('cart');
	
	}

	public function updateIemQty(){
		$update = 0;
		$rowid = $this->input->get('rowid');
		$qty = $this->input->get('qty');
		if(!empty($rowid) && !empty($qty)){
			$data = array(
				'rowid' => $rowid,
				'qty' => $qty
			);
			$update = $this->cart->update($data);
		}
		echo $update ? 'ok' : 'err';//return response
	}

	public function removeItem($rowid){
		$remove = $this->cart->remove($rowid);
		redirect('welcome/cart');
	}
}
?>
