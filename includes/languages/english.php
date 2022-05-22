<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar Links

			'HOME_ADMIN' 	=> 'Home',
			'CATEGORIES' 	=> 'Categories',
			'ITEMS' 			=> 'Items',
			'MEMBERS' 		=> 'Members',
			'COMMENTS'		=> 'Comments',
			'STATISTICS' 	=> 'Statistics',
			'LOGS' 				=> 'Logs',
			'Home_Page' 	=> 'Home Page',
			'ENGLISH' 		=> 'English',
			'ARABIC' 			=> 'Arabic',
			'LANGUAGES' 	=> 'Languages',
			'' => ''
		);

		return $lang[$phrase];

	}
