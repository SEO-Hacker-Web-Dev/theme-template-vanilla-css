<?php
/**
 * Prevent uploading media files with duplicate file names in the Media Library.
 * If a file with the same name exists, prompt the user and block the upload.
 */
add_filter('wp_handle_upload_prefilter', function ($file) {
    // Only check in admin (Media Library)
    if (!is_admin()) {
        return $file;
    }

    $filename = $file['name'];
    $uploads = wp_upload_dir();
    $upload_path = $uploads['path'] . '/' . $filename;

    // Check if file already exists in uploads directory
    if (file_exists($upload_path)) {
        $file['error'] = __('A file with the same name already exists in the Media Library. Please rename your file before uploading.', 'theme_setup');
    }

    return $file;
});