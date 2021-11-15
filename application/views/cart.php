<div class="container">

<h1 class="txt-heading">Products</h1>
<a href="<?php echo base_url('welcome/deleteAll')?>" onclick="return confirm('DELETE ALL ITEMS');" class="btn btn-warning"> Clear Cart </a>
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
	<?php }else{
			echo "<div class='container'><h2>Your Cart is Empty</h2>  <a href='index.php'>Click to Add Products</a></div>";
			} ?>
<br><br><br>
<form method="POST" >
	<div>
		<h4>Shipping Information</h4>
		<div class="form-group">
        <input type="text" name="name" placeholder="Name" value="<?php echo set_value('name'); ?>">
        <?php echo form_error('name', '<div class="error alert alert-danger" style="color:red">', '</div>') ?>
    </div>
    <div class="form-group">
        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
        <?php echo form_error('email', '<div class="error alert alert-danger" style="color:red">', '</div>') ?>
    </div>
    <div class="form-group">
        <input type="number" name="phone" placeholder="Phone No.">
        <?php echo form_error('phone', '<div class="error alert alert-danger" style="color:red">', '</div>') ?>
    </div>
    <div class="form-group">
        <input type="text" name="address" placeholder="Address">
        <?php echo form_error('address', '<div class="error alert alert-danger" style="color:red">', '</div>') ?>
    </div>
	<div class="form-group">
        <input type="submit" name="placeorder" class="btn btn-primary" value="Place Order">
    </div>
</form>



  </div>
</div>
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
</body>
</html>