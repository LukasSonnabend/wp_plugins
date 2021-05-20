<?php
/*
Plugin Name: WooCommerce Category Stories
Plugin URI: 
Description: 
Version: 0.1
Author: Lukas Sonnabend
Author URI: https://github.com/LukasSonnabend/
License: MIT
License URI: 
*/
// Hook the 'wp_footer' action hook, add the function named 'mfp_Add_Text' to it
add_action("wp_head", "show_stories");
add_action('admin_menu', 'myplugin_register_options_page'); 


function myplugin_register_settings() {
	add_option( 'myplugin_option_name', 'This is my option value.');
	add_option( 'cat_names', ["Decor", "Music"]);
	register_setting( 'myplugin_options_group', 'cat_names', 'myplugin_callback' );
  register_setting( 'myplugin_options_group', 'myplugin_option_name', 'myplugin_callback' );
}
add_action( 'admin_init', 'myplugin_register_settings' );

function myplugin_register_options_page() {
  add_options_page('Page Title', 'Category Stories', 'manage_options', 'myplugin', 'myplugin_options_page');
}

function wpdocs_enqueue_custom_admin_style() {
  wp_register_style( 'stories_style', plugin_dir_url( __FILE__ ) . '/css/stories_style.css', false, '1.0.0' );
  wp_enqueue_style( 'stories_style' );
}

add_action( 'admin_enqueue_scripts', 'wpdocs_enqueue_custom_admin_style' ); 

// Define 'mfp_Add_Text'
function mfp_Add_Text()
{
 $terms = get_terms( 'product_cat', $args );
	foreach($terms as $key => $category) {
	  	echo '<a href="'.get_term_link($category).'">';
		echo $category->name;
		echo '</a>';
  }
}

function add_my_css_and_my_js_files(){
  #wp_enqueue_script('your-script-name', $this->urlpath  . '/your-script-filename.js', array('jquery'), '1.2.3', true);
  wp_enqueue_style( 'stories_style', plugins_url('/css/stories_style.css', __FILE__), false, '1.0.0', 'all');
}
  add_action('wp_enqueue_scripts', "add_my_css_and_my_js_files");


function show_stories()
{
  $active_cats = get_option('cat_names');
  


?>
<div class="category_stories_element">
<?php foreach($active_cats as $key => $cat_id) {
  $cat_name = get_the_category_by_ID($cat_id);
  $cat_link = '"' . get_category_link($cat_id) . '"';
  $thumbnail_id = get_term_meta( $cat_id, 'thumbnail_id', true );
  $image = wp_get_attachment_url( $thumbnail_id ); 

  // print the IMG HTML
  echo  "<div onclick='location.href={$cat_link}' class='stories_element'>
          <div class='story_bubble_backdrop'>
              <div class='story_bubble'>
                  <img src='{$image}' alt='' width='762' height='365' />
              </div>
            </div>
          <label>{$cat_name}</label>
        </div>"; 
} ?>
</div>
<?php

}



function myplugin_options_page()
{
	$terms = get_terms( 'product_cat', $args );

?>
  <div>
  <?php screen_icon(); ?>
  <!-- <h2>My Plugin Page Title</h2> -->
  <form method="post" action="options.php">
  <?php settings_fields( 'myplugin_options_group' ); ?>
  <h3>Set Categories</h3>
  <p>Choose Categories to show in Stories</p>
  <table>
	<?php 	foreach($terms as $key => $category) {
    $catName = $category->name;
    $catID = $category->term_id;
    $checked = in_array($catID, get_option('cat_names')) ? "checked" : "";
		echo "<input type='checkbox' id='{catNa}' name='cat_names[]' value='{$catID}' {$checked}/>";
		echo "<label for='{$catName}'>{$catName}</label><br/>";
  } ?>
  <tr valign="top">
  <th scope="row"><label for="myplugin_option_name">Label</label></th>
  <td><input type="text" id="myplugin_option_name" name="myplugin_option_name" value="<?php echo get_option('myplugin_option_name'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
  <div>
    <h2>Preview</h2>
    <?php show_stories() ?>
  </div>
<?php
}