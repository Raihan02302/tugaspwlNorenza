<?= $this->extend('components/layout') ?>

<?= $this->section('content') ?>
<?php
$sess = session();
$addstatus = $sess->get('addtweet');
if ($addstatus == 'success') {
    echo '<div class="alert alert-success" role="alert">
                Tweet baru berhasil diposting
            </div>';
}

$editstatus = $sess->get('edittweet');
if ($editstatus == 'success') {
    echo '<div class="alert alert-success" role="alert">
            Tweet berhasil diedit / diperbaharui.
            </div>';
}
if ($editstatus == 'error') {
    echo '<div class="alert alert-danger" role="alert">
            Kesalahan pengeditan / pembaruan tweet.
            </div>';
}

$delstatus = $sess->get('deltweet');
if ($delstatus == 'success') {
    echo '<div class="alert alert-warning" role="alert">
            Tweet berhasil dihapus.
            </div>';
}
if ($delstatus == 'error') {
    echo '<div class="alert alert-danger" role="alert">
            Kesalahan penghapusan tweet.
            </div>';
}
?>
<script src="https://unpkg.com/feather-icons"></script>
<style>
    .btn .btn-sm .btn-like:hover {
        background-color: yellow;
    }
</style>
<div class="row" style="margin: 30px 0px;">
    <div class="col-md-4">
        <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div style="margin-top:6px; margin-left:7px;" class="col-sm-2">
                    <img src="<?= base_url('images/def.png') ?>" alt="Default Profile Photo" style="max-width: 90px;">
                </div>
                <div class="col-md-8">
                    <div style=" padding-left: 70px;" class="card-body">
                        <p>
                            <strong class="card-title"><?= $profile->fullname ?></strong>
                            <small class="text-muted">@<?= $profile->username ?></small>
                        </p>
                        <p class="card-text">
                            <a class="btn btn-info btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.7rem;" href="<?= base_url('/add') ?>">Tweet Baru</a>
                            <a class="btn btn-danger btn-sm" style="padding: 0.25rem 0.5rem; font-size: 0.7rem;" href="<?= base_url('/logout') ?>">Logout</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="list-group">
            <div class="list-group-item list-group-item-action active" aria-current="true">
                <strong>Kategori Tweet</strong>
            </div>
            <?php foreach ($categories as $key => $val) : ?>
                <a href="<?= base_url('/category//' . $key) ?>" class="list-group-item list-group-item-action">
                    <?= $val ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-8">
        <h2><?= $judul ?></h2>

        <?php foreach ($tweets as $tweet) { ?>
            <div class="row" style="border-top: 1px solid #eee; padding-top: 10px; margin-bottom: 10px;">
                <div class="col-sm-2">
                    <img src="<?= base_url('images/def.png') ?>" alt="Default Profile Photo" style="max-width: 90px;">
                </div>

                <div class="col-sm-10">
                    <h4><?= $tweet->fullname ?> <small>@<?= $tweet->username ?></small></h4>
                    <div class="mb-3">
                        <?php if ($tweet->uphoto) : ?>
                            <div class="mt-3">
                                <img src="<?= base_url($tweet->uphoto) ?>" alt="Tweet Photo" style="max-width: 10em; max-height: 10em;">
                            </div>
                        <?php endif; ?>
                        <?= $tweet->content ?>
                    </div>
                    <div class="container-fluid">
                        <span>
                            <a href="<?= base_url('/category//' . $tweet->category) ?>">#<?= $tweet->category ?></a>
                            <small><?= $tweet->getCreatedAt() ?></small>
                        </span>
                        <?php if ($curUser['userid'] == $tweet->user_id) : ?>
                            <span>
                                <a href="<?= base_url('/edit//' . $tweet->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= base_url('/delete//' . $tweet->id) ?>" class="btn btn-sm btn-danger">Delete</a>
                            <?php endif; ?>
                            <form method="POST" action="<?= base_url('/like/' . $tweet->id) ?>" style="display: inline;">
                                <style>
                                    .btn-like {
                                        background: none;
                                        border: none;
                                        padding: 0;
                                        cursor: pointer;
                                    }

                                    .btn-like i {
                                        color: black;
                                        /* Warna ikon hati saat tidak di-hover */
                                        transition: color 0.3s;
                                    }

                                    .btn-like:hover i {
                                        color: red;
                                        /* Warna ikon hati saat di-hover */
                                    }
                                </style>
                                <button type="submit" class="btn btn-sm btn-like" name="like"><i data-feather="heart"></i></button>
                            </form>
                            <span><?= $tweet->like ?> Likes</span>

                    </div>
                    <script>
                        feather.replace()
                    </script>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?= $this->endSection() ?>