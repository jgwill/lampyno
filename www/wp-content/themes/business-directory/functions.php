<?php
//Theme Setup
ob_start();
define('TEMPLATE_PATH', get_template_directory()); //Template directory path
define('TEMPLATEURL', get_template_directory_uri());
define('ADMINPATH', get_template_directory() . '/admin/');
define('ADMINURL', get_template_directory_uri() . '/admin/');
$headerimage = array(
    'default-image' => get_template_directory_uri() . '/images/headerbg.png'
);
add_theme_support("custom-header", $headerimage);
add_theme_support("custom-background");

function business_directory_add_style() {
    if (!is_admin()) {
        wp_enqueue_style('reset', get_template_directory_uri() . '/css/reset.css', '', '', 'all');
        wp_enqueue_style('stylesheet', get_stylesheet_uri(), '', '', 'all');
    }
}

add_action('wp_enqueue_scripts', 'business_directory_add_style');

function business_directory_get_option($name) {
    $options = get_option('business_directory_options');
    if (isset($options[$name]))
        return $options[$name];
}

function business_directory_update_option($name, $value) {
    $options = get_option('business_directory_options');
    $options[$name] = $value;
    return update_option('business_directory_options', $options);
}

function business_directory_delete_option($name) {
    $options = get_option('business_directory_options');
    unset($options[$name]);
    return update_option('business_directory_options', $options);
}

/**
 * Includes files from parent theme or child theme
 * @param type $files file name, array or string
 * @param type $path directory name, resides the file you are including
 */
function business_directory_do_include($files, $path = null) {
    $ext = '.php';
    if ($path !== null) {
        $parent = get_template_directory() . '/' . $path . '/';
        $child = get_stylesheet_directory() . '/' . $path . '/';
    } else {
        $parent = get_template_directory() . '/';
        $child = get_stylesheet_directory() . '/';
    }
    if (is_array($files) && !empty($files)) {
        foreach ($files as $file) {
            if (file_exists($child . $file . $ext)) {
                include_once ($child . $file . $ext);
            } elseif (file_exists($parent . $file . $ext)) {
                include_once ($parent . $file . $ext);
            } else {
                echo $file . $ext . __('not found', 'business-directory');
            }
        }
    } else {
        if (file_exists($child . $files . $ext)) {
            include_once ($child . $files . $ext);
        } elseif (file_exists($parent . $files . $ext)) {
            include_once ($parent . $files . $ext);
        } else {
            echo $files . $ext . __('not found', 'business-directory');
        }
    }
}

/**
 * These files build out the options interface.  
 * Likely won't need to edit these. 
 */
business_directory_do_include('admin_main', 'admin'); // manage theme filters in the file

/**
 * Include core library file 
 */
business_directory_do_include('lib_main', 'library'); // manage theme filters in the file
add_action('init', 'business_directory_migrate_option');

function business_directory_migrate_option() {
    if (get_option('business_directory_options') && !get_option('business_directory_option_migrate')) {
        $theme_option = array('business_directory_logo', 'business_directory_favicon', 'bodybg');
        $wp_upload_dir = wp_upload_dir();
        require ( ABSPATH . 'wp-admin/includes/image.php' );
        foreach ($theme_option as $option) {
            $option_value = business_directory_get_option($option);
            if ($option_value && $option_value != '') {
                $filetype = wp_check_filetype(basename($option_value), null);
                $image_name = preg_replace('/\.[^.]+$/', '', basename($option_value));
                $new_image_url = $wp_upload_dir['path'] . '/' . $image_name . '.' . $filetype['ext'];
                business_directory_import_file($new_image_url);
            }
        }
        update_option('business_directory_option_migrate', true);
    }
}

function business_directory_import_file($file, $post_id = 0, $import_date = 'file') {
    set_time_limit(120);
    // Initially, Base it on the -current- time.
    $time = current_time('mysql', 1);
//     Next, If it's post to base the upload off:
    $time = gmdate('Y-m-d H:i:s', @filemtime($file));
//     A writable uploads dir will pass this test. Again, there's no point overriding this one.
    if (!( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] )) {
        return new WP_Error('upload_error', $uploads['error']);
    }
    $wp_filetype = wp_check_filetype($file, null);
    extract($wp_filetype);
    if ((!$type || !$ext ) && !current_user_can('unfiltered_upload')) {
        return new WP_Error('wrong_file_type', __('Sorry, this file type is not permitted for security reasons.', 'business-directory')); //A WP-core string..
    }
    $file_name = str_replace('\\', '/', $file);
    if (preg_match('|^' . preg_quote(str_replace('\\', '/', $uploads['basedir'])) . '(.*)$|i', $file_name, $mat)) {
        $filename = basename($file);
        $new_file = $file;
        $url = $uploads['baseurl'] . $mat[1];
        $attachment = get_posts(array('post_type' => 'attachment', 'meta_key' => '_wp_attached_file', 'meta_value' => ltrim($mat[1], '/')));
        if (!empty($attachment)) {
            return new WP_Error('file_exists', __('Sorry, That file already exists in the WordPress media library.', 'business-directory'));
        }
        //Ok, Its in the uploads folder, But NOT in WordPress's media library.
        if ('file' == $import_date) {
            $time = @filemtime($file);
            if (preg_match("|(\d+)/(\d+)|", $mat[1], $datemat)) { //So lets set the date of the import to the date folder its in, IF its in a date folder.
                $hour = $min = $sec = 0;
                $day = 1;
                $year = $datemat[1];
                $month = $datemat[2];
                // If the files datetime is set, and it's in the same region of upload directory, set the minute details to that too, else, override it.
                if ($time && date('Y-m', $time) == "$year-$month") {
                    list($hour, $min, $sec, $day) = explode(';', date('H;i;s;j', $time));
                }
                $time = mktime($hour, $min, $sec, $month, $day, $year);
            }
            $time = gmdate('Y-m-d H:i:s', $time);
            // A new time has been found! Get the new uploads folder:
            // A writable uploads dir will pass this test. Again, there's no point overriding this one.
            if (!( ( $uploads = wp_upload_dir($time) ) && false === $uploads['error'] ))
                return new WP_Error('upload_error', $uploads['error']);
            $url = $uploads['baseurl'] . $mat[1];
        }
    } else {
        $filename = wp_unique_filename($uploads['path'], basename($file));
        // copy the file to the uploads dir
        $new_file = $uploads['path'] . '/' . $filename;
        if (false === @copy($file, $new_file))
            return new WP_Error('upload_error', sprintf(__('The selected file could not be copied to %s.', 'business-directory'), $uploads['path']));
        // Set correct file permissions
        $stat = stat(dirname($new_file));
        $perms = $stat['mode'] & 0000666;
        @ chmod($new_file, $perms);
        // Compute the URL
        $url = $uploads['url'] . '/' . $filename;
        if ('file' == $import_date)
            $time = gmdate('Y-m-d H:i:s', @filemtime($file));
    }
    //Apply upload filters
    $return = apply_filters('wp_handle_upload', array('file' => $new_file, 'url' => $url, 'type' => $type));
    $new_file = $return['file'];
    $url = $return['url'];
    $type = $return['type'];
    $title = preg_replace('!\.[^.]+$!', '', basename($file));
    $content = '';

    if ($time) {
        $post_date_gmt = $time;
        $post_date = $time;
    } else {
        $post_date = current_time('mysql');
        $post_date_gmt = current_time('mysql', 1);
    }

    // Construct the attachment array
    $attachment = array(
        'post_mime_type' => $type,
        'guid' => $url,
        'post_parent' => $post_id,
        'post_title' => $title,
        'post_name' => $title,
        'post_content' => $content,
        'post_date' => $post_date,
        'post_date_gmt' => $post_date_gmt
    );
    $attachment = apply_filters('afs-import_details', $attachment, $file, $post_id, $import_date);
    //Win32 fix:
    $new_file = str_replace(strtolower(str_replace('\\', '/', $uploads['basedir'])), $uploads['basedir'], $new_file);
    // Save the data
    $id = wp_insert_attachment($attachment, $new_file, $post_id);
    if (!is_wp_error($id)) {
        $data = wp_generate_attachment_metadata($id, $new_file);
        wp_update_attachment_metadata($id, $data);
    }
    //update_post_meta( $id, '_wp_attached_file', $uploads['subdir'] . '/' . $filename );

    return $id;
}

ob_clean();

function business_directory_tracking_admin_notice() {
    global $current_user;
    $user_id = $current_user->ID;
    /* Check that the user hasn't already clicked to ignore the message */
    if (!get_user_meta($user_id, 'wp_email_tracking_ignore_notice')) {
        ?>
        <div class="updated um-admin-notice"><p><?php _e('Allow Business-directory theme to send you setup guide? Opt-in to our newsletter and we will immediately e-mail you a setup guide along with 20% discount which you can use to purchase any theme.', 'business-directory'); ?></p><p><a href="<?php echo get_template_directory_uri() . '/admin/smtp.php?wp_email_tracking=email_smtp_allow_tracking'; ?>" class="button button-primary"><?php _e('Allow Sending', 'business-directory'); ?></a>&nbsp;<a href="<?php echo get_template_directory_uri() . '/admin/smtp.php?wp_email_tracking=email_smtp_hide_tracking'; ?>" class="button-secondary"><?php _e('Do not allow', 'business-directory'); ?></a></p></div>
        <?php
    }
}

add_action('admin_notices', 'business_directory_tracking_admin_notice');

/**
 * Enqueue script for custom customize control.
 */
function theme_slug_custom_customize_enqueue() {
    wp_enqueue_style('customizer-css', get_stylesheet_directory_uri() . '/admin/customizer.css');
}

add_action('customize_controls_enqueue_scripts', 'theme_slug_custom_customize_enqueue');

/**
 * Include welcome page
 */
require_once get_template_directory() . '/includes/features/feature-about-page.php';

/*
 * Redirect to about us page.
 */
if (is_admin() && isset($_GET['activated']) && $pagenow == "themes.php")
    wp_redirect('themes.php?page=business-directory-welcome');