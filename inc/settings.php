<?php if (!defined('ABSPATH')) { exit; }
global $wpdb;

if (isset($_POST['submit'])){
	$viewCountEnabled = 0;
	$abandonedCartEnabled = 0;
	$heliosCheckoutEnabled = 0;
	$heliosStockManagerEnabled = 0;
	if(isset($_POST["product_view_count_enabled"])){
		$viewCountEnabled = 1;
	}
	
	if(isset($_POST["abandoned_cart_enabled"])){
		$abandonedCartEnabled = 1;
	}

    if(isset($_POST["helios_checkout"])){
        $heliosCheckoutEnabled = 1;
    }

    if(isset($_POST["helios_stock_managert_enabled"])){
        $heliosStockManagerEnabled = 1;
    }

	$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
	if(!empty($data[0])){
		$wpdb->query("UPDATE {$wpdb->prefix}wphs SET product_view_count_enabled = $viewCountEnabled, abandoned_cart_enabled = $abandonedCartEnabled, helios_checkout_enabled = $heliosCheckoutEnabled, helios_stock_enable = $heliosStockManagerEnabled WHERE id=1");
	}
	
}

$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
$productViewEnabled = "";
$abandonedCartEnabled = "";
$heliosCheckoutEnabled = "";
$heliosStockManagerEnabled = "";
if($data[0]->product_view_count_enabled == 1){
	$productViewEnabled = 'checked';
}
if($data[0]->abandoned_cart_enabled == 1){
	$abandonedCartEnabled = 'checked';
}
if($data[0]->helios_checkout_enabled == 1){
    $heliosCheckoutEnabled = 'checked';
}
if($data[0]->helios_stock_enable == 1){
    $heliosStockManagerEnabled = 'checked';
}

?>
<link rel='stylesheet' href='<?php echo plugins_url('../css/hs_custom.css', __FILE__) ?>' type='text/css' media='all' />
<div class="wrap fm_rootWrap">
<h3 class="fm_headingTitle">Beállítások</h3>
<div class="fm_whiteBg">
    <?php if(!empty($data[0])){ ?>
<form action="" method="post">
<table class="form-table">
<tr>
	<th>Termék nézettség követése</th>
	<td>
		<input name="product_view_count_enabled" type="checkbox" id="product_view_count_enabled" value="1" class="regular-text" <?php echo $productViewEnabled?> >
	</td>
    <th>Helios Pénztár</th>
    <td>
        <input name="helios_checkout" type="checkbox" id="helios_checkout" value="1" class="regular-text" <?php echo $heliosCheckoutEnabled?> >
    </td>
</tr>
<tr>
	<th>Kosár elhagyó emailek</th>
	<td>
		<input name="abandoned_cart_enabled" type="checkbox" id="abandoned_cart_enabled" value="1" class="regular-text" <?php echo $abandonedCartEnabled?> >
	</td>
    <th>Helios Raktár</th>
    <td>
        <input name="helios_stock_managert_enabled" type="checkbox" id="helios_stock_managert_enabled" value="1" class="regular-text" <?php echo $heliosStockManagerEnabled?> >
    </td>
</tr>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Változtatások mentése"></p>
</form>
    <?php }else{
        echo "A rendszer használatához jelentkezz be";
    } ?>
</div>
</div>
