<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://glocal.coop
 * @since      0.1.2
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/admin/partials
 */
?>

<div class="wrap">
    <h1><?php _e( 'Knowledge Base', 'knowledge-base' ) ?></h1>

    <form method="post" action="options.php">
        <?php
            settings_fields( $this->plugin_name );
            do_settings_sections( $this->plugin_name );      
            submit_button(); 
        ?>          
    </form>
    <div class="update-nag">
        <?php _e( 'In order for changes to take effect, please update Permalink settings (Settings > Permalinks).', 'knowledge-base' ) ?>
    </div>
</div>
