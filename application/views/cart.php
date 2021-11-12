
<h1 class="txt-heading">Products</h1>
<button class="btn btn-warning" onClick="cartAction('empty','');">Clear Cart</button>
<form id="cart" >
<table class="table table-striped">
	<thead>
	<tr>
		<th>Product</th>
		<th>Price</th>
		<th>Quantity</th>
		<th>Total</th>
		<th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php
		if($this->cart->total_items() > 0){
		foreach($cartItems as $item){
	?>
	<tr>
	<td><?php echo $item['name']; ?></td>
	<td>$ <?php echo $item['price']; ?></td>
	<td>
		<input type="number"  class="iquantity" id="qty_<?php echo $item['id']; ?>" value="<?php echo $item['qty'];?>" size="2" min="1" max="20" onchange="updateCartItem(this, '<?php echo $item['rowid']?>')">
	</td>
	<td class="itotal"><?php echo " $ " . $item['subtotal'];?></td>
	<td><a href="<?php echo base_url('welcome/removeItem/'.$item['rowid']);?>" class="btn btn-sm btn-danger" onclick="return confirm('Press ok to Confirm');"> <i class="fas fa-trash"></i></a></td>
	</tr>
	</div>
	<?php } ?>
	<tr>
		<?php //$total .= $total;?>
		<td><h3>Cart Total: $ <strong><?php echo $this->cart->total()?></strong></h3></td> 
	</tr>
	</tbody>
	</table>
	<td><a href="<?php echo base_url('welcome/checkout')?>" class="btn btn-success"> Checkout</a></td>
	<?php }else{
			echo "<div class='container'><h2>Your Cart is Empty</h2>  <a href='index.php'>Click to Add Products</a></div>";
			} ?>
<br><br><br>
<script>
	function updateCartItem(obj, rowid){
		$.get("<?php echo base_url('welcome/updateIemQty/')?>", {rowid:rowid, qty:obj.value}, function(resp){
			if(resp=='ok'){
				location.reload();
			}else{
				alert('Cart update failed');
			}
		});
	}
</script>
<script>

function cartAction(action, product_id) {
	var queryString = "";
	if(action != "") {
		switch(action) {
			case "remove":
				queryString = 'action='+action+'&code='+ product_id;
			break;
			case "empty":
				queryString = 'action='+action;
			break;
		}	 
	}
	jQuery.ajax({
        url: "checkout.php",
        data:queryString,
        type: "POST",
        success:function(data){
			//if(action == "empty" )
			window.location.reload();
		},
		error:function (){}
        });
}
</script>
</body>
</html>