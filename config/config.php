<?php

/*
 |-------------------------------------------------------------------------
 | "Users" config for scaffolding.
 |-------------------------------------------------------------------------
 |
 | You can replace this conf file with config/amranidev/config.php
 | to let scaffold-interface interact with "Users".
 |
 */
return [

		'env' => [
        	'local',
    	],

		'package' => 'Users',

		'model' => base_path() . '/Walksoft/Users/src',

        'views' => base_path() . '/Walksoft/Users/resources/views',

        'controller' => base_path() . '/Walksoft/Users/src/Http/Controllers',

        'migration' => base_path() . '/Walksoft/Users/database/migrations',

		'database' => '/Walksoft/Users/database/migrations',

	   	'routes' => base_path() . '/Walksoft/Users/routes/web.php',

	   	'controllerNameSpace' => 'Walksoft\Users\\Http\\Controllers',

	   	'modelNameSpace' => 'Walksoft\Users',

		'loadViews' => 'Users',

	   ];
