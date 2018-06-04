<?php
include_once 'autoload.php';
$_SESSION['login_string'] = $user->Encrypt(1);

$profile_id = $_GET['profile'];

if(empty($profile_id)){
    $profile_id = $user->id;
}

if($user_online){
    $activity       = new Activity();
    $profile        = $user->getProfile($profile_id);
    $yesterday      = $activity->Yesterday($profile['id']);
    $thismonth      = $activity->ThisMonth($profile['id']);
    $language       = $activity->languages($profile['id']);
    $projects       = $activity->projects($profile['id']);
    $leaderboards   = $activity->leaderboards();

    if(!empty($profile['goal_month'])){
        $remaining = $activity->Remaining($profile['goal_month'],$thismonth['total_seconds']);
    }
}
?>
<!doctype html>
<html lang="en-US" itemscope itemtype="http://schema.org/Blog" prefix="og: http://ogp.me/ns#">
<head>

<!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->

<!-- Meta Tag -->
<meta charset="utf-8">

<!-- Viewport (Responsive) -->
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="user-scalable=no">
<meta name="viewport" content="initial-scale=1,maximum-scale=1">

<?php include 'favicon.php'; ?>

<!-- Meta Tag Main -->
<meta name="description" content="<?php echo TITLE;?>"/>
<meta property="og:title" content="<?php echo TITLE;?>"/>
<meta property="og:description" content="<?php echo DESCRIPTION;?>"/>
<meta property="og:url" content="<?php echo DOMAIN;?>"/>
<meta property="og:image" content="<?php echo DOMAIN.'/image/ogimage.jpg';?>"/>
<meta property="og:type" content="website"/>
<meta property="og:site_name" content="<?php echo SITENAME;?>"/>
<meta property="fb:app_id" content="<?php echo FACEBOOK_APP_ID;?>"/>

<meta itemprop="name" content="<?php echo TITLE;?>">
<meta itemprop="description" content="<?php echo DESCRIPTION;?>">
<meta itemprop="image" content="<?php echo DOMAIN.'/image/ogimage.jpg';?>">

<title><?php echo TITLE;?></title>

<base href="<?php echo DOMAIN;?>">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="plugin/fontawesome-pro-5.0.13/css/fontawesome-all.min.css"/>
</head>
<body>

<?php if($remaining['goal_complete']){?>
<script type="text/javascript" src="plugin/fireworks/js/perlin.js"></script>
<script type="text/javascript" src="plugin/fireworks/js/index.js"></script>
<?php }?>

<?php include 'header.php'; ?>
<?php if(!$user_online){?>
<div class="login">
    <div class="btn" id="btn-login" data-link="https://wakatime.com/oauth/authorize?client_id=<?php echo AppID;?>&redirect_uri=<?php echo RedirectURI;?>&response_type=code&scope=email,read_logged_time">Login with Wakatime<i class="fal fa-plug"></i></div>
</div>
<?php }else{?>
<div class="container">
    <?php if(!$remaining['goal_complete']){?>
    <h1>Goal of the Month</h1>
    <?php }?>

    <?php if(!empty($profile['goal_month'])){?>
        <?php if($remaining['goal_complete']){?>
        <div class="goal-complete">
            <i class="fal fa-flag-checkered"></i>
            <p>Goal is Completed</p>
        </div>
        <?php }else{?>
        <p>Today, You must have coding <strong><?php echo $wpdb::secondsText($remaining['today']);?></strong> for complete goal and remaining <strong><?php echo $wpdb::secondsText($remaining['remaining']);?></strong> within <strong><?php echo $remaining['remaining_day'];?> days</strong>, Good Luck.</p>
        <?php }?>
    <div class="progress">
        <div class="stat">
            <div class="complete"><?php echo $wpdb::secondsText($thismonth['total_seconds']);?></div>
            <div class="goal">Goal: <?php echo $profile['goal_month'];?> hrs <button id="btn_goal_form_toggle"><i class="fa fa-cog"></i></button></div>
        </div>
        <div class="inprogress <?php echo ($remaining['goal_complete']?'complete':'');?>">
            <div class="bar" style="width: <?php echo $remaining['percent'];?>%;"></div>
        </div>
    </div>

    <?php }else{?>
    <p>How much time do you spend coding in the month ?</p>
    <?php }?>

    <div id="goal_form" class="form <?php echo (!empty($profile['goal_month'])?'hidden':'');?>">
        <input type="number" autocomplete="off" placeholder="Enter hours" value="<?php echo $user->goal_month;?>" id="goal_month">
        <button id="btn_save_goal">Set Goal</button>
    </div>
</div>

<div class="container">
    <h1>Weekly Leaderboard</h1>
    <div class="content">
        <?php foreach ($leaderboards as $var) {?>
        <div class="leader-items">
            <a href="#" class="photo">
                <img src="<?php echo (!empty($var['photo'])?$var['photo']:'image/avatar.png');?>">
            </a>
            <a href="#" class="name"><?php echo (!empty($var['name'])?$var['name']:substr($var['email'],0,strpos($var['email'],'@')));?></a>
            <div class="time"><?php echo (!empty($var['total_seconds'])?$var['text']:'n/a');?></div>
        </div>
        <?php } ?>
    </div>
    <p class="note">* <strong>Monday</strong> is the first day of the week.</p>
</div>

<div class="container">
    <h1>Last 14 Days.</h1>
    <div class="content chart">
        <canvas id="chart"></canvas>
    </div>
    <p class="note">Yesterday: <strong><?php echo (!empty($yesterday['text'])?$yesterday['text']:'<span>n/a</span>');?>.</strong></p>
</div>

<div class="container">
    <h1>Code Languages</h1>
    <div class="content">
        <?php foreach ($language as $var) {?>
        <div class="language-items">
            <div class="title"><?php echo $var['language'];?></div>
            <div class="text"><?php echo $var['text'];?></div>
        </div>
        <?php } ?>
    </div>
    <p class="note">* Activities for <strong>Monthly.</strong></p>
</div>

<div class="container">
    <h1>Projects</h1>
    <div class="content">
        <?php foreach ($projects as $var) {?>
        <div class="language-items">
            <div class="title"><?php echo $var['name'];?></div>
            <div class="text"><?php echo $var['text'];?></div>
        </div>
        <?php } ?>
    </div>
    <p class="note">* Activities for <strong>Monthly.</strong></p>
</div>

<div class="container">
    <h1>How to Set Better Goals</h1>
    <p>“Measuring programming progress by lines of code is like measuring aircraft building progress by weight” — Bill Gates</p>

    <p><a href="https://hackernoon.com/pmos-for-programmers-how-to-set-better-goals-521863db9938"><i class="fa fa-external-link-square"></i>PMOs for Programmers — How to Set Better Goals</a></p>
</div>

<div class="container">
    <h1>WakaGoal Mobile</h1>
    <div class="qrcode">
        <img src="image/qrcode.png" alt="WakaGoal QRCode">
        <div class="tip">Apple's iOS 11 included many enhancements including the addition of a QR reader into the smartphone's camera. To scan a QR code with an iPhone camera</div>
    </div>
</div>

<!-- <div class="container">
    <h1>Mission</h1>
    <div class="content">
        <div class="mission-items">
            <div class="caption">Over 4 hours per day.</div>
            <div class="icon"></div>
        </div>
        <div class="mission-items">
            <div class="caption">Coding on Holiday.</div>
            <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
        </div>

        <div class="mission-items">
            <div class="caption">4 languages in a Month.</div>
            <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
        </div>
        <div class="mission-items">
            <div class="caption">22 Days Coding.</div>
            <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
        </div>
        <div class="mission-items">
            <div class="caption">Goal Complete before End of the Month</div>
            <div class="icon"><i class="fa fa-check-circle" aria-hidden="true"></i></div>
        </div>
    </div>
</div> -->

<footer class="footer">
    <div class="logout" id="btn-logout">Logout</div>
</footer>

<input type="hidden" id="profile_id" value="<?php echo $profile['id'];?>">
<?php }?>

<script type="text/javascript" src="js/lib/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/lib/chart.min.js"></script>
<script type="text/javascript" src="js/lib/Chart.roundedBarCharts.min.js"></script>

<?php if($user_online){?>
<script type="text/javascript" src="js/min/activity.chart.min.js"></script>
<?php }?>
<script type="text/javascript" src="js/min/app.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23298896-11"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23298896-11');
</script>
<body>