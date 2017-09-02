<?php
/**
 * Copyright (c) 2017
 *
 * @package   Majima
 * @author    David Neustadt <kontakt@davidneustadt.de>
 * @copyright 2017 David Neustadt
 * @license   MIT
 */

namespace Plugins\MajimaGrid\Services;

use Majima\Controller\IndexController;
use Plugins\MajimaGrid\Repositories\GridRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class IndexControllerDecorator
 * @package Plugins\MajimaGrid\Services
 */
class IndexControllerDecorator extends IndexController
{
    /**
     * @var IndexController
     */
    private $controller;

    /**
     * @var GridRepository
     */
    private $gridRepository;

    /**
     * IndexControllerDecorator constructor.
     * @param $controller
     * @param Container $container
     * @param RouterInterface $router
     */
    public function __construct($controller, Container $container, RouterInterface $router)
    {
        parent::__construct($container, $router);

        $this->controller = $controller;
        $this->gridRepository = new GridRepository($this->dbal);
    }

    /**
     * @return GridRepository
     */
    public function getGridRepository()
    {
        return $this->gridRepository;
    }

    public function indexAction(Request $request)
    {
        $this->controller->indexAction($request);

        $pageId = (int)$request->get('p', 0);
        $requestedRevision = (int)$request->get('r', 0);

        $revisions = $this->getGridRepository()->getRevisionsByPageId($pageId);
        $currentRevision = $maxRevision = !empty($revisions) ? max(array_keys($revisions)) : 0;

        if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $currentRevision = $requestedRevision ?: (int)$maxRevision;
        }

        $cols = $this->getGridRepository()->getPanelsByRevision($currentRevision, $pageId);

        $rows = [];

        foreach ($cols as $col) {
            $rows[$col['rowPos']][] = $col;
        };

        $this->assign(
            [
                'rows' => $rows,
                'revisions' => $revisions,
                'current_revision' => $currentRevision,
                'max_revision' => $maxRevision,
            ]
        );
    }
}