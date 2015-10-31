<?php

/**
 * This file is part of the Bono CMS
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Site\Controller;

use Krystal\Application\Controller\AbstractController as BaseController;
use Krystal\Application\View\Resolver\Module as Resolver;
use Krystal\Paginate\Paginator;
use Krystal\Validate\Renderer;
use Krystal\InstanceManager\InstanceProvider;

abstract class AbstractController extends BaseController
{
    /**
     * {@inheritDoc}
     */
    protected function getResolverModuleName()
    {
        return 'Site';
    }

    /**
     * Returns site bootstrappers
     * 
     * @return array
     */
    private function getBootstrappers()
    {
        return array(
            // Class bootstrappers with their dependencies
            '\Announcement\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Menu\Service\SiteBootstrapper' => array($this->moduleManager, $this->view, $this->getThemeConfig()),
            '\Shop\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Slider\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Block\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\AboutBox\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Search\Service\SiteBootstrapper' => array($this->view),
            '\Blog\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\News\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Banner\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Advice\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Photogallery\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Team\Service\SiteBootstrapper' => array($this->moduleManager, $this->view),
            '\Contact\Service\SiteBootstrapper' => array($this->moduleManager, $this->view)
        );
    }

    /**
     * Prepares paginator instance (sets generated URL)
     * 
     * @param \Krystal\Paginate\Paginator $paginator
     * @param string $code Language code
     * @param string $slug Target slug
     * @param integer $pageNumber Current page number
     * @return void
     */
    final protected function preparePaginator(Paginator $paginator, $code, $slug, $pageNumber)
    {
        // If $code isn't empty, then we have more than one language
        if (!empty($code)) {
            $url = sprintf('/%s/%s/page/(:var)', $code, $slug);
        } else {
            // Otherwise we have only one language
            $url = sprintf('/%s/page/(:var)', $slug);
        }

        $paginator->setUrl($url);
    }

    /**
     * Returns theme configuration
     * 
     * @return array
     */
    private function getThemeConfig()
    {
        static $cache = null;

        if (is_null($cache)) {

            // Build a path to the configuration file
            $file = $this->view->getResolver()->getWithThemePath('theme.config.php');

            // Initial state
            $config = array();

            // Do include only in case, if config file exists
            if (is_file($file)) {
                $config = include($file);
            }

            $cache = $config;
        }

        return $cache;
    }

    /**
     * Loads registered site plugins
     * 
     * @return void
     */
    final protected function loadSitePlugins()
    {
        $config = $this->getThemeConfig();

        // If we have theme a section for theme configuration
        if (isset($config['theme'])) {

            // Plugins must have higher priority
            if (isset($config['plugins']) && is_array($config['plugins'])) {
                foreach ($config['plugins'] as $plugin) {
                    $this->view->getPluginBag()->load($plugin);
                }
            }

            // Append script paths to the stack
            if (isset($config['theme']['scripts']) && is_array($config['theme']['scripts'])) {
                foreach ($config['theme']['scripts'] as $script) {
                    $this->view->getPluginBag()->appendScript($this->getWithThemePath($script, 'Site'));
                }
            }

            // Append stylesheet paths to stack
            if (isset($config['theme']['stylesheets']) && is_array($config['theme']['stylesheets'])) {
                foreach ($config['theme']['stylesheets'] as $stylesheet) {
                    $this->view->getPluginBag()->appendStylesheet($this->getWithThemePath($stylesheet, 'Site'));
                }
            }

        } else {
            throw new \Exception('You have to provide theme configuration');
        }

        $this->view->addVariables(array(
            'languages' => $this->getService('Cms', 'languageManager')->fetchAllPublished(),
        ));

        $instanceProvider = new InstanceProvider($this->getBootstrappers());

        foreach ($instanceProvider->getAll() as $bs) {
            $bs->bootstrap();
        }

        // And lastly, do load global site plugin
        $this->view->getPluginBag()->load('site');
    }

    /**
     * {@inheritDoc}
     */
    final protected function bootstrap()
    {
        $this->validateRequest();

        $this->validatorFactory->setRenderer(new Renderer\StandardJson());
        $this->view->setLayout('__layout__');

        $this->view->getBlockBag()
                   ->setBlocksDir($this->getWithViewPath('/blocks/', 'Site', $this->getResolverThemeName()));

        // Tweak first breadcrumb
        $this->view->getBreadcrumbBag()
                   ->removeFirst()
                   ->add(array(array(
                        'link' => '/',
                        'name' => $this->translator->translate('Home page')
                    ))
        );

        // Get core configuration entity of the system itself
        $config = $this->getService('Cms', 'configManager')->getEntity();

        // If site isn't enabled, then its down for maintenance
        if ($config->getSiteEnabled()) {
            $response = $this->view->renderRaw('Cms', 'down', 'main', array(
                'reason' => $config->getSiteDownReason()
            ));

            die($response);
        }
    }

    /**
     * Validates the request
     * 
     * @return void
     */
    private function validateRequest()
    {
        // Must support only POST and GET requests
        if (!$this->request->isIntended()) {
            $this->response->setStatusCode(400);
            die('Invalid request');
        }

        // Do validate only for POST requests for now
        if ($this->request->isPost()) {

            // This is general for all forms
            $valid = $this->csrfProtector->isValid($this->request->getMetaCsrfToken());

            if (!$valid) {
                $this->response->setStatusCode(400);
                die('Invalid CSRF token');
            }
        }
    }
    
}
