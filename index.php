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

<?php include'favicon.php';?>

<!-- Meta Tag Main -->
<meta name="description" content="<?php echo TITLE;?>"/>
<meta property="og:title" content="<?php echo TITLE;?>"/>
<meta property="og:description" content="<?php echo DESCRIPTION;?>"/>
<meta property="og:url" content="<?php echo DOMAIN;?>"/>
<meta property="og:image" content="<?php echo DOMAIN.'/image/ogimage.jpg';?>"/>
<meta property="og:type" content="website"/>
<meta property="og:site_name" content="<?php echo SITENAME;?>"/>

<meta itemprop="name" content="<?php echo TITLE;?>">
<meta itemprop="description" content="<?php echo DESCRIPTION;?>">
<meta itemprop="image" content="<?php echo DOMAIN.'/image/ogimage.jpg';?>">

<title><?php echo TITLE;?></title>

<base href="<?php echo DOMAIN;?>">
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<link rel="stylesheet" type="text/css" href="plugin/font-awesome/css/font-awesome.min.css"/>
</head>
<body>
<?php include 'header.php'; ?>

<?php if(!$user_online){?>
<div class="login">
    <p>How much time do you spend coding ?</p>
    <a href="https://wakatime.com/oauth/authorize?client_id=<?php echo AppID;?>&redirect_uri=<?php echo RedirectURI;?>&response_type=code&scope=email,read_logged_time">Login with Wakatime<i class="fa fa-plug" aria-hidden="true"></i></a>
</div>
<?php }else{?>

<div class="container">
    <h1>Hi, <?php echo $user::firstname($profile['name']);?></h1>

    <?php if(!empty($profile['goal_month'])){?>
        <?php if($remaining['goal_complete']){?>
        <p>Your goal is Complepted<i class="fa fa-check-circle" aria-hidden="true"></i></p>
        <?php }else{?>
        <p>Remaining <?php echo $wpdb::secondsText($remaining['remaining']);?> within <?php echo $remaining['remaining_day'];?> days. Today, you must have coding <strong><?php echo $wpdb::secondsText($remaining['today']);?></strong> for complete goal.</p>
        <?php }?>
    <div class="progress">
        <div class="stat">
            <?php if($remaining['goal_complete']){?>
            <div class="complete">Goal: <?php echo $profile['goal_month'];?> hrs</div>
            <div class="goal"><?php echo $wpdb::secondsText($thismonth['total_seconds']);?></div>
            <?php }else{?>
            <div class="complete"><?php echo $wpdb::secondsText($thismonth['total_seconds']);?></div>
            <div class="goal">Goal: <?php echo $profile['goal_month'];?> hrs</div>
            <?php }?>
        </div>
        <div class="inprogress <?php echo ($remaining['goal_complete']?'complete':'');?>">
            <div class="bar" style="width: <?php echo $remaining['percent'];?>%;"></div>
        </div>
        <button id="btn_goal_form_toggle">Change your goal</button>
    </div>

    <?php }else{?>
    <p>How much time do you spend coding in the month ?</p>
    <?php }?>

    <div id="goal_form" class="form <?php echo (!empty($profile['goal_month'])?'hidden':'');?>">
        <input type="number" autocomplete="off" placeholder="Enter hours" value="<?php echo $user->goal_month;?>" id="goal_month">
        <button id="btn_save_goal">SAVE</button>
    </div>
</div>

<div class="container">
    <h1>Leaderboard</h1>
    <div class="content">
        <?php foreach ($leaderboards as $var) {?>
        <div class="leader-items">
            <a href="#" class="photo">
                <img src="<?php echo (!empty($var['photo'])?$var['photo']:'image/avatar.png');?>">
            </a>
            <a href="#" class="name"><?php echo $var['name'];?></a>
            <div class="time"><?php echo $var['text'];?></div>
        </div>
        <?php } ?>
    </div>
    <p class="note">*Monday is the first day of the week.</p>
</div>

<div class="container">
    <h1>Last 14 Days.</h1>
    <p>Yesterday <?php echo (!empty($yesterday['text'])?$yesterday['text']:'<span>Calm Down :)</span>');?>.</p>
    <div class="content">
        <canvas id="chart"></canvas>
    </div>
</div>

<div class="container">
    <h1>Languages</h1>
    <div class="content">
        <?php foreach ($language as $var) {?>
        <div class="language-items">
            <div class="title"><?php echo $var['language'];?></div>
            <div class="text"><?php echo $var['text'];?></div>
        </div>
        <?php } ?>
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

<input type="hidden" id="profile_id" value="<?php echo $profile['id'];?>">
<?php }?>

<script type="text/javascript" src="js/lib/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/lib/chart.min.js"></script>
<script type="text/javascript" src="js/lib/Chart.roundedBarCharts.min.js"></script>
<script type="text/javascript" src="js/app.chart.js"></script>
<body>