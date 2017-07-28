<?php
$database = 'based_database';
$username = 'based_admin';
$password = 'Tc2OehjF7YypumNs';
$db_host = '198.71.227.85:3306';

// connect to database
$db = new mysqli( $db_host, $username, $password, $database ); // must be in this order!

if( $db->connect_errno > 0 ){
    die('Error connecting to database');
}
//store our secure salt in a constant - strengthens our login
// system.  If the salt is changed, every login, cookie, password is invalid.
define('SALT', 'jg74s9jdj%^G(Djhg96dfg(^Gfd');
define('ROOT_PATH', 'http://localhost/students/RyanSchultzForums');