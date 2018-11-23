<?php
   /*
   Plugin Name: Awesome Post Embeds
   Plugin URI: https://github.com/jtomeck/awesome-post-embeds
   description: A plugin to easily embed posts from another Wordpress Blog using Wordpress's Rest API.
   Version: 1.0
   Author: Jared Tomeck
   Author URI: https://github.com/jtomeck
   License: GPL2
   */

/*
* INCLUDE PLUGIN STYLES
*/
function ape_enqueue_styles() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style',  $plugin_url . "/style.css");
}
add_action( 'wp_enqueue_scripts', 'ape_enqueue_styles' );

/*
* TAGS FUNCTION
* Make API request for tags slug and returns the ID
*/
function tag_id_from_slug( $api_url, $slug ) {
  $tag = json_decode ( file_get_contents( $api_url . "/tags?slug=$slug" ) );
  return $tag[0]->id;
}

/*
* CATEGORY FUNCTION
* Make API request for categories slug and returns the ID
*/
function category_id_from_slug( $api_url, $slug ) {
  $category = json_decode ( file_get_contents( $api_url . "/categories?slug=$slug" ) );
  return $category[0]->id;
}

/*
* FEATURED MEDIA FUNCTION
* Make API request for featured media url
*/
function embed_url_from_post( $post, $size='medium' ) {
  if( isset( $post->_links->{'wp:featuredmedia'} ) ) {
    $media = json_decode (
      file_get_contents( $post->_links->{'wp:featuredmedia'}[0]->href )
    );
    return $media->media_details->sizes->$size->source_url;
  }else{
    return "https://imgplaceholder.com/420x320/f2f6f8/c6d1d6/glyphicon-picture?font-size=72";
  }
}

/*
* AWESOME POST EMBEDS MAIN FUNCTION
*
* Build shortcode keys and values as well as building the
* structure of what is returned
*/
function ape_posts_func( $atts ) {

  // build shortcode attributes
  $atts = shortcode_atts( array(
    // URL constructors
    'url' => '',
    'count' => 3,
    'image' => true,
    'tag' => '',
    'category' => '',

    // Post scructure constructors
    'title' => true,
    'excerpt' => true,
    'new_tab' => true,
    'image_size' => 'full',
  ), $atts, 'ape_posts' );

  // ob_start to allow returning of multiple lines of PHP/HTML
  ob_start();

    // Set up query for http_build_query
    $rest_query = array(
      'per_page' => $atts['count']
    );

    // If user includes a tag, run function to make API request for tag
    if( $atts['tag'] ) {
      $rest_query['tags'] = tag_id_from_slug( $atts['url'] . "/wp-json/wp/v2", $atts['tag'] );
    }

    // If user includes a category, run function to make API request for category
    if( $atts['category'] ) {
      $rest_query['categories'] = category_id_from_slug( $atts['url'] . "/wp-json/wp/v2", $atts['category'] );
    }

    if( $atts['url'] ) { // Require a URL in shortcode

      // Set variable for building wp-json URL
      $query_url = $atts['url'] . "/wp-json/wp/v2/posts?" . http_build_query( $rest_query );

      // Build wp-json URL
      $blog_posts = json_decode( file_get_contents( $query_url ) ); ?>

      <div id="awesome_post_embed" class="ape_posts_container">
        <div class="ape_posts_wrapper">

          <?php foreach ( $blog_posts as $blog_post ) : ?>

            <div class="ape_post">

              <?php if( $atts['image'] == true ) : ?>
                <div class="ape_post_image_wrapper">
                  <?php if( ( $image_src = embed_url_from_post( $blog_post, $atts['image_size'] ) ) != null ) : ?>
                    <a href="<?php echo $blog_post->link; ?>" <?php if( $atts['new_tab'] == true ) { echo 'target="_blank"'; } ?> >
                      <img src="<?php echo $image_src; ?>" class="ape_post_image">
                    </a>
                  <?php endif ?>
                </div>
              <?php endif; //if image ?>

              <?php if( $atts['title'] == true || $atts['excerpt'] == true ) : ?>
                <div class="ape_post_content">

                  <?php if( $atts['title'] == true ) : ?>
                    <h3 class="ape_post_title">
                      <a href="<?php echo $blog_post->link; ?>" <?php if( $atts['new_tab'] == true ) { echo 'target="_blank"'; } ?> >
                        <?php echo $blog_post->title->rendered; ?>
                      </a>
                    </h3>
                  <?php endif; //if title ?>

                  <?php if( $atts['excerpt'] == true ) : ?>
                    <p><?php echo $blog_post->excerpt->rendered; ?></p>
                  <?php endif; //if excerpt ?>
                </div>

              <?php endif; //if excerpt or title ?>
            </div>

          <?php endforeach; ?>

        </div>
      </div>
    <?php }else{
      return '<p>You need to specify a URL to the blog whose posts you would like to embed (using <strong>url="yourblogname.com"</strong> in your shortcode).</p>';
    }
  return ob_get_clean(); // end ob_start
} //end ape_posts_func
add_shortcode( 'ape_posts', 'ape_posts_func' );
