<?php
App::booted(function() {
	$namespace = 'Sudo\Analytic\Http\Controllers';

	Route::namespace($namespace)->name('admin.ajax.')->prefix(config('app.admin_dir').'/ajax')->middleware(['web'])->group(function() {
		// Lấy số lượng người đang online hiện tại
		Route::post('get_active_visitors', 'AnalyticController@getActiveVisitor')->name('get_active_visitors');
		// Lấy số lượng trình duyệt truy cập nhiều nhất
		Route::post('get_top_browsers', 'AnalyticController@getTopBrowsers')->name('get_top_browsers');
		// Lấy số lượng nguồn vào từ đâu
		Route::post('get_top_referrers', 'AnalyticController@getTopReferrers')->name('get_top_referrers');
	});
});