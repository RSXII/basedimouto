<?php
error_reporting( E_ALL & ~E_NOTICE);
session_start();
require('dbconfig.php');
include_once('functions.php');
include('login-parse.php');
include('post-parser.php');
include('breadcrumb.php');
$rankColor = white;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HOME | Based Imouto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/layout.css">
    <script
        src="https://code.jquery.com/jquery-1.12.4.min.js"
        integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
        crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700|PT+Serif" rel="stylesheet">
<?php
if( isset($_SESSION['user_id']) AND isset($_SESSION['secret_key']) ){
    //check for a match in the database
    $session_user = $_SESSION['user_id'];
    $session_key = $_SESSION['secret_key'];
    $query = "SELECT * FROM users WHERE user_id = $session_user AND secret_key = '$session_key' LIMIT 1";
    $result = $db->query($query);
    if($result->num_rows == 1){
        $logged_in_user = $result->fetch_assoc();
        $the_username = $logged_in_user['username'];
        $is_logged_in = true;
        $user_profile_pic = $logged_in_user['profile_pic'] . '_thumbnail.jpg';
    }
}else{
    $is_logged_in = false;
    $user_profile_pic = 'default_profile.jpg';
}
?>

<style>
    .profilePicContainer{
        background: url(uploads/<?php echo $user_profile_pic; ?>);
    }
</style>

</head>
<body>
<div id="container">

    <header>
        <div id="utilityMenu">
            <form action="search.php" method="get">
                <input type="search" placeholder="Search" name="the_search">
            </form>
            <?php
            if( $is_logged_in ){
                if($_SESSION['status_id'] == 1 || $_SESSION['status_id'] == 2){
                ?>
                    <div><a href="admin.php">Admin Panel</a></div>
                    <?php }//end if admin show admin button?>
                <form action="login.php" name="logout" method="get" id="logout">
                    <p id="log_reg"><a href="login.php?action=logout">Log Out</a></p>
                </form>

            <?php }else{ ?>
                <p id="log_reg"><a href="login.php">Login/Register</a></p>
            <?php } ?>
        </div>
        <div id="heroImage">


<!--            <h1>FORUM NAME</h1>-->
        </div>
        <section id="breadcrumb">
            <div>
                <?php echo breadcrumbs(); ?>
            </div>
            <div></div>
        </section>
        <div id="navScrollSpace"></div>

        <nav id="topNav">
            <p id="menuButton">MENU</p>
            <section id="profileDesktop">
                <div class="profilePicContainer"></div>
                <p class="profileName"><?php
                    if($is_logged_in){
                        echo '<a href="profile.php?user_id=' . $session_user . '">' . $the_username . '</a>';
                    }else{
                        echo '<a href="login.php">Not Logged In</a>';
                    }
                    ?></p>
            </section>
            <ul id="mobileMenu" class="">
                <li><a href="profile.php?user_id=<?php echo $_SESSION['user_id']; ?>">Profile</a></li>
                <li><a href="index.php">Forum</a></li>
                <li><a href="privacy.php">Privacy</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="rss.php">RSS</a></li>
            </ul>

        </nav>
    </header>