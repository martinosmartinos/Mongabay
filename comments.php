<div id="comments">
	<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'mongabay';
	var disqus_identifier = '<?php echo get_the_ID(); ?>';
    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
<?php if (mongabay_is_legacy_post()): $url=mongabay_sharebox_share_url(get_the_ID());?>
	<div class="fb-comments-wrap">
    	<div class="fb-comments" data-href="<?php echo $url[1]; ?>" data-width="760" data-width="100%" colorscheme="dark" data-numposts="5"></div>
    </div>
	<?php endif; ?>
</div>

