// ----- pjax ------
$(document).pjax('a:not([data-skip-pjax])', '#pjax-container');
$(document).on('pjax:start', function() { NProgress.start(); });
$(document).on('pjax:end',   function() { NProgress.done();  });
// ----- pjax ------