<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="<?= base_url('assets/css/challenge_css.css') ?>">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">



    <title>My challenge</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-danger">
    <a class="navbar-brand" href="<?= site_url('home') ?>">My challenge</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if($logged_in == "0") :?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('Auth/register') ?>">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('Auth/login') ?>">Login</a>
                </li>
                <li class="nav-item" onclick="showCartModal();" id="myBtn" style="cursor:pointer">
                    <i class="fa badge" style="font-size:24px" value="<?= $total_cart_quantity; ?>">&#xf07a;</i><?= $total_price; ?>.00€
                </li>
            <?php else: ?>
                <li class="nav-item">
                   <h5 class="nav-link text-white">Your api key: <?php echo $api_key; ?></h5>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('Auth/register') ?>">Welcome <?php echo $user_name; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('Auth/logout') ?>">Logout</a>
                </li>
                <li class="nav-item" onclick="showCartModal();" id="myBtn" style="cursor:pointer">
                    <i class="fa badge" style="font-size:24px" value="<?= $total_cart_quantity; ?>">&#xf07a;</i><?= $total_price; ?>.00€
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>


