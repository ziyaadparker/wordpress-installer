<!doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>WordPress Installer</title>

	<link type="text/css" rel="stylesheet" href="vendor/bootstrap/3.2.0/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="css/style.css">

    <!--[if lt IE 9]>
        <script src="vendor/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="vendor/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script type="text/javascript" src="vendor/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="vendor/angularjs/1.2.21/angular.min.js"></script>
    <script type="text/javascript" src="vendor/angularjs/lib/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="vendor/angularjs/lib/angular-animate.min.js"></script>
    <script type="text/javascript" src="js/app.min.js"></script>

</head>
<body ng-app="automate">
    
    <?php

        $update_available = false;
        if( version_compare( PHP_VERSION, '5.4.0', '>' ) ){

            $args = array(
                'http' => array(
                    'method' => 'GET',
                    'header' => 'User-Agent: wi'
                )
            );
            $context = stream_context_create( $args );
            $current_commits = file_get_contents( 'https://api.github.com/repos/iammathews/wordpress-installer/commits', false, $context );

            if( $current_commits ){
                $commits = json_decode( $current_commits );

                $current_commit_minus1 = $commits[1]->sha;
                $ref_commit = 'e315126730acb2f7e95ca3bd3b08951c9e191df8';

                if( strcmp( $current_commit_minus1, $ref_commit ) )
                    $update_available = true;
            }

        }
    
    ?>
    
    <header>

        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <span class="navbar-brand">WordPress Installer</span>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="main-nav">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li><a href="#" target="_blank">Getting Started</a></li> -->
                        <?php

                            if( $update_available )
                                echo '<li><a href="https://github.com/iammathews/wordpress-installer" target="_blank"><span class="badge">Update Available</span></a></li>';

                        ?>
                    </ul>
                </div>
            </div>
        </nav>

    </header>