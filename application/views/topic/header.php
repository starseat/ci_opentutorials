<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ci - topic</title>
    <!-- Bootstrap -->
    <link href="/ci_opentutorials/static/lib/bootstrap-2.3.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/ci_opentutorials/static/css/style.css" rel="stylesheet" media="screen">
    <link href="/ci_opentutorials/static/lib/bootstrap-2.3.2/css/bootstrap-responsive.css" rel="stylesheet">
</head>

<body>
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <!-- -fluid -->

                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <!-- Be sure to leave the brand out there if you want it shown -->
                <a class="brand" href="#">CI - topic</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="nav-collapse collapse">
                    <!-- .nav, .navbar-search, .navbar-form, etc -->
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <!-- -fluid -->
        <?php if ($this->config->item('is_dev')) { ?>
            <div class="well span12">
                개발 중 입니다.
            </div>
        <?php } ?>
        <?php
        // echo $this->config->item('base_url'); // config 가져오는법 테스트
        ?>
        <div class="row-fluid">