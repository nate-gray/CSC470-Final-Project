<?php
ob_start();
session_start();
date_default_timezone_set('America/Chicago');
$logged_in = false;
$is_admin = false;

if(isset($_SESSION['username'])) {
    $logged_in = true;
}

include('includes/functions.php');
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title><?php 
            if (defined('TITLE')) {
                print TITLE;
            } else {
                print 'Raise High the Roof Beam!';
            }
            ?></title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="HandheldFriendly" content="True">
        <link rel="stylesheet" type="text/css" media="screen" href="css/concise.min.css"/>
        <link rel="stylesheet" type="text/css" media="screen" href="css/masthead.css"/>
    </head>
    <body>
        
        <header container class="siteheader">
            <div row>
                <h1 column=4 class="logo">
                    <a href="index.php">Raise High the Roof Beam!</a>
                </h1>
                <nav column="8" class="nav">
                    <ul>
                        <?php
                        if($logged_in) {
                            print '<li><a href="books.php">Books</a></li>
                            <li><a href="stories.php">Stories</a></li>
                            <li><a href="quotes.php">Quotes</a></li>
                            <li><a href="email.php">Contact</a></li>
                            <li><a href="upload.php">Upload</a></li>
                            <li><a href="logout.php">Logout</a></li>';
                            if(isAdmin($_SESSION['username'])) {
                                print '<li><a href="admin.php">Admin</a></li>';
                            }
                        } else {
                            print '<li><a href="books.php">Books</a></li>
                            <li><a href="quotes.php">Quotes</a></li>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>';
                        }
                        
                        ?>

                    </ul>
                </nav>
            </div>
        </header>
        
        <main container class="siteContent">
            
            <!-- Begin Changeable Content -->