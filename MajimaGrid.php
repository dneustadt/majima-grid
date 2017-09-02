<?php
/**
 * Copyright (c) 2017
 *
 * @package   Majima
 * @author    David Neustadt <kontakt@davidneustadt.de>
 * @copyright 2017 David Neustadt
 * @license   MIT
 */

namespace Plugins\MajimaGrid;

use Majima\PluginBundle\Components\AssetCollection;
use Majima\PluginBundle\Components\ControllerCollection;
use Majima\PluginBundle\Components\RouteCollection;
use Majima\PluginBundle\Components\RouteConfig;
use Majima\PluginBundle\Components\ViewCollection;
use Majima\PluginBundle\PluginAbstract;
use Plugins\MajimaGrid\Services\AdminControllerDecorator;
use Plugins\MajimaGrid\Services\IndexControllerDecorator;

/**
 * Class MajimaGrid
 * @package Plugins\MajimaGrid
 */
class MajimaGrid extends PluginAbstract
{
    /**
     * @var int
     */
    private $priority = 0;

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function install()
    {
        /**
         * @var \FluentPDO $qb
         */
        $qb = $this->container->get('dbal');

        $sql = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . join(DIRECTORY_SEPARATOR, ['Resources', 'sql', 'install.sql']));

        $pdo = $qb->getPdo();
        $pdo->exec($sql);
    }

    public function build()
    {
    }

    /**
     * @return ControllerCollection
     */
    public function registerControllers()
    {
        return new ControllerCollection([
            'majima.index_controller' => IndexControllerDecorator::class,
            'majima.admin_controller' => AdminControllerDecorator::class,
        ]);
    }

    /**
     * @return RouteCollection
     */
    public function setRoutes()
    {
        $routeCollection = new RouteCollection();
        $routeCollection->addRoute(
            new RouteConfig(
                'admin_save_grid',
                '/admin/savegrid/',
                'majima_grid.majima.admin_controller:saveGridAction'
            )
        );
        $routeCollection->addRoute(
            new RouteConfig(
                'admin_image_upload',
                '/admin/imageupload/',
                'majima_grid.majima.admin_controller:imageUploadAction'
            )
        );
        return $routeCollection;
    }

    /**
     * @return ViewCollection
     */
    public function setViewResources()
    {
        $viewCollection = new ViewCollection(join(DIRECTORY_SEPARATOR, [__DIR__, 'Resources']));
        $viewCollection->setViews(['views']);
        return $viewCollection;
    }

    /**
     * @return AssetCollection
     */
    public function setCssResources()
    {
        $assetCollection = new AssetCollection(join(DIRECTORY_SEPARATOR, [__DIR__, 'Resources', 'css', 'src']));
        $assetCollection->setFrontendAssets([
            join(DIRECTORY_SEPARATOR, ['frontend', 'all.scss']),
        ]);
        $assetCollection->setBackendAssets([
            join(DIRECTORY_SEPARATOR, ['backend', 'all.scss']),
        ]);
        return $assetCollection;
    }

    /**
     * @return AssetCollection
     */
    public function setJsResources()
    {
        $assetCollection = new AssetCollection(join(DIRECTORY_SEPARATOR, [__DIR__, 'Resources', 'js', 'src', 'backend']));
        $assetCollection->setBackendAssets([
            'dragula.js',
            'majima.grid.js',
            'majima.majima_wysiwyg.js',
            'trumbowyg.js',
            'trumbowyg.bgcolor.js',
            'trumbowyg.colors.js',
            'trumbowyg.noembed.js',
            'trumbowyg.pasteimage.js',
            'trumbowyg.preformatted.js',
            'trumbowyg.table.js',
            'trumbowyg.upload.js',
        ]);
        return $assetCollection;
    }
}