<?php

// Enqueue style.css from child theme
define('script_version','0.5');
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style', get_stylesheet_directory_uri() . '/style.css',
	[
		'hello-elementor-theme-style',
	],
		'1.0.0'
	);

	// wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/custom.css', '1.0.0');
    // wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), script_version, 1);
    wp_enqueue_style('font-awesome',  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', '1.0.0');

    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), script_version, 1);
    wp_localize_script( 'custom', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    // wp_localize_script( 'custom', 'veh_app_script', $localize);
   
    // wp_localize_script( 'custom', 'ajax_url', admin_url( 'admin-ajax.php' ) );  
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function register_menus() {
  register_nav_menus(
    array(
      'left-menu' => __( 'Left Menu' ),
      'right-menu' => __( 'Right Menu' ),
      'mobile-menu' => __( 'Mobile Menu' ),
    )
  );
}
add_action( 'init', 'register_menus' );

// Define the shortcode function
function year_shortcode() {
  $year = date('Y');
  return $year;
}

// Register the shortcode
add_shortcode('year', 'year_shortcode');

// Create shortcodes for each month of the year
for ($i = 1; $i <= 12; $i++) {
  $month = date('F', mktime(0, 0, 0, $i, 1));
  $shortcode = strtolower($month);
  add_shortcode($shortcode, function() use ($month) {
    return $month;
  });
}

function user_login(){
    if( isset($_POST['rememberme']) ){
        $remember = true; 
    }else{
        $remember = false;  
    }
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $creds = array(
        'user_login'    => $email,
        'user_password' => $password,
        'remember'      => $remember
    );
    $userCheck = get_user_by('email' , $email );
    if($userCheck){
        $userAuthenticate = wp_check_password( $password, $userCheck->data->user_pass,$userCheck->data->ID);
    }else{
        echo 'emailNotFound';
        wp_die();
    }
    if(isset($userAuthenticate) && $userAuthenticate)
    {
        $user_data = array();
        $user = wp_signon( $creds, false );
        $current_user = wp_set_current_user($userCheck->data->ID);
        $profile_image = get_user_meta($current_user->data->ID, 'profile_image');
        if( (is_array($profile_image)) && (!empty($profile_image)) ){
            $logo_path = wp_upload_dir();
            $img_path =  $logo_path['baseurl'].'/'.$profile_image[0];
        }else{
            $directory_path = get_stylesheet_directory_uri();
            $img_path = $directory_path.'/assets/img/img_placeholder.png';
        }
        $user_data['img'] = $img_path;
        $json_arr = json_encode($user_data);
        print_r($json_arr);
        wp_die();
    }
    else
    {
        echo "passNotFound";
        wp_die();
    } 
}
add_action( 'wp_ajax_user_login', 'user_login' );
add_action( 'wp_ajax_nopriv_user_login', 'user_login' );

function user_registeration() {

    $username = strtolower($_POST['email']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = strtolower($_POST['email']);
    $country = $_POST['country'];
    $password = $_POST['user_password'];

    $userdata = array(
        'user_login' => $username,
        'user_pass' =>  $password,
        'user_nicename' => $username,
        'user_email' => $email,
        'first_name'  => $first_name,
        'last_name'  => $last_name,
        'role' => 'subscriber'
    );

    // print_r($userdata);
    // wp_die();
    
    $result = wp_insert_user($userdata);
    if(is_int($result)){
        $creds = array(
            'user_login'    => $email,
            'user_password' => $password,
            'remember'      => true
        );
        update_user_meta($result,'country',$country);
        $user = wp_signon( $creds, false );
        $current_user = wp_set_current_user($result);
        if($user && $current_user){
            $user_data = array(
                'result'        => 'user-logged-in'
            );
            $json_arr = json_encode($user_data);
            print_r($json_arr);
        }
    }elseif(!empty($result->errors)){
        $user_data = array(
            'result'    => 'user-email-already-available'
        );
        $json_arr = json_encode($user_data);
        print_r($json_arr);
    }
    wp_die();
}
add_action( 'wp_ajax_user_registeration', 'user_registeration' );
add_action( 'wp_ajax_nopriv_user_registeration', 'user_registeration' );

// Login User Cannot Access Login or Signup Page
function redirect_logged_in_users() {
    if (is_user_logged_in() && is_page('login') || is_page('signup')) {
        wp_redirect(home_url()); // Redirect logged-in users to the home page
        exit();
    }
}
add_action('template_redirect', 'redirect_logged_in_users');

// Top Header Prayer
function mosque_info_shortcode() {
    ob_start();
    ?>
    <ul class="mosque-info-container">
        <li><i class="far fa-map theme-clr"></i>New Orleans, Jamia Mosque</li>
        <li><i class="far fa-clock theme-clr"></i>Mon - Sat 8:00 - 18:00</li>
    </ul>
    <?php
    return ob_get_clean();
}
add_shortcode('mosque_info', 'mosque_info_shortcode');

function get_prayer_times_from_api() {
    // API endpoint URL
    $api_url = 'http://api.aladhan.com/v1/timingsByCity?city=London&country=United Kingdom&method=8';

    // Make the API request
    $response = wp_remote_get($api_url);

    // Check if the request was successful
    if (is_wp_error($response)) {
        return 'Error fetching prayer times.';
    }

    // Parse the JSON response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    // Extract prayer times data
    $times = $data->data->timings;

    // Times to exclude
    $exclude_times = ['Imsak', 'Midnight', 'Firstthird', 'Lastthird', 'Sunrise', 'Sunset'];

    // Icons for specific prayers
    $prayer_icons = [
        'Fajr' => '<i class="fa fa-sun-o" aria-hidden="true"></i>',
        'Dhuhr' => '<i class="fa fa-sun-o" aria-hidden="true"></i>',
        'Asr' => '<i class="fa fa-sun-o" aria-hidden="true"></i>',
        'Maghrib' => '<i class="fa fa-moon-o" aria-hidden="true"></i>',
        'Isha' => '<i class="fa fa-moon-o" aria-hidden="true"></i>'
    ];

    // Format and return the HTML table rows
    $formatted_times = "<tr>
        <th scope='col'>Salah</th>
        <th scope='col'>Time</th>
        <th scope='col'>Jammat</th>
    </tr>";

    foreach ($times as $prayer => $time) {
        // Exclude specified times
        if (!in_array($prayer, $exclude_times)) {
            // Add 15 minutes to the prayer time for Jamaat time
            $azan_time = date('h:i A', strtotime($time));
            $jamaat_time = date('h:i a', strtotime($time) + (15 * 60)); // 15 minutes in seconds

            // Add prayer icon if available
            $prayer_icon = isset($prayer_icons[$prayer]) ? $prayer_icons[$prayer] : '';

            $formatted_times .= "<tr>
                <td>{$prayer_icon}{$prayer}</td>
                <td>$azan_time</td>
                <td>$jamaat_time</td>
            </tr>";
        }
    }
    return $formatted_times;
}

function prayer_times_shortcode($atts) {
    // Get dynamic prayer times from the API
    $formatted_times = get_prayer_times_from_api();

    // Return the formatted HTML
    return '<div class="namaz-drp">
                <div class="dropdown show">
                        <div class="prayer-timing-button-container">
                            <img src="https://mlena6qa4grg.i.optimole.com/w:auto/h:auto/q:mauto/f:best/https://nauthemes.net/alim/wp-content/themes/alim/assets/images/mosque-icon.png" alt="">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Namaz Timings <i class="fa fa-caret-down" aria-hidden="true"></i>  </button>
                        </div>
                        <div class="prayer-table">
                            <table>
                                <tbody>' . $formatted_times . '</tbody>
                            </table>
                        </div>
                </div>
            </div>';
}
add_shortcode('prayer_times', 'prayer_times_shortcode');
