<?php
/**
 * Jacobin Core Export Guest Authors
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Admin
 * @since       0.5.0
 * @license    GPL-2.0+
 */

 /**
  * Export Guest Authors Class
  *
  */
class Jacobin_Core_Export_Guest_Authors {

	/**
	 * Submenu Title
	 *
	 * @access   public
	 * @var      string    $submenu_title
	 */
	public $submenu_title;

   /**
    * Autoload Method
    * @return void
    */
   public function __construct() {
		 $this->submenu_title = apply_filters( 'export_guest_authors_submenu_title', __( 'Export Guest Authors', 'jacobin-core' ) );
		 add_action( 'admin_init', array( $this, 'download_csv' ) );
     add_action( 'admin_menu', array( &$this, 'register_sub_menu' ) );
   }

   /**
    * Register Submenu
    *
    * @since https://developer.wordpress.org/reference/functions/add_submenu_page/
    *
    * @return void
    */
   public function register_sub_menu() {
		 add_submenu_page(
				'users.php',
				$this->submenu_title,
				$this->submenu_title,
				'list_users',
				'export-guest-authors',
				array( &$this, 'submenu_page_callback' )
		 );
   }

   /**
    * Render Submenu Page
    *
    * @uses wp_nonce_field()
    * @link
    *
    * @return void
    */
  public function submenu_page_callback() { ?>

		<div class="wrap">
			 <h2><?php esc_html_e( 'Export Guest Authors' ); ?></h2>
			 <form method="post">
				 <?php wp_nonce_field( 'export_guest_authors_nonce' ); ?>
				 <input type="submit" name="export-guest-authors" value="<?php esc_html_e( 'Export Guest Authors' ); ?>" class="add-new-h2 js-export-guest-authors" />
			 </form>
		</div>

	<?php
	}

	/**
	 * Get the Guest Authors
	 *
	 * @requires global `$coauthors_plus`
	 *
	 * @return mixed array @output || false
	 */
	public function get_guest_authors() {
		$args = array(
			'taxonomy'		 => 'author',
			'orderby'      => 'name',
		);

		$terms = get_terms( $args );

		if( empty( $terms ) || is_wp_error( $terms ) ) {
			return false;
		}

		$authors = array();

		foreach( $terms as $term ) {
			global $coauthors_plus;
			if ( $coauthor = $coauthors_plus->get_coauthor_by( 'user_login', $term->name ) ) {
				$author = get_object_vars( $coauthor );
				$authors[] = array(
					$author['ID'],
					$author['display_name'],
					$author['user_email']
				);
			}
		}

		return $authors;
	}

	/**
	 * Create a CSV File
	 *
	 * @param  array $array
	 * @param  string $filename
	 * @param  string $delimiter
	 * @return void
	 */
	public function create_csv( $array, $filename = "guest-authors", $delimiter = "," ) {
		$output_filename = $filename;
		$output_handle = @fopen( 'php://output', 'w' );

		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Content-Description: File Transfer' );
		header( 'Content-type: text/csv' );
		header( 'Content-Disposition: attachment; filename=' . $output_filename );
		header( 'Expires: 0' );
		header( 'Pragma: public' );

		fputcsv( $output_handle, array( 'ID', 'Display Name', 'Email' ) );

		foreach ( $array as $row ) {
			fputcsv( $output_handle, $row, $delimiter );
		}

		fclose( $output_handle );

		die();
	}

	/**
	 * Make Download File
	 *
	 * @uses $this->get_guest_authors()
	 * @uses check_admin_referer()
	 *
	 * @return void
	 */
	public function download_csv() {
		if ( ( isset( $_POST['export-guest-authors'] ) && check_admin_referer( 'export_guest_authors_nonce' ) ) && ( $authors = $this->get_guest_authors() ) ) {
			$date = date( 'Y-m-d-h:i:s', time() );
			$filename = 'guest-authors-' . $date . '.csv';

			$this->create_csv( $authors, $filename );
		}
	}

}

new Jacobin_Core_Export_Guest_Authors();
