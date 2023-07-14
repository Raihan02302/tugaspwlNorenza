<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TC - Twitter Clone</title>
    <?= link_tag('css/bootstrap.min.css') ?>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-ligt" 
            style="background-color: #e3f2fd;">  
            <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <?=img(['src'=>'images/Bootstrap_logo.svg', 'width'=>30, 'height'=>24])?>                
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" 
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">                
                <strong><a class="nav-link" href="<?=base_url('/')?>">(TC) Twitter Clone</a></strong>
                <a class="nav-link" href="<?=base_url('/auth')?>">Login</a>
                <a class="nav-link" href="<?=base_url('/register')?>">Register</a>
            </div>
            </div>
        </nav>
        <?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php 
helper('form');
$validation = \Config\Services::validation();
?>
<div class="row" style="margin-top: 100px; margin-bottom: 100px;">
    <!-- Awal koding tambahan notifikasi -->
    <?php
    $sess = session();
    if($sess->get('logout') == 'success'){
        echo '<div class="alert alert-success" role="alert">
            Berhasil logout. Silahkan login kembali.
            </div>';
    }

		$err_login = $sess->get('login_error');
    if($err_login){
        echo '<div class="alert alert-danger" role="alert">
            '.$err_login.'
            </div>';
    }
    ?>
    <!-- Akhir koding tambahan notifikasi -->
    <div class="col-md-6 offset-md-3 align-self-center">
    <div class="card">
        <div class="card-header text-white bg-dark">
            <strong>Form Login</strong>
        </div>
        <div class="card-body">
            <?= form_open('/login') ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="username" class="form-control" name="username" id="username" placeholder="username">
                <div style="color: red; font-size: small;"> <?=$validation->getError('username')?> </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password">
                <div style="color: red; font-size: small;"> <?=$validation->getError('password')?> </div>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <?= form_close() ?>
				        </div>
				    </div>
				    </div>
				</div>
        <footer style="background-color: #e3f2fd;">
            <div class="container">
                Twitter Clone &copy; <?=date('Y')?>
            </div>            
        </footer>
    </div>
    <?= script_tag('js/bootstrap.bundle.min.js') ?>
</body>
</html>