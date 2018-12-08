<?php

Yii::setPathOfAlias('application', BASE_PATH);
Yii::import('application.components.*');

$wcaDb = file_exists(CONFIG_PATH . '/wcaDb') ? intval(file_get_contents(CONFIG_PATH . '/wcaDb')) : 0;
$config = [
	'basePath'=>BASE_PATH,
	'name'=>'世界竞技叠杯运动协会（中国）- World Sport Stacking Association(China)',
	'language'=>'zh_cn',
	// preloading 'log' component
	'preload'=>[
		'log',
	],
	// autoloading model and component classes
	'import'=>[
		'application.models.*',
		'application.models.wca.*',
		'application.forms.*',
		'application.widgets.*',
		'application.statistics.*',
		'application.summary.*',
		'application.extensions.debugtb.*',
		'application.extensions.mail.*',
	],
	'modules'=>[
		'board'=>[
			'defaultController'=>'competition',
		],
	],
	// application components
	'components'=>[
		'user'=>[
			'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		],
		'urlManager'=>[
			'urlFormat'=>'path',
			'rules'=>[
				'<page:\d+>'=>'site/index',
				'faq/<category_id:\d+>'=>[
					'faq/index',
					'urlSuffix'=>'.html'
				],
				'equipment/<category_id:\d+>'=>'equipment/index',
				'equipment/item/<id:\d+>'=>'equipment/item',
				''=>'site/index',
				// 'register/<step:\d>'=>'site/register',
				'<action:login|logout|banned|register>'=>'site/<action>',
				'<view:about|contact|links|disclaimer|competition|record|sponsor|please-update-your-browser>'=>[
					'site/page',
				],
				// 'competition/<action:signin>'=>'competition/<action>',
				// 'competition/<alias:[-A-z0-9]+>/<action:schedule|travel|regulations|competitors|registration|scan>'=>'competition/<action>',
				'<controller:competition|post>/<alias:[-A-z0-9]+>'=>'<controller>/detail',
				'pay/<action:notify|frontNotify>/<channel:\w+>'=>'pay/<action>',
				'qrCode/<action:\w+>/<code:[\w-]+>'=>'qrCode/<action>',
				'board'=>'board/news/index',
				'<controller:\w+>'=>'<controller>/index',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			],
			'appendParams'=>false,
			'showScriptName'=>false,
		],
		// 'cache'=>[
		// 	'class'=>'CustomCache',
		// 	// 'hashKey'=>false,
		// 	'hostname'=>'127.0.0.1',
		// 	'port'=>6379,
		// 	'database'=>1,
		// ],
		'db'=>[
			'connectionString'=>'mysql:host=localhost;dbname=wssa' . (DEV ? '_dev' : ''),
			'pdoClass'=>'QueryCheckPdo',
			'emulatePrepare'=>true,
			'username'=>'wssa',
			'password'=>'',
			'charset'=>'utf8',
			'enableParamLogging'=>YII_DEBUG,
			'enableProfiling'=>YII_DEBUG,
			'schemaCachingDuration'=>DEV ? 0 : 10800,
		],
		'errorHandler'=>[
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
			'discardOutput'=>false,
		],
		'log'=>[
			'class'=>'CLogRouter',
			'routes'=>[
				[
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					'logFile'=>'application.error.log',
					'maxFileSize'=>102400,
				],
				[
					'class'=>'CFileLogRoute',
					'levels'=>'info, trace, profile',
					'logFile'=>'application.access.log',
					'maxFileSize'=>102400,
				],
				[
					'class'=>'CFileLogRoute',
					'levels'=>'pay',
					'logFile'=>'application.pay.log',
					'maxFileSize'=>102400,
				],
				[
					'class'=>'CFileLogRoute',
					'levels'=>'ws',
					'logFile'=>'application.ws.log',
					'maxFileSize'=>102400,
				],
				[
					'class'=>'CFileLogRoute',
					'levels'=>'debug',
					'logFile'=>'application.debug.log',
					'maxFileSize'=>102400,
				],
				[
					'class'=>'CFileLogRoute',
					'levels'=>'git',
					'logFile'=>'application.git.log',
					'maxFileSize'=>102400,
				],
				[
					'class'=>'CDbLogRoute',
					'levels'=>'test',
					'connectionID'=>'db',
					'autoCreateLogTable'=>DEV,
					'logTableName'=>'logs',
				],
				[ // configuration for the toolbar
					'class'=>'XWebDebugRouter',
					'config'=>'alignLeft, opaque, fixedPos, collapsed, yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>['127.0.0.1', '^10\.\d+\.\d+\.\d+'],
				],
			],
		],
		'clientScript'=>[
			'defaultScriptFilePosition'=>CClientScript::POS_END,
			'coreScriptPosition'=>CClientScript::POS_END,
			'packages'=>[
				'jquery'=>[
					'baseUrl'=>'',
					'js'=>['js/jquery.min.js'],
				],
				'board'=>[
					'baseUrl'=>'b',
					'js'=>[
						'js/plugins/bootstrap/bootstrap.min.js',
						'js/plugins/hisrc/hisrc.js',
						'js/flex.js',
						'js/main.js?v=20180228',
					],
					'depends'=>['jquery'],
				],
				'main'=>[
					'baseUrl'=>'',
					// 'depends'=>['jquery'],
				],
				'datepicker'=>[
					'baseUrl'=>'f/plugins/bootstrap-datepicker',
					'css'=>[
						'css/datepicker.css',
					],
					'js'=>[
						'js/bootstrap-datepicker.js',
					],
				],
				'datetimepicker'=>[
					'baseUrl'=>'b',
					'css'=>[
						'css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css',
					],
					'js'=>[
						'js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js',
					],
				],
				'tokenfield'=>[
					'baseUrl'=>'b',
					'css'=>[
						'css/plugins/bootstrap-tokenfield/tokenfield-typeahead.min.css',
						'css/plugins/bootstrap-tokenfield/bootstrap-tokenfield.min.css',
					],
					'js'=>[
						'js/plugins/bootstrap-tokenfield/bootstrap-tokenfield.min.js',
						'js/plugins/bootstrap-tokenfield/typeahead.bundle.min.js',
					],
				],
				'tagsinput'=>[
					'baseUrl'=>'b',
					'css'=>[
						'css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
						'css/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css',
					],
					'js'=>[
						'js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
					],
					'depends'=>['typeahead'],
				],
				'typeahead'=>[
					'baseUrl'=>'b',
					'js'=>[
						'js/plugins/bootstrap-typeahead/bootstrap-typeahead.min.js',
					],
				],
				'switch'=>[
					'baseUrl'=>'b',
					'css'=>[
						'css/plugins/bootstrap-switch/bootstrap-switch.min.css',
					],
					'js'=>[
						'js/plugins/bootstrap-switch/bootstrap-switch.min.js',
					],
				],
				'upload-preview'=>[
					'baseUrl'=>'b',
					'js'=>[
						'js/plugins/upload-preview/jquery.uploadPreview.min.js',
					],
				],
				'morris'=>[
					'baseUrl'=>'b',
					'css'=>[
						'css/plugins/morris/morris.css',
					],
					'js'=>[
						'js/plugins/morris/raphael-2.1.0.min.js',
						'js/plugins/morris/morris.js',
					],
				],
				'pinyin'=>[
					'baseUrl'=>'f',
					'js'=>[
						'js/pinyin.min.js',
					],
				],
				'leaflet'=>[
					'baseUrl'=>'f/plugins/leaflet',
					'css'=>[
						'leaflet.css?20161009',
						'plugins/MarkerCluster/MarkerCluster.css',
						'plugins/MarkerCluster/MarkerCluster.Default.css',
					],
					'js'=>[
						'leaflet.js',
						'plugins/MarkerCluster/leaflet.markercluster.js',
					],
				],
			],
		],
		'mailer'=>[
			'class'=>'Mailer',
			'from'=>'noreply@thewssa.org.cn',
			'fromname'=>'请勿回复DO NOT REPLY',
			'api'=>[
				'user'=>'thewssa',
				'key'=>Env::get('MAILER_KEY'),
			],
		],
	],
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>[
		// this is used in contact page
		'adminEmail'=>'wssachina@jinseyulin.cn',
		'baseUrl'=>'http://thewssa.org.cn',
		'languages'=>['en', 'zh_cn', 'zh_tw'],
		'author'=>'Baiqiang Dong',
		'description'=>'The Chinese WSSA website.',
		'keywords'=>[
			'WSSA China',
		],
		'staticPath'=>PUBLIC_PATH . '/static/',
		'staticUrlPrefix'=>'/static/',
		'avatar'=>[
			'size'=>2097152,
			'height'=>1200,
			'width'=>1200,
		],
	],
];

if (is_file(CONFIG_PATH . '/' . ENV . '.php') && ENV !== 'main') {
	include CONFIG_PATH . '/' . ENV . '.php';
}

return $config;
