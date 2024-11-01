<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://knowhalim.com
 * @since      1.0.0
 *
 * @package    Typesense_Wp_Vector
 * @subpackage Typesense_Wp_Vector/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Typesense_Wp_Vector
 * @subpackage Typesense_Wp_Vector/public
 * @author     Knowhalim <knowhalimofficial@gmail.com>
 */
class Typesense_Wp_Vector_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Typesense_Wp_Vector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Typesense_Wp_Vector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/typesense-wp-vector-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Typesense_Wp_Vector_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Typesense_Wp_Vector_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/typesense-wp-vector-public.js', array( 'jquery' ), $this->version, false );

	}

}




function tswp_enqueue_scripts() {
    if (!wp_script_is('jquery', 'enqueued')) {
        wp_enqueue_script('jquery'); 
    }
}
add_action('wp_enqueue_scripts', 'tswp_enqueue_scripts');

function tswp_add_inline_script() {
	$nonce = wp_create_nonce('tswp_search_nonce');
    $ajax_url = esc_js(admin_url('admin-ajax.php'));
    $script = sprintf(
        'jQuery(document).ready(function($) {
            $("#tswp_search_button").click(function() {
                console.log("clicked");
                var searchTerm = $("#tswp_search_input").val();
                $.ajax({
                    url: "%s", // AJAX URL passed from PHP
                    type: "POST",
                    data: {
                        action: "tswp_do_search",
                        search: searchTerm,
						nonce: tswp_search_vars.nonce
                    },
                    success: function(response) {
                        $("#tswp_search_results").html(response);
                    }
                });
            });
        });',
        $ajax_url 
    );
	wp_add_inline_script('jquery', $script);
	//wp_add_inline_script('jquery', $script, 'before');
    wp_localize_script('jquery', 'tswp_search_vars', array(
        'nonce' => $nonce
    ));
    
}
add_action('wp_enqueue_scripts', 'tswp_add_inline_script');
$typesense_wp_vector_instance = new Typesense_Wp_Vector();

function tswp_search_form_shortcode() {
	$plugin = new Typesense_Wp_Vector();
	$pluginname = $plugin->get_plugin_name();
    ob_start();
    ?>
    <div id="tswp_search_form">
        <input type="text" id="tswp_search_input" name="search" placeholder="Enter search term...">
        <button id="tswp_search_button">Search</button>
    </div>
    <div id="tswp_search_results"></div>


    <?php
	
	$css = '
#tswp_search_form {
    display: flex; /* Use flexbox to align the children horizontally */
    width: 100%; /* Ensure the form takes full width of the container */
}

#tswp_search_input {
    flex-grow: 1; /* Allows the input to grow and fill the available space */
    margin-right: 10px; /* Optional: Adds some space between the input and the button */
}

#tswp_search_button {
    width: 150px; /* Fixed width for the button */
}
.tswp_grid-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Creates four columns */
	grid-gap:20px;
    margin-top: 20px; /* Space above the grid */
}

.tswp_grid-item {
    background: #f9f9f9; /* Light grey background for each item */
    border: 1px solid #ccc; /* Grey border */
    padding: 10px; /* Padding around the content */
    box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Subtle shadow for depth */
}

.tswp_grid-item img {
    max-width: 100%; /* Ensure images are not larger than their container */
    height: auto; /* Maintain aspect ratio */
}

.tswp_grid-item h2 {
    font-size: 18px; /* Slightly larger text for titles */
    margin-top: 0; /* Remove top margin */
}

/* Responsive Adjustments */
@media (max-width: 1200px) {
    .tswp_grid-container {
        grid-template-columns: repeat(3, 1fr); /* Three columns for larger tablets and small desktops */
    }
}

@media (max-width: 800px) {
    .tswp_grid-container {
        grid-template-columns: repeat(2, 1fr); /* Two columns for tablets */
    }
}

@media (max-width: 600px) {
    .tswp_grid-container {
        grid-template-columns: 1fr; /* One column for mobile */
    }
}
    ';
	
	
    
	
    //wp_enqueue_style($pluginname);
    wp_enqueue_style($pluginname, plugin_dir_url(__FILE__) . 'css/typesense-wp-vector-public.css', array(), $plugin->get_version(), 'all');
     
    wp_add_inline_style($pluginname, $css); 
    return ob_get_clean();
}
add_shortcode('tswp_search', 'tswp_search_form_shortcode');


function tswp_vector_do_search_process() {
	check_ajax_referer('tswp_search_nonce', 'nonce');
    $search = sanitize_text_field($_POST['search']);
    $post_details = tswp_vector_do_search($search);  // Assuming this function returns an array of post details

    if (!empty($post_details)) {
		echo '<div class="tswp_grid-container">'; // Start the grid container
		$allowed_tags = array(
				'img' => array(
					'width' => true,
					'height' => true,
					'src' => true,
					'class' => true,
					'alt' => true,
					'decoding' => true,
					'loading' => true,
					'srcset' => true,
					'sizes' => true,
				)
			);
		foreach ($post_details as $detail) {
			echo '<div class="tswp_grid-item">'; 
			echo wp_kses($detail['thumbnail'], $allowed_tags);
			echo '<h2>' . esc_html($detail['post_title']) . '</h2>';
			echo '<p>' . esc_html($detail['post_excerpt']) . '</p>';
			echo '<p>' . esc_html(substr($detail['post_content'], 0, 100)) . '</p>';
			echo '<a href="' . esc_url($detail['link']) . '">Read more</a>';
			echo '</div>'; 
		}


		echo '</div>'; // Close the grid container
	}
 	else {
        echo 'No results found.';
    }
    wp_die();  // Important: end AJAX request
}
add_action('wp_ajax_tswp_do_search', 'tswp_vector_do_search_process');  // If logged in
add_action('wp_ajax_nopriv_tswp_do_search', 'tswp_vector_do_search_process');  // If not logged in
