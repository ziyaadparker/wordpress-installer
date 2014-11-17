<?php

$data       = array();
$errors     = array();
$dberrors   = array();

if( empty($_POST['installation_type']) || $_POST['installation_type'] == '' ){
    $errors['1_installation_type'] = '<strong>Installation Type:</strong> An installation type is required.';
}

if( empty( $_POST['create_folder'] ) ){
    $errors['3_create_folder'] = '<strong>Create Folder:</strong> You need to create a folder.';
} elseif( file_exists( '../../' . $_POST['create_folder'] ) ) {
    $errors['3_create_folder_exists'] = '<strong>Create Folder:</strong> A folder named "' . $_POST['create_folder'] . '" already exists.';
}

if( empty( $_POST['database_host'] ) ){
    $errors['4_database_host'] = '<strong>Create Database:</strong> A database host is required.';
}

if( empty( $_POST['database_name'] ) ){
    $errors['5_database_name'] = '<strong>Database Name:</strong> A database name is required.';
}

if( empty( $_POST['database_user'] ) ){
    $errors['6_database_user'] = '<strong>Database User:</strong> A database user is required.';
}

if( empty( $_POST['database_pass'] ) ){
    $errors['7_database_pass'] = '<strong>Database Password:</strong> A database password is required.';
}

if( !empty( $_POST['database_host'] ) && !empty( $_POST['database_user'] ) && !empty( $_POST['database_pass'] ) ){
    $link = false;
    
    if( $_POST['create_database'] == 'true' ){
        $link = @mysqli_connect( $_POST['database_host'], $_POST['database_user'], $_POST['database_pass'] );
    } else {
        $link = @mysqli_connect( $_POST['database_host'], $_POST['database_user'], $_POST['database_pass'], $_POST['database_name'] );
    }

    if( !$link && $_POST['create_database'] == 'true' ){
        $dberrors['message'] = '<strong>Error establishing database connection.</strong>';
        $dberrors['creds'] = 'true';
    } elseif( !$link && $_POST['create_database'] == 'false' ){
        $dberrors['message'] = '<strong>Error establishing database connection.</strong>';
        $dberrors['dbName'] = 'true';
        $dberrors['creds'] = 'true';
    }
    
    $db_exists = @mysqli_select_db( $link, $_POST['database_name'] );
    if( $link && $_POST['create_database'] == 'true' && $db_exists ){
        $dberrors['message'] = '<strong>Database Name:</strong> A database named "' . $_POST['database_name'] . '" already exists.';
        $dberrors['dbName'] = 'true';
    }
    
    if( $link ){
        mysqli_close( $link );
    }

}

if( empty( $_POST['table_prefix'] ) ){
    $errors['9_table_prefix'] = '<strong>Table Prefix:</strong> A database table prefix is required.';
}

if( !empty($errors) || !empty($dberrors) ) {

    $data['outcome'] = 'errors';
    $data['errors']  = $errors;
    $data['dberrors']  = $dberrors;

} else {

    $data['outcome'] = 'success';
    $data['setup_process'] = true;

}
    
echo json_encode( $data );

?>