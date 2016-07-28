<?php
/**
 * Jacobin Core Embed Timeline View
 * 
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin\Views
 * @since      0.1.4
 * @license    GPL-2.0+
 */
?>

<?php
$content = get_post_meta( $attr['post_id'], 'chart_code', true );
?>
<!-- Begin chart aside -->
<aside class="article-chart" role="secondary">

	<figure title="<?php echo esc_attr( get_the_title( $attr['post_id'] ) ); ?>">
        <figcaption><?php echo esc_attr( get_the_title( $attr['post_id'] ) ); ?></figcaption>
        
        <?php echo '<![CDATA[' . $content . ']]'; ?>

	</figure>

</aside>
<!-- //End chart aside -->