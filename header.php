<header class="header">
    <?php if($user_online){?>
    <a href="index.php" class="link <?php echo (empty($current_page)?'active':'');?>"><i class="fa fa-code" aria-hidden="true"></i><span>Hour of Code</span></a>
    <a href="leaders.php" class="link <?php echo ($current_page == 'leaderboards'?'active':'');?>"><i class="fa fa-trophy" aria-hidden="true"></i><span>Leaderboards</span></a>
    <div class="avatar"><img src="<?php echo $user->photo;?>" alt="<?php echo $user->name;?>"></div>
    <?php }?>
</header>