<?php
add_action( 'admin_menu', 'ape_add_admin_menu' );
add_action( 'admin_init', 'ape_settings_init' );


function ape_add_admin_menu() {

  add_menu_page( 'Awesome Post Embeds', 'Awesome Post Embeds', 'manage_options', 'awesome_post_embeds', 'ape_options_page', 'dashicons-editor-code' );

}

function ape_settings_init() {

  register_setting( 'pluginPage', 'ape_settings' );

  add_settings_section(
    'ape_pluginPage_section',
    __( 'Shortcode Generator', 'wordpress' ),
    'ape_settings_section_callback',
    'pluginPage'
  );

  add_settings_field(
    'ape_blog_url',
    __( 'Blog URL', 'wordpress' ),
    'ape_blog_url_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_post_count_number',
    __( 'Number of Posts', 'wordpress' ),
    'ape_post_count_number_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_image',
    __( 'Exclude Image?', 'wordpress' ),
    'ape_image_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_category_slug',
    __( 'Category Slug', 'wordpress' ),
    'ape_category_slug_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_tag_slug',
    __( 'Tag Slug', 'wordpress' ),
    'ape_tag_slug_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_title',
    __( 'Exclude Title?', 'wordpress' ),
    'ape_title_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_excerpt',
    __( 'Exclude Excerpt?', 'wordpress' ),
    'ape_excerpt_render',
    'pluginPage',
    'ape_pluginPage_section'
  );

  add_settings_field(
    'ape_new_tab',
    __( 'Open Links in Same Tab?', 'wordpress' ),
    'ape_new_tab_render',
    'pluginPage',
    'ape_pluginPage_section'
  );


}


function ape_blog_url_render() {

  $options = get_option( 'ape_settings' );
  ?>
  <input type='text' name='ape_settings[ape_blog_url]' value='<?php echo $options['ape_blog_url']; ?>'> <label>Your shortcode will not work unless you supply a blog url. <strong>"http://" or "https://" is required</strong> – ie. http://mywordpressblog.com</label>
  <?php

}


function ape_post_count_number_render() {

  $options = get_option( 'ape_settings' );
  ?>
  <input type='number' name='ape_settings[ape_post_count_number]' value='<?php echo $options['ape_post_count_number']; ?>'> <label>Post count defaults to 3. Leave this blank if that is correct.</label>
  <?php

}


function ape_image_render() {

  $options = null !== get_option( 'ape_settings' );
  ?>
  <input type='checkbox' name='ape_settings[ape_image]' <?php checked( $options['ape_image'], 1 ); ?> value='1'> <label>Featured images are included by default. Check this to exclude them.</label>
  <?php

}


function ape_image_size_render() {

  $options = get_option( 'ape_settings' );
  ?>
  <input type='text' name='ape_settings[ape_image_size]' value='<?php echo $options['ape_image_size']; ?>'> <label>Image size is set to "full" by default. You may choose a different size by entering one of the following: <strong>thumbnail</strong>, <strong>medium</strong>, <strong>medium_large</strong>, or <strong>large</strong></label>
  <?php

}


function ape_category_slug_render() {

  $options = get_option( 'ape_settings' );
  ?>
  <input type='text' name='ape_settings[ape_category_slug]' value='<?php echo $options['ape_category_slug']; ?>'> <label>Input slug for your category. You can find it in the blog's URL – ie. http://yourblogname.com/category/<strong>category-slug</strong></label>
  <?php

}


function ape_tag_slug_render() {

  $options = get_option( 'ape_settings' );
  ?>
  <input type='text' name='ape_settings[ape_tag_slug]' value='<?php echo $options['ape_tag_slug']; ?>'> <label>Input slug for your tag. You can find it in the blog's URL – ie. http://yourblogname.com/tag/<strong>tag-slug</strong></label>
  <?php

}


function ape_title_render() {

  $options = null !== get_option( 'ape_settings' );
  ?>
  <input type='checkbox' name='ape_settings[ape_title]' <?php checked( $options['ape_title'], 1 ); ?> value='1'> <label>Title is included by default. Check this to exclude it.</label>
  <?php

}


function ape_excerpt_render() {

  $options = null !== get_option( 'ape_settings' );
  ?>
  <input type='checkbox' name='ape_settings[ape_excerpt]' <?php checked( $options['ape_excerpt'], 1 ); ?> value='1'> <label>Excerpt is included by default. Check this to exclude it.</label>
  <?php

}


function ape_new_tab_render() {

  $options = null !== get_option( 'ape_settings' );
  ?>
  <input type='checkbox' name='ape_settings[ape_new_tab]' <?php checked( $options['ape_new_tab'], 1 ); ?> value='1'> <label>Links open in new tab by default. Check this to disable this functionality.</label>
  <?php

}


function ape_settings_section_callback() {

  echo __( 'Edit the information you wish to include in your shortcode. Click the "Generate" button and copy &amp; paste the shortcode into your desired post or page.', 'wordpress' );

}

function ape_options_page(  ) {
  $shortcode_vals = array(
    'url' => 'ape_blog_url',
    'count' => 'ape_post_count_number',
    'image' => 'ape_image',
    'image_size' => 'ape_image_size',
    'category' => 'ape_category_slug',
    'tag' => 'ape_tag_slug',
    'title' => 'ape_title',
    'excerpt' => 'ape_excerpt',
    'new_tab' => 'ape_new_tab',
  );

  $shortcode_args = '[ape_posts';
  foreach( $shortcode_vals as $key=>$value ) {
    if( !empty( $_POST['ape_settings'][$value] ) ) {
      $shortcode_val = $_POST['ape_settings'][$value];
      if( $shortcode_val == '1' && $key != 'count' ) {
        $shortcode_args .= " $key=\"false\" ";
      }else{
        $shortcode_args .= " $key=\"$shortcode_val\" ";
      }
    }
  }
  $shortcode_args .= ']';

  ?>
  <form action='' method='post' class="ape_shortcode_generator">

    <h1>Awesome Post Embeds</h1>

    <?php
    settings_fields( 'pluginPage' );
    do_settings_sections( 'pluginPage' );
    submit_button( 'Generate Shortcode' );
    ?>

    <div class="ape_generated">
      <?php echo $shortcode_args; ?>
    </div>

  </form>
  <?php

}
