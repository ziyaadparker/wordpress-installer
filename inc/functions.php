<?php

// Download file
function wi_download( $remote_url, $local_file ){

    $content = file_get_contents( $remote_url );
    file_put_contents( '../tmp/' . $local_file, $content );
    return true;

}

// Extract zip
function wi_extract( $zip_file, $folder ){

    $zip = new ZipArchive();
    if ( $zip->open( '../tmp/' . $zip_file ) !== true ) {
        return false;
    }
    $zip->extractTo( '../tmp/' );
    $zip->close();
    rename( '../tmp/wordpress', '../../' . $folder );
    return true;

}

// Create database
function wi_create_db( $server, $db_name, $user, $pass ){
    
    $link = @mysqli_connect( $server, $user, $pass );
    $sql = 'CREATE DATABASE ' . $db_name;
    if( mysqli_query( $link, $sql ) ){
        return true;
    } else {
        return false;
    }

}

// Create config
function wi_create_config( $db_host, $db_name, $db_user, $db_pass, $table_prefix, $folder ){

    $config_sample = file_get_contents( '../../' . $folder . '/wp-config-sample.php' );
    $fields_default = array(
        'database_name_here',
        'username_here',
        'password_here',
        'localhost',
        '$table_prefix  = \'wp_\';'
    );
    $fields_custom = array(
        $db_name,
        $db_user,
        $db_pass,
        $db_host,
        '$table_prefix  = \'' . $table_prefix . '\';'
    );
    $config = str_replace( $fields_default, $fields_custom, $config_sample );

    file_put_contents( '../../' . $folder . '/wp-config.php', $config );
    return true;

}
