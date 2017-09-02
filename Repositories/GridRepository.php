<?php
/**
 * Copyright (c) 2017
 *
 * @package   Majima
 * @author    David Neustadt <kontakt@davidneustadt.de>
 * @copyright 2017 David Neustadt
 * @license   MIT
 */

namespace Plugins\MajimaGrid\Repositories;

/**
 * Class GridRepository
 * @package Plugins\MajimaGrid\Repositories
 */
class GridRepository
{
    /**
     * @var \FluentPDO
     */
    private $qb;

    /**
     * GridRepository constructor.
     * @param \FluentPDO $qb
     */
    public function __construct(\FluentPDO $qb)
    {
        $this->qb = $qb;
    }

    /**
     * @param $pageId
     * @return array
     */
    public function getRevisionsByPageId($pageId)
    {
        return $this->qb
            ->from('panels')
            ->select(NULL)
            ->select('revision')
            ->where('pageID', $pageId)
            ->fetchPairs('revision', 'revision');
    }

    /**
     * @param $revision int
     * @param $pageId int
     * @return array
     */
    public function getPanelsByRevision($revision, $pageId)
    {
        return $this->qb
            ->from('panels')
            ->where('pageID', $pageId)
            ->where('revision', $revision)
            ->orderBy('rowPos ASC')
            ->orderBy('columnPos ASC')
            ->fetchAll();
    }
}