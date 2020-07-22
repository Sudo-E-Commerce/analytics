## Widget ##

**Số người đang online tại thời điểm hiện tại**

	// Box số người online hiện hành
	'widget_1' => [
		'view' => 'Analytic::widget',
		'include' => [
			'active_visitors' => [
				'view' => 'Analytic::components.active_visitors',
				'autoload' => false,
			],
		],
	],

**Trình truy cập nhiều**

	'top_browsers' => [
		'view' => 'Analytic::components.top_browsers',
		'autoload' => false,
	],

**Các trang giới thiệu**

	'top_referer' => [
		'view' => 'Analytic::components.top_referer',
		'autoload' => false,
	],

