<?php
/**
 * Jacobin Core Copy Content
 *
 * @package    Jacobin_Core
 * @subpackage Jacobin_Core\Includes
 * @since      0.1.14
 * @license    GPL-2.0+
 */

/**
 * Clean up Post Meta
 *
 * @since 0.4.8
 *
 * @param  int $site
 * @param  array  $args
 *
 * @return void
 */
function jacobin_core_clean_meta( $site = null, $args = array() ) {

  if( is_multisite() && $site ) {
    switch_to_blog( $site );
  }

  $defaults = array(
    'post_type'       => 'post',
    'posts_per_page'  => -1,
  );

  $post_args = wp_parse_args( $args, $defaults );

  $posts = get_posts( $post_args );

  if( !empty( $posts ) && !is_wp_error( $posts ) ) {

    echo count( $posts ) . ' posts found.<br />--------------<br />';

    foreach( $posts as $post ) {

      if( function_exists( 'get_fields' ) ) {
        $fields = get_fields( $post->ID );

        echo "Post {$post->ID} - {$post->post_title}<br />------<br />";

        if( $fields ) {

          $count = 0;

          foreach( $fields as $key => $value ) {

            if( !empty( $value ) ) {

              $field_obj = get_field_object( $key, $post->ID );

              if( 'wysiwyg' == $field_obj['type'] ) {

                $count++;

                echo "{$key} to be updated.<br />";

                $filtered_value = str_replace( array( '"\&quot;', '\&quot;"', '"&quot;', '&quot;"', '\"' ), '"', str_replace( array( "\n", "\t", "\r", '\\' ), '', $value ) );

                //update_field( $key, $filtered_value, $post->ID );

              }

            }

          }

        }

        echo $count . " fields found for post {$post->ID}.<br /><br />";

      }

    }
  } else {
    if( !is_wp_error( $posts ) ) {
      print_r( $posts->get_error_message() );
    } else {
      echo 'There were no posts.';
    }
  }

  if( is_multisite() && $site ) {
    restore_current_blog();
  }
}

/**
 * Initialize Import Process
 * $path = '/catalyst/posts/';
 * jacobin_core_import_init( $path );
 *
 * @uses parse_json_files_in_directory()
 * @uses jacobin_core_import_data()
 *
 * @param  string $path
 * @param int $blog_id The id of site for which content should be imported
 * @return void
 */
function jacobin_core_import_init( $path, $blog_id = 2 ) {
  $posts = parse_json_files_in_directory( $path );

  if( !empty( $posts ) ) {

    foreach( $posts as $post ) {

      jacobin_core_import_data( $post, $blog_id );

    }

    echo 'We are done! - data for ' . count( $posts ) . ' posts was added <br />';

  } else {

    return new WP_Error( 'No File', __( 'The import file is empty or doesn\'t exist.', 'jacobin-core' ) );

  }

}

/**
 * Import Content for Each Post
 *
 * @uses
 *
 * @param  obj $post_data
 * @return void
 */
function jacobin_core_import_data( $post_data, $blog_id = 2 ) {

  if( is_multisite() ) {
    switch_to_blog( $blog_id );
  }

  $post_id = $post_data->id;

  // Add Guest Author Terms
  //jacobin_core_create_guest_author_terms( $post_data );

  // Add Guest Authors
  //jacobin_core_create_guest_authors( $post_data );

  // Add Taxonomy Terms
  jacobin_core_add_taxonomy_terms( $post_data );

  // Add Posts
  jacobin_core_add_post( $post_data );

  // Add Images
  $image_id = jacobin_core_get_featured_image( $post_data );
  jacobin_core_add_featured_image( $image_id, $post_data );

  // Assign Guest Authors
  jacobin_core_assign_guest_author( $post_data );

  if( is_multisite() ) {
    restore_current_blog();
  }

}

/**
 * Get Files in Directory
 *
 * @param  string $dir_path
 * @return array $files
 */
function get_files_in_directory( $dir_path = null ) {

  $uploads_dir = wp_upload_dir();
  $path = $uploads_dir['basedir'] . $dir_path;

  echo $path;

  try {

    if( file_exists( $path ) ) {

      $files = scandir( $path );

      return $files;

    } else {

      throw new Exception( 'Specified path is not valid' );

    }

  }
  catch( Exception $e ) {

    echo $e->getMessage();

  }

}

/**
 * Get JSON Files
 *
 * @uses get_files_in_directory()
 *
 * @param  string $dir_path
 * @return array $json_files
 */
function get_json_files_in_directory( $dir_path ) {

  $files = get_files_in_directory( $dir_path );
  $json_files = [];

  if( $files ) {

    foreach( $files as $file ) {
      if( 'json' == pathinfo( $file )['extension'] ) {
        $json_files[] = $file;
      }
    }

    return $json_files;

  } else {

    return new WP_Error( 'No File', __( 'The import file is empty or doesn\'t exist.', 'jacobin-core' ) );

  }


}

/**
 * Parse JSON File
 *
 * @param  string $file
 * @return array $content_array
 */
function parse_json_file_content( $file ) {
  $file_contents = file_get_contents( $file );
  $decoded_content = json_decode( $file_contents );

  return $decoded_content[0];
}

/**
 * Parse JSON Content in Directory
 *
 * @uses get_json_files_in_directory()
 * @uses parse_json_file_content()
 *
 * @param  string $dir_path [description]
 * @return array  $content_array An array of objects
 */
function parse_json_files_in_directory( $dir_path ) {
  $files = get_json_files_in_directory( $dir_path );

  $uploads_dir = wp_upload_dir();
  $path = $uploads_dir['basedir'] . $dir_path;

  $content_array = [];

  foreach( $files as $file ) {
    $content_array[] = parse_json_file_content( $path . $file );
  }

  return $content_array;
}

/**
 * Put Concatenated JSON in Single Files
 *
 * @uses parse_json_files_in_directory()
 *
 * @param  string $dir_path
 * @return void
 */
function jacobin_core_save_parsed_json( $dir_path ) {

  echo 'starting...';

  $uploads_dir = wp_upload_dir();
  $path = $uploads_dir['basedir'] . $dir_path;
  $filename = $path . 'catalyst_articles.json';

  echo $filename;

  $posts = parse_json_files_in_directory( $dir_path );

  $json = json_encode( $posts );

  $file = fopen( $filename, "w" ) or die( "Unable to open file!" );

  fwrite( $file, $json );

  fclose( $file );

  echo 'File saved to ' . $filename;

}

/**
 * Get Guest Authors from Posts
 *
 * @param  obj $post
 * @return mixed array $authors | false
 */
function get_post_guest_authors( $post ) {
  if( $authors = $post->authors ) {
    return $authors;
  }
  return false;
}

/**
 * Create Guest Author Terms
 *
 * @param  obj $author_data
 * @return void
 */
function jacobin_core_create_guest_author_terms( $post_data ) {
  $taxonomy = 'author';

  $author_data = get_post_guest_authors( $post_data );

  if( $author_data ) {

    foreach( $author_data as $data ) {

      if( !term_exists( $data->term_id, $taxonomy ) ) {
        wp_insert_term(
          $data->name,
          $taxonomy,
          array(
            'description'=> $data->description,
            'slug' => 'cap-' . $data->slug,
          )
        );

        if( term_exists( $data->term_id, $taxonomy ) ) {
          echo 'Guest author term was created.<br />';
        }
      } else {

        echo 'Guest author term already exists.<br />';

      }
    }

  } else {

    echo $author_data . ' does not exist<br />';

  }

}

/**
 * Create a Guest Author
 *
 * @param  array  $author
 * @return void
 */
function jacobin_core_create_guest_author( $author ) {
  $post_type = 'guest-author';
  $taxonomy = 'author';

  $post_id = ( int ) $author->id;
  $args['post_type'] = $post_type;

  if( !post_exists( $author->name ) ) {

    $new_post_args = array(
      'post_title'  => sanitize_post_field( 'post_title', $author->name, $post_id, 'db' ),
      'post_name'   => sanitize_post_field( 'post_name', 'cap-' . $author->slug, $post_id, 'db' ),
      'post_type'   => $post_type,
      'post_status'  => 'publish',
      'post_author'  => get_current_user_id(),
    );

    $post_id = wp_insert_post( $new_post_args );

    if( $post_id ) {

      $term_id = (int) $author->term_id;

      wp_set_post_terms( $post_id, $term_id, $taxonomy, true );

      add_post_meta( $post_id, 'cap-display_name', $author->name );
      add_post_meta( $post_id, 'cap-first_name', $author->first_name );
      add_post_meta( $post_id, 'cap-last_name', $author->last_name );
      add_post_meta( $post_id, 'cap-user_login', $author->slug );
      add_post_meta( $post_id, 'cap-user_email', '' );
      add_post_meta( $post_id, 'cap-website', $author->website );
      add_post_meta( $post_id, 'cap-aim', '' );
      add_post_meta( $post_id, 'cap-yahooim', '' );
      add_post_meta( $post_id, 'cap-jabber', '' );
      add_post_meta( $post_id, 'cap-description', $author->description );
      add_post_meta( $post_id, 'cap-nickname', $author->nickname );
      add_post_meta( $post_id, 'cap-linked_account', '' );

      echo 'Guest author ' . $post_id . ' was created. <br />';

    } else {

      echo 'Guest was not created. <br />';

    }

  }

}

/**
 * Create Guest Authors
 *
 * @uses jacobin_core_create_guest_author()
 *
 * @param  array  $author_data
 * @param  integer $blog_id
 * @return void
 */
function jacobin_core_create_guest_authors( $post_data  ) {

  $author_data = get_post_guest_authors( $post_data );

  foreach( $author_data as $author ) {

    jacobin_core_create_guest_author( $author );

  }

  echo 'Done with creating guest authors.<br />';

}

/**
 * Add Taxonomy Term
 *
 * @param obj $data
 * @param string $taxonomy
 * @return void
 */
function jacobin_core_add_taxonomy_term( $term, $taxonomy ) {

  if( !term_exists( $term->name, $taxonomy ) ) {

    wp_insert_term(
      $term->name,
      $taxonomy,
      array(
        'description'=> $term->description,
        'slug' => $term->slug,
      )
    );

    if( term_exists( $term->name, $taxonomy, $parent ) ) {

      echo $term->name . ' was added. <br />';

    } else {

      echo $term->name . ' was NOT added. <br />';

    }

  }

}

/**
 * Add Taxonomy Terms
 *
 * @uses jacobin_core_add_taxonomy_term()
 *
 * @param obj $post
 * @param integer $blog_id
 * @return void
 */
function jacobin_core_add_taxonomy_terms( $post ) {

  $taxonomies = array(
    'categories'  => 'category',
    'tags'        => 'post_tag',
    'formats'     => 'format',
    'departments' => 'department',
    'series'      => 'series',
  );

  foreach( $taxonomies as $key => $taxonomy ) {

    $terms = $post->{$key};

    if( !empty( $terms ) ) {

      foreach( $terms as $term ) {

        jacobin_core_add_taxonomy_term( $term, $taxonomy );

      }

    }

  }

  echo 'Done with adding terms. <br />';

}

/**
 * [jacobin_core_assign_guest_author description]
 * @param  [type] $post_data [description]
 * @return [type]            [description]
 */
function jacobin_core_assign_guest_author( $post_data ) {
  $taxonomy = 'author';
  $author_data = get_post_guest_authors( $post_data );
  $post_id = $post_data->id;

  if( !empty( $author_data ) ) {

    foreach( $author_data as $author ) {
      $term_id = (int) $author->term_id;

      wp_set_post_terms( $post_id, $term_id, $taxonomy, true );

    }

  }

  echo 'Done assigning guest authors.<br />';

}

/**
 * Add Featured Image
 *
 * @uses wp_generate_attachment_metadata()
 *
 * @param obj $image
 * @param integer $parent_id
 * @return void
 */
function jacobin_core_add_featured_image( $image, $post_data ) {
  $filename = $image->source_url;
  $parent_post_id = (int) $post_data->id;

  $filetype = wp_check_filetype( basename( $filename ), null );

  $wp_upload_dir = wp_upload_dir();

  $attachment = array(
    'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
    'post_mime_type' => $filetype['type'],
    'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
    'post_content'   => '',
    'post_status'    => 'inherit'
  );

  $attach_id = wp_insert_attachment( $attachment, $filename, $parent_post_id );

  // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
  require_once( ABSPATH . 'wp-admin/includes/image.php' );

  $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
  wp_update_attachment_metadata( $attach_id, $attach_data );

  set_post_thumbnail( $parent_post_id, $attach_id );

  try {
    if( has_post_thumbnail( $parent_post_id ) ) {

      echo $filename . ' was attached to ' . $parent_post_id . ' <br />';

    } else {

      throw new Exception( 'Image was not attached.' );

    }
  }
  catch( Exception $e ) {

    echo $e->getMessage();

  }

  echo 'Done adding featured images.<br />';

}

/**
 * Get Featured Image Data
 * @param  obj $post
 * @return array $post->featured_image
 */
function jacobin_core_get_featured_image( $post ) {
  return $post->featured_image;
}

/**
 * Add Post
 *
 * @uses jacobin_core_add_post_terms()
 * @uses jacobin_core_update_post_meta()
 *
 * @param obj $post
 * @return voide
 */
function jacobin_core_add_post( $post ) {

  $defaults = array(
    'post_type'       => 'post',
    'post_status'     => 'publish',
    'comment_status'  => 'closed',
    'ping_status'     => 'closed',
  );

  $args = array(
    'post_type'     => $post->type,
    'post_title'    => $post->title->rendered,
    'post_content'  => preg_replace( '/[\r\n]+/','', $post->content->rendered ),
    'post_excerpt'  => $post->excerpt->rendered,
    'post_date'     => $post->date,
    'post_modified' => $post->modified,
  );

  $new_post_args = wp_parse_args( $args, $defaults );

  if( !post_exists( $new_post_args['post_title'], '', $new_post_args['post_date'] ) ) {

    $post_id = wp_insert_post( $new_post_args );

    try {

      if( $post_id ) {

        // Add Post Terms qn Guest Authors
        jacobin_core_add_post_terms( $post );

        // Add Post Meta (custom fields)
        jacobin_core_update_post_meta( $post );

        echo $post_id . ' was added. <br />';

      } else {

        throw new Exception( 'Post was not added' );

      }

    }
    catch( Exception $e ) {

      echo $e->getMessage();

    }

    echo 'Done adding posts.<br />';

  }

}

/**
 * Add Post Meta
 *
 * @uses update_field()
 *
 * @param  obj $post
 * @return void
 */
function jacobin_core_update_post_meta( $post ) {
  $post_id = (int) $post->id;

  $fields = array(
    'subhead',
    'antescript',
    'footnotes',
  );

  foreach( $fields as $field ) {
    if( function_exists( 'update_field' ) ) {
      update_field( $field, $post->{$field}, $post_id );
    } else {
      add_post_meta( $post_id, $field, $post->{$field}, true );
    }
  }

  if( !empty( $post->related_articles ) ) {
    $related_articles = wp_list_pluck( $post->related_articles, 'id' );

    if( function_exists( 'update_field' ) ) {
      update_field( 'related_articles', $related_articles, $post_id );
    } else {
      add_post_meta( $post_id, 'related_articles', $related_articles, true );
    }
  }

  if( $secondary_image = $post->featured_image_secondary ) {
    if( function_exists( 'update_field' ) ) {
      update_field( 'featured_image_secondary', $secondary_image->id, $post_id );
    } else {
      add_post_meta( $post_id, 'featured_image_secondary', $secondary_image->id, true );
    }
  }

  if( $acf = $post->acf ) {

    $fields = array(
      'paywall',
      'toc',
      'publication_name',
      'publication_source',
      'publication_publisher',
      'publication_adapted',
    );

    foreach( $fields as $field ) {

      if( function_exists( 'update_field' ) ) {
        update_field( $field, $post->{$field}, $post_id );
      } else {
        add_post_meta( $post_id, $field, $post->{$field}, true );
      }

    }

    // Sections
    if( function_exists( 'add_row' ) ) {

      if( $sections = $post->acf->sections ) {

        foreach( $sections as $section ) {

          $row = add_row( 'sections', $section );

        }

      }

    }

  }

}

/**
 * Add Posts from Post Content
 *
 * @uses jacobin_core_add_post()
 *
 * @param obj $posts
 * @return void
 */
function jacobin_core_add_posts( $posts ) {
  foreach( $posts as $post ) {
    jacobin_core_add_post( $post );
  }
}

/**
 * Get Post Term ID
 *
 * @param int $post
 * @param string $term
 * @param string $taxonomy
 */
function jacobin_core_get_post_term_id( $post, $term, $taxonomy ) {
  $term = get_term_by( 'slug', 'term', $taxonomy );
  return (int) $term->term_id;
}

/**
 * Add Post Terms
 *
 * @param obj $post
 * @return void
 */
function jacobin_core_add_post_terms( $post ) {
  $taxonomies = array(
    'categories'  => 'category',
    'tags'        => 'post_tag',
    'formats'     => 'format',
    'departments' => 'department',
    'series'      => 'series',
    'authors'     => 'author',
  );

  $post_id = $post->ID;

  foreach( $taxonomies as $key => $taxonomy ) {

    $terms = $post->{$key};

    if( !empty( $terms ) ) {

      foreach( $terms as $term ) {

        $term_id = get_term_by( 'slug', 'term', $taxonomy );
        wp_set_post_terms( $post_id, $term_id, $taxonomy, true  );

      }

    }

  }

}

/**
 * Post Exists
 *
 * @return mixed boolean false if no post exists; post ID otherwise.
 */
function post_exists_by_slug( $slug, $args = array() ) {
   $defaults = array(
       'post_type'      => 'post',
       'post_status'    => 'any',
       'name'           => $slug,
       'posts_per_page' => 1,
   );

   $post_args = wp_parse_args( $args, $defaults );

   $query = new WP_Query( $post_args );

   if ( ! $query->have_posts() ) {
       return false;
   } else {
       $query->the_post();
       return $query->post->ID;
   }
}
