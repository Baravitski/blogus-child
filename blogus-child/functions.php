<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('chld_thm_cfg_locale_css')) {
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css')) {
            $uri = get_template_directory_uri() . '/rtl.css';
        }
        return $uri;
    }
}
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('chld_thm_cfg_parent_css')) {
    function chld_thm_cfg_parent_css()
    {
        wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array('bootstrap'));
    }
}
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10);

function register_genre_filter_widget()
{
    register_widget('Genre_Filter_Widget');
}
add_action('widgets_init', 'register_genre_filter_widget');

class Genre_Filter_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_options = array(
            'classname' => 'genre-filter-widget',
            'description' => 'Filter posts by genre'
        );
        parent::__construct('genre_filter_widget', 'Genre Filter Widget', $widget_options);
    }

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];

        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
?>
        <div class="sidebar">
            <label for="genre-dropdown">Select Genre:</label>
            <select id="genre-dropdown">
                <option value="">All Genres</option>
                <?php
                // Get all unique genres from the posts
                $genres = get_terms('genre');
                foreach ($genres as $genre) {
                    echo '<option value="' . $genre->slug . '">' . $genre->name . '</option>';
                }
                ?>
            </select>
        </div>
<?php
        echo $args['after_widget'];
    }
}

// Hook into the ACF save post event
add_action('acf/save_post', 'fetch_book_info_from_api');

function fetch_book_info_from_api($post_id)
{
    // Get the ISBN value from the saved post
    $isbn = get_field('isbn', $post_id);

    // Check if the transient exists
    $transient_key = 'book_info_' . $isbn;
    $book_info = get_transient($transient_key);

    if (!$book_info) {
        // Transient does not exist or has expired, make API request
        $api_url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;
        $response = wp_remote_get($api_url);

        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            // Check if the API response contains book information
            if (isset($data['items'][0]['volumeInfo'])) {
                $book_info = $data['items'][0]['volumeInfo'];

                // Cache the API response for a day in seconds
                set_transient($transient_key, $book_info, 86400);
            }
        }
    }

    if ($book_info) {
    // Check and update the 'title' field
    if (empty(get_field('title', $post_id))) {
        update_field('title', $book_info['title'], $post_id);
    }
	
	// Check and update the 'genre' field
	if (empty($book_info['categories'])) {		
		update_field('genre', json_decode(get_field('genre', $post_id)), $post_id);
	} else {
		update_field('genre', $book_info['categories'], $post_id);
	}	
	
	// Check and update the 'genre' field
	if (empty($book_info['authors'])) {		
		update_field('authors', json_decode(get_field('authors', $post_id)), $post_id);
	} else {
		update_field('authors', $book_info['authors'], $post_id);
	}
	
    // Check and update the 'publisher' field
    if (empty(get_field('publisher', $post_id))) {
        update_field('publisher', $book_info['publisher'], $post_id);
    }

    // Check and update the 'date' field
    if (empty(get_field('date', $post_id))) {
        update_field('date', $book_info['publishedDate'], $post_id);
    }

    // Check and update the 'description' field
    if (empty(get_field('description', $post_id))) {
        update_field('description', $book_info['description'], $post_id);
    }

    // Check and update the 'cover' field
    if (empty(get_field('cover', $post_id))) {
        update_field('cover', $book_info['imageLinks']['thumbnail'], $post_id);
    }
}

}
