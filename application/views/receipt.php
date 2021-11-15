<div class="container">
<h2 class="txt-heading">Order Placed Successfully. <h1>Order ID: <?php echo $order['id'];?></h1></h2>
<div class="container">
<h4>Customer Details</h4>
<table class="table table-striped ">
	<thead class ="table table-dark">
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Aderss</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><?php echo $order['name']; ?></td>
	<td><?php echo $order['email']; ?></td>
	<td><?php echo $order['phone']; ?></td>
	<td><?php echo $order['address']; ?></td>
	</tr>
	</tbody>
	</table>
</div>
<div>
<h4>Orders Details</h4>
<table class="table table-striped">
	<thead class ="table table-dark">
	<tr>
		<th>Product Name</th>
		<th>Image</th>
		<th>Price</th>
		<th>Quantity</th>
		<th>Total</th>
	</tr>
	</thead>
	<tbody>
		<?php
		if(!empty($order['items'])){
			foreach($order['items'] as $item){
		?>
	<tr>
	<td><?php echo $item['name']; ?></td>
	<td><img src="<?php echo base_url().$item['image'];; ?>" width="50" height="50"></td>
	<td>$ <?php echo $item['price']; ?></td>
	<td><?php echo $item['quantity']; ?></td>
	<td>$ <?php echo $item['sub_total']; ?></td>
	</tr>
	<?php }} ?>
	<tr>
		<?php //$total .= $total;?>
		<td><h3>Cart Total: $ <strong><?php  echo $order['grand-total'];?></strong></h3></td> 
	</tr>
	</tbody>
	</table>
</div>
</body>
</html>