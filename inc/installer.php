<?php

$processData    = array();
$processResults = array();

$download_ok  = false;
$done_zip = false;
$db_created = false;
$config_created = false;

include_once('functions.php');

// Download file
if( isset( $_POST['installation_type'] ) && $_POST['installation_type'] == 0 || $_POST['installation_type'] == 1 ){

    $download_ok = wi_download( $_POST['installation_type'], 'latest.zip' );
    if( $download_ok ){
        $processResults['1_download_file']['message'] = 'Downloaded WordPress successfully...';
        $processResults['1_download_file']['type'] = 'info';
    } else {
        $processResults['1_download_file']['message'] = 'Error downloading WordPress...';
        $processResults['1_download_file']['type'] = 'warning';
    }

}

// Extract zip
if( $download_ok ){

    $done_zip = wi_extract( 'latest.zip', $_POST['create_folder'] );
    if( $done_zip ){
        $processResults['2_extract_zip']['message'] = 'Unzipped into folder successfully...';
        $processResults['2_extract_zip']['type'] = 'info';
    } else {
        $processResults['2_extract_zip']['message'] = 'Error unzipping into folder...';
        $processResults['2_extract_zip']['type'] = 'warning';
    }

}

// Create database
if( isset( $_POST['create_database'] ) && $_POST['create_database'] == 'true' ){

    $db_created = wi_create_db( $_POST['database_host'], $_POST['database_name'], $_POST['database_user'], $_POST['database_pass'] );
    if( $db_created ){
        $processResults['3_creating_database']['message'] = 'Database created successfully...';
        $processResults['3_creating_database']['type'] = 'info';
    } else {
        $processResults['3_creating_database']['message'] = 'Error creating database...';
        $processResults['3_creating_database']['type'] = 'warning';
    }

}

// Create config
if( $download_ok && $done_zip ){

    $config_created = wi_create_config( $_POST['database_host'], $_POST['database_name'], $_POST['database_user'], $_POST['database_pass'], $_POST['table_prefix'], $_POST['create_folder'] );
    if( $config_created ){
        $processResults['4_creating_config']['message'] = 'Config created and database connected successfully...';
        $processResults['4_creating_config']['type'] = 'info';

        $processResults['5_run_install']['message'] = 'Setup completed... You can now run your install!';
        $processResults['5_run_install']['type'] = 'success';
    } else {
        $processResults['4_creating_config']['message'] = 'Error creating config and establishing database connection...';
        $processResults['4_creating_config']['type'] = 'warning';
    }

}

$processData['results'] = $processResults;

// Return URL
if( $config_created ){
    $processData['projectUrl'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . $_POST['create_folder'];
}

echo json_encode( $processData );
