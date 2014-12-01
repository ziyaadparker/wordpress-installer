<?php
/**
 * WordPress Installer
 *
 * @package     WordPress Installer
 * @author      Yusri Mathews <yo@yusrimathews.co.za>
 * @license     GPL-2.0+
 * @link        https://bitbucket.org/yusrimathews/automate-wordpress-install
 * @copyright   2014 Yusri Mathews
 */
?>

<?php

    require_once 'layout/header.php';

    /**
     * Check PHP Version
     */
    if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ){
        echo '<section class="container">';
            echo '<div class="row">';
                echo '<div class="col-md-6 col-md-offset-3">';
                    echo '<div class="callout callout-warning" role="alert">';
                        echo '<h4>PHP Warning!</h4>';
                        echo '<p>You require at least PHP 5.4.0 in order to get the full functionality of this automation. Simply, update to the latest version of <a href="http://www.wampserver.com/en/" target="_blank">WAMP</a>, <a href="http://www.mamp.info/en/" target="_blank">MAMP</a> or <a href="https://www.apachefriends.org/index.html" target="_blank">XAMP</a>.</p>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</section>';
    } else {

?>

    <section class="container" ng-controller="FormController as form">

        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <div class="alert alert-warning" role="alert" ng-show="warningAlert" ng-bind-html="warningAlert"></div>
                <div class="alert alert-danger" role="alert" ng-show="errorAlert">
                    <ul>
                        <li ng-repeat="alert in errorAlert" ng-bind-html="alert"></li>
                    </ul>
                </div>
                <div class="alert alert-danger" role="alert" ng-show="DBerrorAlert" ng-bind-html="DBerrorAlert.message"></div>

                <div id="installation_wizard" ng-hide="setupProcess">

                    <div class="page-header">
                        <h4>Setup Wizard</h4>
                    </div>
                    <form name="installation_form" id="installation_form" class="form-horizontal" ng-submit="processForm()" novalidate>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-5 control-label" for="installation_type">Installation Type</label>
                                <div class="col-md-7">
                                    <select class="form-control" id="installation_type" name="installation_type" ng-model="formData.installation_type" ng-options="option.id as option.label for option in form.options" ng-class="{ 'ng-dirty' : errorAlert.1_installation_type }" required></select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label" for="create_folder">Create Folder</label>
                                <div class="col-md-7">
                                    <input class="form-control" id="create_folder" name="create_folder" type="text" ng-model="formData.create_folder" ng-class="{ 'ng-dirty' : errorAlert.3_create_folder, 'ng-invalid' : errorAlert.3_create_folder_exists }" slug-friendly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-5 checkbox">
                                    <label>
                                        <input type="checkbox" id="create_database" name="create_database" ng-model="formData.create_database"> Create Database
                                    </label>
                                </div>
                            </div>
                            <div id="create_database_fields">
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="database_host">Database Server</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="database_host" name="database_host" type="text" ng-model="formData.database_host" ng-class="{ 'ng-dirty' : errorAlert.4_database_host, 'ng-invalid' : DBerrorAlert.creds }" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="database_name">Database Name</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="database_name" name="database_name" type="text" ng-model="formData.database_name" ng-class="{ 'ng-dirty' : errorAlert.5_database_name, 'ng-invalid' : DBerrorAlert.dbName }" slug-friendly required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="database_user">Database User</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="database_user" name="database_user" type="text" ng-model="formData.database_user" ng-class="{ 'ng-dirty' : errorAlert.6_database_user, 'ng-invalid' : DBerrorAlert.creds }" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="database_pass">Database Password</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="database_pass" name="database_pass" type="password" ng-model="formData.database_pass" ng-class="{ 'ng-dirty' : errorAlert.7_database_pass, 'ng-invalid' : DBerrorAlert.creds }" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label" for="table_prefix">Table Prefix</label>
                                    <div class="col-md-7">
                                        <input class="form-control" id="table_prefix" name="table_prefix" type="text" ng-model="formData.table_prefix" ng-class="{ 'ng-dirty' : errorAlert.9_table_prefix }" slug-friendly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7 col-md-offset-5">
                                    <button name="installation_submit" id="installation_submit" type="submit" class="btn btn-default pull-right">Run Setup</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div>

                <div id="installation_process" ng-show="setupProcess">

                    <div class="callout callout-info" role="alert" ng-show="isInstalling">
                        <h4>Heads up!</h4>
                        <p>This might take a few minutes depending on your internet speed.</p>
                    </div>
                    
                    <div class="progress" ng-show="isInstalling">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Please wait...</div>
                    </div>

                    <ul class="list-group" ng-show="processResults">
                        <li class="list-group-item list-group-item-{{ result.type }}" ng-repeat="result in processResults">{{ result.message }}</li>
                    </ul>
                    <a class="btn btn-default pull-right" ng-href="{{ projectUrl }}" ng-show="projectUrl">Run Install</a>

                    <div class="clearfix"></div>

                </div>
                <!-- DEBUG FORM INPUT AND VALIDATION -->

                <!-- <br>
                <pre>valid:<br>{{ installation_form.$valid }}<br><br>fields:<br>{{ formData }}</pre>
                <br> -->

                <!-- END: DEBUG FORM INPUT AND VALIDATION -->
            </div>
        </div>

    </section>

<?php

    }

    require_once 'layout/footer.php';

?>