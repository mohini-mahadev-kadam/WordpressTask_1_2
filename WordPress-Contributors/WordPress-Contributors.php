<?php
/**
 * Plugin Name: Wordpress-Contributors Plugin
 * Plugin URI: https://Wordpress-Contributors.com/
 * Description: Displays the Contributors name.
 * Version: 1.0
 * Author: Mohini Kadam
 * Author URI: https://mohinikadam.com/
 **/

 // plugin short code

function get_contributor_list_shortcode() {


    $post_id = get_the_ID();
    $contributors = get_post_meta($post_id, 'contributors', true);
    $output = '';

    if (!empty($contributors)) {
        $output .= '<ul>';
        foreach ($contributors as $contributor_id) {

                $user_id = $contributor_id; // Replace with the user ID of the user you want to display the Gravatar for
                $avatar_size = 50; // Replace with the size of the avatar you want to display (in pixels)

                $avatar_url = get_avatar_url($user_id, array('size' => $avatar_size));
                $avatar_html = get_avatar($user_id, $avatar_size);
                ?>
                
<!--                
                <img src="<?php echo esc_attr($avatar_url); ?>" width="<?php echo esc_attr($avatar_size); ?>" height="<?php echo esc_attr($avatar_size); ?>" alt="User Gravatar">
                <?php //echo $avatar_html; ?> -->
    

                <?php
                    $contributor = get_user_by('ID', $contributor_id);
                    if ($contributor) {
                        $output .= '<li class="contributorsStyle">' .$avatar_html . $contributor->display_name . '</li>';
                    }
                }
                
                $output .= '</ul>';

    }

    return $output;
}
add_shortcode('contributor_list', 'get_contributor_list_shortcode');

// Add the meta box
function contributor_meta_box() {
    
    $current_user = wp_get_current_user();
    $roles = $current_user->roles;


    if ((current_user_can('edit_posts'))&&(in_array('administrator', $roles) || in_array('editor', $roles) || in_array('author', $roles))) {
        add_meta_box(
            'contributor-meta-box', // Meta box ID
            'Contributors', // Title of the meta box
            'contributor_meta_box_callback', // Callback function to display the meta box content
            'post', // Post type for which the meta box should be displayed
            'normal', // Context (where the meta box should be displayed)
            'default' // Priority (order in which the meta box should be displayed)
        );
    }
}
add_action('add_meta_boxes', 'contributor_meta_box');



// Display the meta box content
function contributor_meta_box_callback($post) {

    // Get the current user ID
    $user_id = get_current_user_id();

    // Get the list of users
    $users = get_users(array(
        'orderby' => 'display_name',
        'order' => 'ASC',
        'fields' => array('ID', 'display_name')
    ));

    
   // Output the content of the meta box
   echo '<label><b>Checkout the contributors</b></label>';
   echo "<br/>";
   
   foreach ($users as $user) {

        $isContributor="";
        if(isContributorPresent($user->ID))
        {
            $isContributor = "checked";
        }

       echo '<input type="checkbox" name="contributors[]" '.$isContributor.' value="' . $user->ID . '"> ' . $user->display_name . '<br>';
   }
    
}

function isContributorPresent($userID)
{
    $post_id = get_the_ID();
    $contributors = get_post_meta($post_id, 'contributors', true);

    if (!empty($contributors)) {
       
        foreach ($contributors as $contributor_id) {
            if ($userID == $contributor_id)
            {
                return true;
            }
            
        }

    }
    return false;
}


// Save the meta box data
function save_contributor_meta_box_data($post_id) {
    
    if (isset($_POST['contributors'])) {
        $contributors = array_map('absint', $_POST['contributors']);
        update_post_meta($post_id, 'contributors', $contributors);
    }
}

add_action('save_post', 'save_contributor_meta_box_data');


function my_plugin_enqueue_styles2() {
    wp_enqueue_style( 'contributor-plugin-custom-style', plugins_url( 'contributor-custom-style.css', __FILE__ ) );
  }
  add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_styles2' );
  