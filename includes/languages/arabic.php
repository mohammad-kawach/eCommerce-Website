<?php

	function lang2($phrase) {

		static $lang = array(

			// Navbar Links

			'HOME_ADMIN' 	=> 'الرئيسية',
			'CATEGORIES' 	=> 'Categories',
			'ITEMS' 			=> 'Items',
			'MEMBERS' 		=> 'Members',
			'COMMENTS'		=> 'Comments',
			'STATISTICS' 	=> 'Statistics',
			'LOGS' 				=> 'Logs',
			'Home_Page' 	=> 'الصفحة الرئيسية',
			'ENGLISH' 		=> 'English',
			'ARABIC' 			=> 'Arabic',
			'LANGUAGES' 	=> 'Languages',
			'' => ''
		);

		return $lang[$phrase];

	}
