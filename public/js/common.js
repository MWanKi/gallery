// ----- pjax ------
$(document).pjax('a', '#pjax-container');
$(document).on('pjax:start', function() { NProgress.start(); });
$(document).on('pjax:end',   function() { NProgress.done();  });
// ----- pjax ------