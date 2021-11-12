<?php
      //  echo '<pre>'; print_r($_SESSION);

      if(count($product)){
          foreach($product as $row){
?>

<div class="border">
    <input type="hidden" name="id" id="prod_id" value="<?php echo $row->id; ?>">
    <div><img src="<?php echo base_url().$row->image; ?>" width="100" height="100"></div>

    <div><strong><?php echo $row->name; ?></strong></div>

    <div class="text-danger">Price:<?php echo " $ ".$row->price; ?></div>

    <div><input type="button" name="add" id="add_<?php echo $row->id;?>" onClick="cart(<?php echo $row->id;?>);" class="btn btn-success addtocart" value="Add to cart" ></div>

    <div><input type="button" name="added" id="added_<?php echo $row->id;?>"  class="addedtocart" style="display:none" value="Already Added"></div>
</div >
<?php } } else{?>
<h1>No Products to display</h1>
<?php } ?>

<script>
function cart(id){
// var qnty=$('#qnty').val();
jQuery.ajax({
    type:'POST',
    url: "<?php echo site_url('welcome/addToCart')?>",
    data:{prod_id:id},
    // dataType: "json",
    success:function(data){
        // data = json_decode(data);
        // alert(data);
        $("#add_"+id).hide();
        $("#added_"+id).show();
        location.reload();
    }
});
}
</script>