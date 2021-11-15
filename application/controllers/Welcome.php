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
		$this->load->library('form_validation');
		$this->load->helper('form');
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
		
		if($this->cart->total_items() <= 0){
			redirect('/');
		}
		$submit = $this->input->post('placeorder');
		if(isset($submit)){
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('phone', 'Phone', 'required');
			$this->form_validation->set_rules('address', 'Address	', 'required');

			$custData = array(
				'name' => strip_tags($this->input->post('name')),
				'email' => strip_tags($this->input->post('email')),
				'phone' => strip_tags($this->input->post('phone')),
				'address' => strip_tags($this->input->post('address')),
				'email' => strip_tags($this->input->post('email'))
			);
			if($this->form_validation->run() == TRUE){
				$insert = $this->cart_model->insertCustomer($custData);
				if($insert){ //returns here
					$order = $this->placeOrder($insert);
					//var_dump($order);
					if($order){
						$this->session->set_userdata('success_msg', 'Order Placed successfully.');
						redirect('welcome/orderSuccess/'.$order);
					}else{
						$data['error_msg'] = 'Order Not Placed. Please try again.';
					}
				}else{
					$data['error_msg'] = 'Some Problem occured. Please try again.';
				}
			}
		}
		$this->load->view('header',$data);
		$this->load->view('cart');
	}
		//$data['custData'] = $custData;
		
	function placeOrder($custID){
	//$data['cartItems'] = $this->cart->contents();
	$ordData = array(
			'customer_id' => $custID,
			'grand-total' => $this->cart->total()
		);
		$insertOrder = $this->cart_model->insertOrder($ordData);
		if($insertOrder){
			$cartItems = $this->cart->contents();
			$i=0;
			foreach($cartItems as $item){
				$ordItemData[$i]['order_id'] = $insertOrder;
				$ordItemData[$i]['product_id'] = $item['id'];
				$ordItemData[$i]['quantity'] = $item['qty'];
				$ordItemData[$i]['sub_total'] = $item['subtotal'];
				$i++;
			}
			if(!empty($ordItemData)){
				$insertOrderItems = $this->cart_model->insertOrderItems($ordItemData);
				if($insertOrderItems){
					$this->cart->destroy();
					//var_dump($insertOrder); exit;
					return $insertOrder; //order id of last inserted data and goes to line 65
					//redirect('/');
				}
			}
		}
		return false;
		//$this->load->view('header',$data);
		//$this->load->view('cart');
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

	public function deleteAll(){
		$this->cart->destroy();
		redirect('/');
	}

	public function orderSuccess($ordId){
		//$data['order'] = $this->cart_model->getOrder($ordId);
		echo '<pre>';print_r($data);
		$this->load->view('header', $data);
		$this->load->view('receipt');
	}
}
?>
