<?php
/**
 * Jacobin Core Admin Display
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @since       0.1.4
 * @license    GPL-2.0+
 */
?>

<div class="wrap">
    <h1><?php _e( 'Featured Content', 'jacobin-core' ) ?></h1>

    <form method="post" action="options.php">
        <?php
            settings_fields( $this->setting_name );
            do_settings_sections( $this->setting_name );
            submit_button();
        ?>
    </form>
</div>
