<h2 class="txt-heading">Products</h2>
<section id="display">
	
</section>

<script>
    $(document).ready(function(){
		load_products();
		function load_products(){
			$.ajax({
			url:"<?php echo site_url('welcome/products')?>",
			type:'post',
			success:function(data){
				$('#display').html(data);
			}
		});
		}
    })
</script>