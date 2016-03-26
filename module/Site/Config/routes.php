<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

return array(
    '/captcha/render/(:var)' => array(
        'controller' => 'Main@captchaAction'
    ),
    
    // For changing language
    '/lang/(:var)' => array(
        'controller' => 'Main@changeLanguageAction'
    ),
    
    '/(:var)/' => array(
        'controller' => 'Main@slugAction'
    ),

    '/(:var)/page/(:var)' => array(
        'controller' => 'Main@slugAction'
    ),
    
    '/' => array(
        'controller' => 'Main@homeAction'
    ),
    
    '/(:var)/(:var)/' => array(
        'controller' => 'Main@slugLanguageAwareAction'
    ),
    
    '/(:var)/(:var)/page/(:var)' => array(
        'controller' => 'Main@slugLanguageAwareAction'
    ),
    
    '/sitemap' => array(
        'controller' => 'Main@sitemapAction'
    ),
    
    '/sitemap/lang/(:var)' => array(
        'controller' => 'Main@sitemapAction'
    ),
    
    '/test' => array(
        'controller' => 'Main@testAction'
    )
);
