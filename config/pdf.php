<?php
return [
	// ...
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'bangla' => [
			'R'  => 'NikoshBAN.ttf',    // regular font
			'B'  => 'NikoshBAN.ttf',       // optional: bold font
			'I'  => 'NikoshBAN.ttf',     // optional: italic font
			'BI' => 'NikoshBAN.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,
			'useKashida' => 75,
                        'tempDir'=> base_path('storage/app/mpdf')
		]
		// ...add as many as you want.
	]
	// ...
];