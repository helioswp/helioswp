<?php if (!defined('ABSPATH')) { exit; }
global $wpdb;
if (isset($_POST['submit'])){
	$enabled = 0;
	$product_id = 0;
	$cart_value = 0;
	if(isset($_POST["free_prod_enabled"])){
		$enabled = 1;
	}

	if(isset($_POST["free_prod_product_id"]) && !empty($_POST["free_prod_product_id"])){
		$product_id = $_POST["free_prod_product_id"];
	}

	if(isset($_POST["free_prod_cart_value"]) && !empty($_POST["free_prod_cart_value"])){
			$cart_value = $_POST["free_prod_cart_value"];
	}

	$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
	if(!empty($data[0])){
		$wpdb->query("UPDATE {$wpdb->prefix}wphs SET cart_discount_enabled = $enabled, cart_discount_product_id = $product_id, cart_discount_cart_value = $cart_value WHERE id=1");
	}
	
}

$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
$used = "";
if($data[0]->cart_discount_enabled == 1){
	$used = 'checked';
}

?>
<link rel='stylesheet' href='<?php echo plugins_url('../css/hs_custom.css', __FILE__) ?>' type='text/css' media='all' />
<div class="wrap fm_rootWrap">
<h3 class="fm_headingTitle">Ingyenes termék</h3>
<div class="fm_whiteBg">
    <?php if(!empty($data[0])){ ?>
<form action="" method="post">
<table class="form-table">
<tr>
	<th>Bekapcsolás</th>
	<td>
		<input name="free_prod_enabled" type="checkbox" id="free_prod_enabled" value="1" class="regular-text" <?php echo $used?> >
	</td>
</tr>
<tr>
	<th>Woocommerce Termék azonosító</th>
	<td>
		<input name="free_prod_product_id" type="text" id="free_prod_product_id" value="<?php echo $data[0]->cart_discount_product_id ?>" class="regular-text">
	</td>
</tr>
<tr>
	<th>Kosár érték</th>
	<td>
		<input name="free_prod_cart_value" type="text" id="free_prod_cart_value" value="<?php echo $data[0]->cart_discount_cart_value ?>" class="regular-text">
	</td>
</tr>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Változtatások mentése"></p>
</form>
    <?php }else{ echo "A rendszer használatához jelentkezz be"; } ?>
</div>
</div>
