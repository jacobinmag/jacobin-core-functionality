<?php
/**
 * Jacobin Core Embed Timeline View
 * 
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin\Views
 * @since      0.1.3
 * @license    GPL-2.0+
 */
?>

<?php
/**
 * Repeater field function required
 * 
 * If the ACF repeater field function doesn't exist, bail.
 */
if( !function_exists( 'have_rows' ) ) {
	return;
} ?>

<!-- Begin timeline aside -->
<aside class="article-timeline" title="<?php echo esc_attr( get_the_title( $attr['post_id'] ) ); ?>" role="secondary">

	<dl id="timeline-<?php echo $attr['post_id']; ?>">

	<?php if( have_rows( 'timeline_items', $attr['post_id'] ) ) : ?>

		<?php while ( have_rows( 'timeline_items', $attr['post_id'] ) ) : the_row(); ?>

			<dt><?php echo date( 'Y', strtotime( get_sub_field( 'date' ) ) ); ?></dt>

			<dd><?php the_sub_field( 'content' ); ?></dd>

		<?php endwhile; ?>

	<?php endif; ?>

	</dl>

</aside>
<!-- //End timeline aside -->