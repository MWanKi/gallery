$(document).on("click", ".btn-follow", function(){
	var btn = $(this);
	var csrfToken = $(this).data("csrfToken");
	var follow_id = $(this).data("id");
	var url = $(this).data("url");
	var cancelUrl = $(this).data("cancelUrl");

	if (!$(this).hasClass('btn-already-follow')) {
		$.ajax({
			type: 'post',
			url: url,
			data: {
				follow_id: follow_id,
				xhr: 'true',
				_token: csrfToken
			}
		}).done(function (response) {
			btn.addClass('btn-already-follow').find('span').text('현재 팔로우 중입니다.');
		});
	} else {
		$.ajax({
			type: 'post',
			url: cancelUrl,
			data: {
				follow_id: follow_id,
				xhr: 'true',
				_token: csrfToken
			}
		}).done(function (response) {
			btn.removeClass('btn-already-follow').find('span').text('팔로우');
		});
	}
});