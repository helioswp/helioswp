<?php if (!defined('ABSPATH')) { exit; }

global $wpdb;
$data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
if (isset($_POST['submit'])){

    if(isset($_POST["helios_mail"]) && isset($_POST["helios_password"])){
        $data = array( 'mail' => $_POST["helios_mail"], 'password' => $_POST["helios_password"]);
        $response = Requests::post( 'https://admin.heliossystem.hu/api/wp_login.php', array(), $data );
        //var_dump($response->body);
        $values = json_decode($response->body);
        if($values->success == 200){
            //var_dump($values->company_id);
            $wpdb->query("INSERT INTO {$wpdb->prefix}wphs (company_id) VALUES ( $values->company_id);");
            $data = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}wphs WHERE id = 1");
        }
    }
}
?>

<link rel='stylesheet' href='<?php echo plugins_url('../css/hs_custom.css', __FILE__) ?>' type='text/css' media='all' />
<div class="wrap fm_rootWrap">
    <h3 class="fm_headingTitle">Bejelentkezés</h3>
    <div class="fm_whiteBg">
        <?php if(empty($data[0])){
            if(isset($_POST['submit'])){?>
        <div style="background-color: red;text-align: center;"><p style="color:white;font-size: 20px">A bejelentkezés siketelen</p></div>
        <?php } ?>
        <form action="" method="post">
            <table class="form-table">
                <tr>
                    <th>Helios Email cím</th>
                    <td>
                        <input name="helios_mail" type="text" id="helios_mail" value="" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th>Helios jelszó</th>
                    <td>
                        <input name="helios_password" type="password" id="helios_password" value="" class="regular-text">
                    </td>
                </tr>
            </table>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Bejelentkezés"></p>
        </form>
        <?php } else { ?>
            <table class="form-table">
                <tr>
                    <th>Fiók állapot:</th>
                    <td>
                        <p style="color: green">Aktív</p>
                    </td>
                </tr>
                <tr>
                    <th>Előfizetés</th>
                    <td>
                        <p>Basic</p>
                    </td>
                </tr>
            </table>
       <?php } ?>
    </div>
</div>

