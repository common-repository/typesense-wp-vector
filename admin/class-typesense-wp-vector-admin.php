<?php
 if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://knowhalim.com
 * @since      1.0.0
 *
 * @package    Typesense_Wp_Vector
 * @subpackage Typesense_Wp_Vector/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Typesense_Wp_Vector
 * @subpackage Typesense_Wp_Vector/admin
 * @author     Knowhalim <knowhalimofficial@gmail.com>
 */
class Typesense_Wp_Vector_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/typesense-wp-vector-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/typesense-wp-vector-admin.js', array( 'jquery' ), $this->version, false );

	}

}

function tswp_add_admin_menu() {
    add_menu_page(
        'WP Vector Search Settings', // Page title
        'WP Vector Search', // Menu title
        'manage_options', // Capability required to see this option
        'tswp_wp_vector_search', // Menu slug
        'tswp_wp_vector_search_settings_page', // Function that outputs the settings page
        'dashicons-search' // Icon URL
    );
}
add_action('admin_menu', 'tswp_add_admin_menu');

function tswp_wp_vector_search_settings_page() {
    ?>
    <div class="wrap">
        <h1>WP Vector Search Settings</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('tswp_wp_vector_search_options');
            do_settings_sections('tswp_wp_vector_search');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function tswp_wp_vector_search_settings_init() {
    register_setting('tswp_wp_vector_search_options', 'tswp_wp_vector_search_options');

    add_settings_section(
        'tswp_wp_vector_search_section_api', // Section ID
        'Setup your Typesense Vector Search', // Title
        'tswp_wp_vector_search_section_api_cb', // Callback
        'tswp_wp_vector_search' // Page
    );

    add_settings_field(
        'tswp_field_api_key', // Field ID
        'OpenAI API Key', // Title
        'tswp_field_api_key_cb', // Callback
        'tswp_wp_vector_search', // Page
        'tswp_wp_vector_search_section_api', // Section
        ['label_for' => 'tswp_field_api_key'] // Array with additional arguments
    );

    add_settings_field('tswp_field_search_threshold', 'Search Threshold', 'tswp_field_search_threshold_cb', 'tswp_wp_vector_search', 'tswp_wp_vector_search_section_api', ['label_for' => 'tswp_field_search_threshold']);
    add_settings_field('tswp_field_typesense_url', 'Typesense Base URL', 'tswp_field_typesense_url_cb', 'tswp_wp_vector_search', 'tswp_wp_vector_search_section_api', ['label_for' => 'tswp_field_typesense_url']);
    add_settings_field('tswp_field_typesense_api_key', 'Typesense Search API Key', 'tswp_field_typesense_api_key_cb', 'tswp_wp_vector_search', 'tswp_wp_vector_search_section_api', ['label_for' => 'tswp_field_typesense_api_key']);
}
add_action('admin_init', 'tswp_wp_vector_search_settings_init');

function tswp_typesense_baseurl(){
	$options = get_option('tswp_wp_vector_search_options');
	$value=$options['tswp_field_typesense_url'];
	return $value;
}

function tswp_typesense_apikey(){
	$options = get_option('tswp_wp_vector_search_options');
	$value=$options['tswp_field_typesense_api_key'];
	return $value;
}

function tswp_typesense_threshold(){
	$options = get_option('tswp_wp_vector_search_options');
	$value=$options['tswp_field_search_threshold'];
	return $value;
}

function tswp_typesense_openaikey(){
	$options = get_option('tswp_wp_vector_search_options');
	$value=$options['tswp_field_api_key'];
	return $value;
}
function tswp_wp_vector_search_section_api_cb() {
    echo '<p>Configure the settings below. The threshold determines how strict you are with the result of the search. 1 being more flexible and 0.1 being the most strigent. In most cases, 0.8 or 0.7 is good enough. To display the search form in your website, use this shortcode <b>[tswp_search]</b></p>';
}

function tswp_field_api_key_cb($args) {
    $options = get_option('tswp_wp_vector_search_options');
    ?>
    <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="tswp_wp_vector_search_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo esc_attr($options[$args['label_for']] ?? ''); ?>" />
    <?php
}

function tswp_field_search_threshold_cb($args) {
    $options = get_option('tswp_wp_vector_search_options');
	//$value=$options['tswp_field_typesense_url'];
    ?>
    <select id="<?php echo esc_attr($args['label_for']); ?>" name="tswp_wp_vector_search_options[<?php echo esc_attr($args['label_for']); ?>]">
        <?php
        for ($i = 1; $i <= 10; $i++) {
            $value = $i / 10;
            echo '<option value="' . esc_attr($value) . '"' . selected(esc_attr($options[$args['label_for']] ?? ''), $value, false) . '>' . esc_html($value) . '</option>';
        }
        ?>
    </select>
    <?php
}

function tswp_field_typesense_url_cb($args) {
    $options = get_option('tswp_wp_vector_search_options');
    ?>
    <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="tswp_wp_vector_search_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo esc_attr($options[$args['label_for']] ?? ''); ?>" />
    <?php
}

function tswp_field_typesense_api_key_cb($args) {
    $options = get_option('tswp_wp_vector_search_options');
    ?>
    <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="tswp_wp_vector_search_options[<?php echo esc_attr($args['label_for']); ?>]" value="<?php echo esc_attr($options[$args['label_for']] ?? ''); ?>" />
    <?php
}


///////////////////////////////////////////////
//Generate vector
///////////////////////////////////////////////
//add_filter('cm_typesense_data_before_entry', 'tswp_format_usecase_data', 10, 4);
function tswp_vector_string_to_vector($raw_data ) {
	$apikey= tswp_typesense_openaikey();
    $url = 'https://api.openai.com/v1/embeddings';
    $body = wp_json_encode(array(
        'input' => $raw_data,
        'model' => 'text-embedding-3-small'
    ));
    $args = array(
        'body'        => $body,
        'timeout'     => '15000',
        'redirection' => '15',
        'httpversion' => '1.1',
        'blocking'    => true,
        'headers'     => array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.$apikey, // Ensure this is stored securely
        ),
        'cookies'     => array()
    );

    $response = wp_remote_post($url, $args);
	//wp_mail('webcreativemaster@gmail.com','The Embeddings',tswp_vector_array2vector($response));
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        return "Something went wrong: $error_message";
    } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true); // Decode the JSON response
        if (isset($data['data'][0]['embedding'])) {
            //return implode(', ', $data['data'][0]['embedding']);
            return $data['data'][0]['embedding'];
        } else {
            return "No embedding found in the response.";
        }
    }
}

function tswp_vector_array2vector($array){
	return implode(', ', $array);
}
add_filter('cm_typesense_data_before_entry', 'tswp_vector_format_post_data', 10, 4);
function tswp_vector_format_post_data($formatted_data, $raw_data, $object_id, $schema_name)
{
    if ($schema_name == 'post')
    {
		
		$post_content = get_post($object_id);
		$content = str_replace(PHP_EOL, '', wp_strip_all_tags($post_content->post_content));
		
        /*$terms = get_the_terms($object_id, 'ai-use-case-category');
        $genres = [];
        foreach ($terms as $term)
        {
            $genres[] = $term->name;
        }
        $formatted_data['ai-use-case-category'] = $genres;
        $business_challenge = get_the_terms($object_id, 'ai-use-case-category');
        $formatted_data['business_challenge'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', wp_strip_all_tags(get_post_meta($object_id, 'business_challenge', true)));
        $post_content = get_post($object_id);
        $content = str_replace(PHP_EOL, '', wp_strip_all_tags($post_content->post_content));

        $string = trim(get_the_title($object_id)) . ' ' . trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $content)) . ' ' . trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', wp_strip_all_tags(get_post_meta($object_id, 'business_challenge', true))));*/
		//$vec=tswp_vector_array2vector($data['data'][0]['embedding']);
		//wp_mail('webcreativemaster@gmail.com','Embedded',$vec);
		
		$vectors=tswp_vector_string_to_vector(str_replace(PHP_EOL, '', $formatted_data['post_content']));
        $formatted_data['vectors'] =$vectors;
		
		
        /*$formatted_data['url_origin'] = trim(str_replace(array(
            'http://',
            'https://'
        ) , '', get_site_url()) , '/');*/

    }

    return $formatted_data;
}

function tswp_vector_do_search($text) {
	$typesense_api = tswp_typesense_apikey();
	$threshold=tswp_typesense_threshold();
	$baseurl = rtrim(tswp_typesense_baseurl(),'/');
    // Assuming the function 'tswp_vector_string_to_vector' converts text to a vector and 'tswp_vector_array2vector' formats it for the API
    $vector = tswp_vector_array2vector(tswp_vector_string_to_vector($text));

    // Setup the API endpoint
    $url = $baseurl.'/multi_search?collection=post';

    // Prepare the body of the request
    $body = wp_json_encode(array(
        'searches' => array(
            array(
                'q' => '*',
                'vector_query' => "vectors:([".$vector."],distance_threshold:".$threshold.")"
            )
        )
    ));

    // Setup the arguments for wp_remote_post
    $args = array(
        'body'    => $body,
        'timeout' => 45, // Set a reasonable timeout
        'headers' => array(
            'X-TYPESENSE-API-KEY' => $typesense_api, // Your API Key
            'Content-Type' => 'application/json'
        )
    );

    // Perform the HTTP Post request
    $response = wp_remote_post($url, $args);

    // Check for errors in the response
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        return [];
    } else {
        // Retrieve and return the body of the response
		$response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true); // Decode the JSON response
        if (!empty($data['results'][0]['hits'])) {
			$post_details=[];
			foreach ($data['results'][0]['hits'] as $item){
				$hit=$item['document'];
            // Create an array with the desired fields
				$post_details[] = [
					'thumbnail'     => $hit['post_thumbnail_html'] ?? '', // Use empty string as default if not set
					'post_title'    => $hit['post_title'],
					'post_content'  => $hit['post_content'],
					'post_excerpt'  => $hit['post_excerpt'],
					'post_date'     => $hit['post_date'],
					'post_author'   => $hit['post_author'],
					'link'=>$hit['permalink']
				];
			}
            return $post_details;
		}
		return [];
    }
}


//add_filter('cm_typesense_enabled_taxonomy_for_post_type', 'tswp_vector_add_posttype_schema');
add_filter('cm_typesense_schema', 'tswp_vector_add_posttype_schema', 99, 2);
function tswp_vector_add_posttype_schema($schema, $name)
{
    if ($name == 'post')
    {
        $gpai_typesense_search_options = get_option('gpai_typesense_search_option_name'); // Array of All Options
        $dim_vector = 1536;
		
		$schema = [
            'name' => 'post',
            'fields' => [
                ['name' => 'post_content', 'type' => 'string'],
                ['name' => 'post_title', 'type' => 'string'],
                ['name' => 'post_type', 'type' => 'string'],
                ['name' => 'post_author', 'type' => 'string', 'facet' => true],
                ['name' => 'comment_count', 'type' => 'int64', 'sort' => true],
                ['name' => 'is_sticky', 'type' => 'int32', 'sort' => true],
                ['name' => 'post_excerpt', 'type' => 'string'],
                ['name' => 'post_date', 'type' => 'string'],
                ['name' => 'post_id', 'type' => 'string'],
                ['name' => 'post_modified', 'type' => 'string'],
                ['name' => 'permalink', 'type' => 'string'],
                ['name' => 'post_thumbnail', 'type' => 'string', 'optional' => true],
                ['name' => 'category', 'type' => 'string[]', 'facet' => true],
                ['name' => 'tags', 'type' => 'string[]', 'facet' => true],
                ['name' => 'cat_link', 'type' => 'string[]', 'optional' => true],
                ['name' => 'tag_links', 'type' => 'string[]', 'optional' => true],
                ['name' => 'post_thumbnail_html', 'type' => 'string', 'optional' => true],
                ['name' => 'sort_by_date', 'type' => 'int64', 'sort' => true],
                [
                    'name' => 'vectors',
                    'type' => 'float[]',
                    'index' => true,
                    'num_dim' => 1536,
                    'vec_dist' => 'cosine'
                ]
            ],
            'default_sorting_field' => 'sort_by_date'
        ];
    }

    return $schema;
}
/*
By default, the length of the embedding vector will be 1536 for text-embedding-3-small or 3072 for text-embedding-3-large. You can reduce the dimensions of the embedding by passing in the dimensions parameter without the embedding losing its concept-representing properties. We go into more detail on embedding dimensions in the embedding use case section.
Source: https://platform.openai.com/docs/guides/embeddings/how-to-get-embeddings
*/
//add_filter('cm_typesense_schema', 'cm_typesense_add_usecase_schema', 10, 2);

function tswp_format_usecase_data($formatted_data, $raw_data, $object_id, $schema_name)
{
    if ($schema_name == 'ai-use-case')
    {
        $terms = get_the_terms($object_id, 'ai-use-case-category');
        $genres = [];
        foreach ($terms as $term)
        {
            $genres[] = $term->name;
        }
        $formatted_data['ai-use-case-category'] = $genres;
        $business_challenge = get_the_terms($object_id, 'ai-use-case-category');
        $formatted_data['business_challenge'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', wp_strip_all_tags(get_post_meta($object_id, 'business_challenge', true)));
        $post_content = get_post($object_id);
        $content = str_replace(PHP_EOL, '', wp_strip_all_tags($post_content->post_content));

        $string = trim(get_the_title($object_id)) . ' ' . trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $content)) . ' ' . trim(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', wp_strip_all_tags(get_post_meta($object_id, 'business_challenge', true))));
        $formatted_data['vectors'] = gpai_string_to_vector(str_replace(PHP_EOL, '', $string));
        $formatted_data['url_origin'] = trim(str_replace(array(
            'http://',
            'https://'
        ) , '', get_site_url()) , '/');

    }

    return $formatted_data;
}