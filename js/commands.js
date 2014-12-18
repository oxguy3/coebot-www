
$('body').scrollspy({ target: '.nav-commands-scroll' });

// $('.nav-commands-scroll').scrollspy({ target: '.nav' });

$('body').on('load', function() {
	$('body').scrollspy('refresh');
});