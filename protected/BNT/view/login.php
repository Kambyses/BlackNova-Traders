<?php include_once __TEMPLATES__ . "header.php"; ?>

<div class="index-header"><img class="index" src="images/header1.png" alt="Blacknova Traders"></div>
<div class="index-flags">
<a href="index.php?lang=french"><img src="images/flags/France.png" alt="French"></a>
<a href="index.php?lang=german"><img src="images/flags/Germany.png" alt="German"></a>
<a href="index.php?lang=spanish"><img src="images/flags/Mexico.png" alt="Spanish"></a>
<a href="index.php?lang=english"><img src="images/flags/United_States_of_America.png" alt="American English"></a></div>
<div class="index-header-text">Blacknova Traders</div>
<br>
<h2 style="display:none">Navigation</h2>
<div class="navigation" role="navigation">
<ul class="navigation">
<li class="navigation"><a href="new.php<?php echo $link; ?>"><span class="button blue"><span class="shine"></span><?php echo $l->get('l_new_player'); ?></span></a></li>
<li class="navigation"><a href="mailto:<?php echo $admin_mail; ?>"><span class="button gray"><span class="shine"></span><?php echo $l->get('l_login_emailus'); ?></span></a></li>
<li class="navigation"><a href="ranking.php<?php echo $link; ?>"><span class="button purple"><span class="shine"></span><?php echo $l->get('l_rankings'); ?></span></a></li>
<li class="navigation"><a href="faq.php<?php echo $link; ?>"><span class="button brown"><span class="shine"></span><?php echo $l->get('l_faq'); ?></span></a></li>
<li class="navigation"><a href="settings.php<?php echo $link; ?>"><span class="button red"><span class="shine"></span><?php echo $l->get('l_settings'); ?></span></a></li>
<li class="navigation"><a href="<?php echo $link_forums; ?>" target="_blank"><span class="button orange"><span class="shine"></span><?php echo $l->get('l_forums'); ?></span></a></li>
</ul></div><br style="clear:both">
<div><p></p></div>
<div class="index-welcome">
<h1 class="index-h1"><?php echo $l->get('l_welcome_bnt'); ?></h1>
<p><?php echo $l->get('l_bnt_description'); ?><br></p>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<dl class="twocolumn-form">
<dt><label for="email"><?php echo $l->get('l_login_email'); ?></label></dt>
<dd><input type="email" id="email" name="email" size="20" maxlength="40"></dd>
<dt><label for="pass"><?php echo $l->get('l_login_pw'); ?></label></dt>
<dd><input type="password" id="pass" name="pass" size="20" maxlength="20"></dd>
</dl>
<br style="clear:both">
<div style="text-align:center"><?php echo $l->get('l_login_forgotpw'); ?></div><br>
<div style="text-align:center">
<input class="button green" type="submit" value="<?php echo $l->get('l_login_title'); ?>">
</div>
</form>
<br>
<p class="cookie-warning"><?php echo $l->get('l_cookie_warning'); ?></p></div>
<br>

<?php include_once __TEMPLATES__ . "footer.php"; ?>
