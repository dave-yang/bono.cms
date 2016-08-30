<?php

return array(

	'theme' => 'bono-shop',
	'obfuscate' => true,

	// Global template plugins
	'plugins' => array(
		// Global plugins for all site templates
		'site' => array(
			'scripts' => array(
				'@Site/global.js',
			),
		),
		
        'select2' => array(
            'stylesheets' => array(
				'@Cms/plugins/select2/select2.min.css'
            ),
            'scripts' => array(
				'@Cms/plugins/select2/select2.min.js'
            )
        ),
        
		'lightbox' => array(
			'stylesheets' => array(
				'@Cms/plugins/lightbox/css/lightbox.css',
			),
			
			'scripts' => array(
				'@Cms/plugins/lightbox/js/lightbox.min.js',
			)
		),
		
		'superfish' => array(
			'stylesheets' => array(
				'@Site/plugins/superfish/dist/css/superfish.css'
			),
			'scripts' => array(
				'@Site/plugins/superfish/dist/js/hoverIntent.js',
				'@Site/plugins/superfish/dist/js/superfish.js',
			)
		),
		
		'to-top' => array(
			'stylesheets' => array(
				'@Cms/plugins/to-top/to-top.min.css'
			),
			'scripts' => array(
				'@Cms/plugins/to-top/to-top.min.js'
			)
		),
		
		'bx-slider' => array(
			'stylesheets' => array(
				'@Site/plugins/bxslider/jquery.bxslider.css'
			),
			'scripts' => array(
				'@Site/plugins/bxslider/jquery.bxslider.min.js'
			)
		),
		
		'preview' => array(
			'scripts' => array(
				'@Cms/plugins/preview/jquery.preview.js'
			),
			'stylesheets' => array(
				'@Cms/plugins/preview/jquery.preview.css'
			)
		),
		
		'datepicker' => array(
			'scripts' => array(
				'@Cms/plugins/datepicker/js/bootstrap-datepicker.min.js'
			),
			'stylesheets' => array(
				'@Cms/plugins/datepicker/css/datepicker.min.css'
			)
		),
		
		'jquery' =>	array(
			'scripts' => array(
				'@Cms/plugins/jquery/1.11.2/jquery.min.js'
			)
		),
		
		'ckeditor' => array(
			'scripts' => array(
				'@Cms/plugins/ckeditor/ckeditor.js',
			),
		),

		'admin' => array(
			'scripts' => array(
				'@Cms/plugins/jquery.form.js',
				'@Cms/admin/app.js'
			),
			'stylesheets' => array(
				'@Cms/css/style.css',
			)
		),
		
		'zoom' => array(
			'scripts' => array(
				'@Site/plugins/elevatezoom/jquery.elevateZoom-3.0.8.min.js'
			),
		),
		
		'famfam-flag' => array(
			'stylesheets' => array(
				'@Site/plugins/famfam-flag/famfamfam-flags.min.css'
			),
		),

		'font-awesome' => array(
			'stylesheets' => array(
				'@Cms/plugins/font-awesome/css/font-awesome.min.css',
			),
		),
		
		'bootstrap.cosmo' => array(
			'stylesheets' => array(
				'@Site/plugins/bootstrap/css/cosmo.min.css',
			)
		),
		
		'bootstrap.blue' => array(
			'stylesheets' => array(
				'@Site/plugins/bootstrap/css/bootstrap.min.css',
				'@Site/plugins/bootstrap/css/bootstrap-theme.min.css',
			),
		),

		'bootstrap.default' => array(
			'stylesheets' => array(
				'@Site/plugins/bootstrap/css/bootstrap.min.css',
			),
		),
		
		'bootstrap.core' => array(
			'scripts' => array(
				'@Site/plugins/bootstrap/js/bootstrap.min.js',
			)
		),
	),
);