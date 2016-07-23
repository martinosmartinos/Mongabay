<span class="social">
	<?php if(rd_options('abomb_email')!=''):?>
		<?php $mail = sanitize_email(rd_options('abomb_email')); ?>
		<a href="mailto:<?php echo antispambot($mail); ?>" target="_top" title="email"><i class="fa fa-envelope"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_twitter')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_twitter')); ?>" title="twitter"><i class="fa fa-twitter"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_facebook')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_facebook')); ?>" title="facebook"><i class="fa fa-facebook"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_dribbble')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_dribbble')); ?>" title="dribbble"><i class="fa fa-dribbble"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_rss')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_rss')); ?>" title="rss feed"><i class="fa fa-rss"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_github')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_github')); ?>" title="github"><i class="fa fa-github-alt"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_linkedin')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_linkedin')); ?>" title="linkedin"><i class="fa fa-linkedin"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_pinterest')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_pinterest')); ?>" title="pinterest"><i class="fa fa-pinterest"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_google')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_google')); ?>" title="google plus"><i class="fa fa-google-plus"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_instagram')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_instagram')); ?>" title="Instagram"><i class="fa fa-instagram"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_skype')!=''):?>
		<a href="skype:<?php echo esc_attr(rd_options('abomb_skype')); ?>?call" title="skype"><i class="fa fa-skype"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_soundcloud')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_soundcloud')); ?>" title="soundcloud"><i class="fa fa-soundcloud"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_youtube')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_youtube')); ?>" title="youtube"><i class="fa fa-youtube"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_vimeo')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_vimeo')); ?>" title="vimeo"><i class="fa fa-vimeo-square"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_tumblr')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_tumblr')); ?>" title="tumblr"><i class="fa fa-tumblr"></i></a>
	<?php endif; ?>
	<?php if(rd_options('abomb_flickr')!=''):?>
		<a target="_blank" href="<?php echo esc_url(rd_options('abomb_flickr')); ?>" title="flickr"><i class="fa fa-flickr"></i></a>
	<?php endif; ?>
</span><!-- end social -->