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

use Majima\Controller\AdminController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AdminControllerDecorator
 * @package Plugins\MajimaGrid\Services
 */
class AdminControllerDecorator extends AdminController
{
    /**
     * @var AdminController
     */
    private $controller;

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
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function saveGridAction(Request $request)
    {
        $pageId = (int)$request->get('p', 0);
        $rows = json_decode($request->getContent(), true);

        if (empty($rows['rows'])) {
            return new Response(
                json_encode(['success' => false]),
                200,
                ['Content-Type' => 'application/json']
            );
        }

        /** @var \FluentPDO $qb */
        $qb = $this->container->get('dbal');
        $maxRevision = $qb
            ->from('panels')
            ->select(NULL)
            ->select('MAX(revision)')
            ->where('pageID', $pageId)
            ->fetchColumn();
        $maxRevision = $maxRevision ? : 0;
        $nextRevision = $maxRevision +1 ;

        foreach ($rows['rows'] as $rowKey => $row) {
            foreach ($row as $colKey => $col) {
                $insert = [
                    'pageID'    => $pageId,
                    'revision'  => $nextRevision,
                    'rowPos'    => $rowKey,
                    'columnPos' => $colKey,
                    'subject'   => $col['subject'],
                    'type'      => $col['type'],
                    'classes'   => $col['classes']
                ];
                /**
                 * @var \FluentPDO $qb
                 */
                $qb = $this->container->get('dbal');
                $qb->insertInto('panels')
                    ->values($insert)
                    ->execute();
            }
        }

        return new Response(
            json_encode(['success' => true]),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function imageUploadAction(Request $request)
    {
        $images = $this->fileHandler($request->files->getIterator());

        if (!empty($images) && isset($images['fileToUpload'])) {
            if ($images['fileToUpload']['success']) {
                $data = [
                    'success' => $images['fileToUpload']['success'],
                    'file' => $this->container->get('router')->getContext()->getBaseUrl() . $images['fileToUpload']['filename'],
                ];
            } else {
                $data = [
                    'message' => $images['fileToUpload']['message'],
                ];
            }
        } else {
            $data = [
                'message' => 'No files uploaded.',
            ];
        }

        return new Response(
            json_encode($data),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @param $files
     * @return array
     */
    protected function fileHandler($files)
    {
        $whiteList = [
            'jpg', 'gif', 'png'
        ];

        $result = [];
        /**
         * @var UploadedFile $vi
         */
        foreach ($files as $ki => $vi) {
            $result[$ki]['files'] = $vi;
            if (($vi->getSize() < 5000 || $vi->getSize() > 2e+7) || $vi->getError() === 1) {
                $result[$ki] = [
                    'success' => false,
                    'message' => "File exceeds max size.",
                ];
                return $result;
            } else {
                $finfo = pathinfo($vi->getClientOriginalName());
                $fext = strtolower($finfo['extension']);
                $fext = $fext === "jpeg" ? "jpg" : $fext;
                if (!in_array($fext, $whiteList)) {  // invalid extension
                    unlink($vi->getRealPath());
                    $result[$ki] = [
                        'success' => false,
                        'message' => "Filetype [" . $fext . "] not allowed.",
                    ];
                } else { // valid extension.
                    $fname = "img_" . uniqid();
                    $fi = '/upload/img/' . $fname . '.' . $fext;
                    move_uploaded_file($vi->getRealPath(), BASE_DIR . $fi);
                    $result[$ki] = [
                        'success' => true,
                        'message' => $finfo['filename'].'.'.$finfo['extension']." sucessfully uploaded.",
                        'filename' => $fi,
                        'fileinfo' => ['name' => $fname, 'path' => $fi, 'extension' => $fext, 'size' => $vi->getSize()],
                    ];
                }
            }
        }

        return $result;
    }
}