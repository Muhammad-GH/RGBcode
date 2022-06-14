<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */
 
 //Registered all the cdn here
wp_register_style('Bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
wp_enqueue_style('Bootstrap');

wp_register_script('Jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', null, null, true);
wp_enqueue_script('Jquery');

wp_register_script('Bootstrapjs', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', null, null, true);
wp_enqueue_script('Bootstrapjs');

wp_register_script('Font_Awesome', get_template_directory_uri().'/js/font-awesome.js', null, null, true);
wp_enqueue_script('Font_Awesome');

$translation_array = array( 'TemplateUrl' => get_template_directory_uri() );
//after wp_enqueue_script
wp_localize_script( 'My-Script', 'object_name', $translation_array );

wp_register_script('Custom_Js', get_template_directory_uri().'/js/custom.js', null, null, true);
wp_enqueue_script('Custom_Js');

//cdn registration Ends here


//Function to get the roles of current logedin user
function My_Get_Current_User_Roles()
{

    if (is_user_logged_in())
    {

        $user = wp_get_current_user();

        $roles = ( array )$user->roles;

        return $roles; 
        // This will return an array
        
    }
    else
    {

        return array();

    }

}

if (!function_exists('twentytwentytwo_support')):

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function twentytwentytwo_support()
    {

        // Add support for block styles.
        add_theme_support('wp-block-styles');

        // Enqueue editor styles.
        add_editor_style('style.css');

    }

endif;

add_action('after_setup_theme', 'twentytwentytwo_support');

if (!function_exists('twentytwentytwo_styles')):

    /**
     * Enqueue styles.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function twentytwentytwo_styles()
    {
        // Register theme stylesheet.
        $theme_version = wp_get_theme()->get('Version');

        $version_string = is_string($theme_version) ? $theme_version : false;
        wp_register_style('twentytwentytwo-style', get_template_directory_uri() . '/style.css', array() , $version_string);

        // Add styles inline.
        wp_add_inline_style('twentytwentytwo-style', twentytwentytwo_get_font_face_styles());

        // Enqueue theme stylesheet.
        wp_enqueue_style('twentytwentytwo-style');

    }

endif;

add_action('wp_enqueue_scripts', 'twentytwentytwo_styles');

if (!function_exists('twentytwentytwo_editor_styles')):

    /**
     * Enqueue editor styles.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function twentytwentytwo_editor_styles()
    {

        // Add styles inline.
        wp_add_inline_style('wp-block-library', twentytwentytwo_get_font_face_styles());

    }

endif;

add_action('admin_init', 'twentytwentytwo_editor_styles');

if (!function_exists('twentytwentytwo_get_font_face_styles')):

    /**
     * Get font face styles.
     * Called by functions twentytwentytwo_styles() and twentytwentytwo_editor_styles() above.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return string
     */
    function twentytwentytwo_get_font_face_styles()
    {

        return "
		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: normal;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri('assets/fonts/SourceSerif4Variable-Roman.ttf.woff2') . "') format('woff2');
		}

		@font-face{
			font-family: 'Source Serif Pro';
			font-weight: 200 900;
			font-style: italic;
			font-stretch: normal;
			font-display: swap;
			src: url('" . get_theme_file_uri('assets/fonts/SourceSerif4Variable-Italic.ttf.woff2') . "') format('woff2');
		}
		";

    }

endif;

if (!function_exists('twentytwentytwo_preload_webfonts')):

    /**
     * Preloads the main web font to improve performance.
     *
     * Only the main web font (font-style: normal) is preloaded here since that font is always relevant (it is used
     * on every heading, for example). The other font is only needed if there is any applicable content in italic style,
     * and therefore preloading it would in most cases regress performance when that font would otherwise not be loaded
     * at all.
     *
     * @since Twenty Twenty-Two 1.0
     *
     * @return void
     */
    function twentytwentytwo_preload_webfonts()
    {
?>
		<link rel="preload" href="<?php echo esc_url(get_theme_file_uri('assets/fonts/SourceSerif4Variable-Roman.ttf.woff2')); ?>" as="font" type="font/woff2" crossorigin>
		<?php
    }

endif;

add_action('wp_head', 'twentytwentytwo_preload_webfonts');

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';


//Function to create Short Code
function GenerateUserstable()
{
    if (My_Get_Current_User_Roles() [0] == "administrator")
    {
        $message = '<div class="container" >  
            <label>Sort By</label>
            <select style="margin-bottom:15px" id="roleid" onchange="load_data(1,this.value)" class="form-select" aria-label="Default select example">
                <option selected value="">Show all</option>
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="subscriber">Subscriber</option>
                <option value="author">Author</option>
                </select> 
                <br>

            <div class="table-responsive" id="pagination_data">  
            </div>  
            </div>';
    }
    else
    {

        $message = "<h3 style='color:red'> Only admin can view this table </h3>";
    }
    return $message;
}

//registering  shortcode
add_shortcode('users_table', 'GenerateUserstable');

?>