<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\Mapping;
use Doctrine\ODM\MongoDB\UnitOfWork;
use PHPOrchestra\BaseBundle\Context\CurrentSiteIdInterface;
use PHPOrchestra\ModelBundle\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class NodeRepository
 */
class NodeRepository extends DocumentRepository
{
    /**
     * @var CurrentSiteIdInterface
     */
    protected $currentSiteManager;

    /**
     * @param CurrentSiteIdInterface $currentSiteManager
     */
    public function setCurrentSiteManager(CurrentSiteIdInterface $currentSiteManager)
    {
        $this->currentSiteManager = $currentSiteManager;
    }

    /**
     * @return Cursor
     */
    public function getFooterTree()
    {
        $qb = $this->buildTreeRequest();
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->field('inFooter')->equals(true);

        return $qb->getQuery()->execute();
    }

    /**
     * @return Cursor
     */
    public function getMenuTree()
    {
        $qb = $this->buildTreeRequest();
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->field('inMenu')->equals(true);

        return $qb->getQuery()->execute();
    }

    /**
     * @param NodeInterface $node
     * @param string        $areaId
     *
     * @return AreaInterface|null
     */
    public function findAreaFromNodeAndAreaId(NodeInterface $node, $areaId)
    {
        foreach ($node->getAreas() as $area) {
            if ($areaId == $area->getAreaId()) {
                return $area;
            }
            if ($selectedArea = $this->findAreaByAreaId($area, $areaId)) {
                return $selectedArea;
            }
        }

        return null;
    }

    /**
     * @param AreaInterface $area
     * @param string        $areaId
     *
     * @return null|AreaInterface
     */
    protected function findAreaByAreaId(AreaInterface $area, $areaId)
    {
        foreach ($area->getAreas() as $subArea) {
            if ($areaId == $subArea->getAreaId()) {
                return $subArea;
            }
            if ($selectedArea = $this->findAreaByAreaId($subArea, $areaId)) {
                return $selectedArea;
            }
        }

        return null;
    }

    /**
     * @return \Doctrine\ODM\MongoDB\Query\Builder
     */
    protected function buildTreeRequest()
    {
        $qb = $this->createQueryBuilder('n');

        $qb->field('status.published')->equals(true);

        $qb->field('deleted')->equals(false);

        return $qb;
    }

    /**
     * @param string $nodeId
     *
     * @return mixed
     */
    public function findWithPublishedAndLastVersionAndSiteId($nodeId)
    {
        $qb = $this->buildTreeRequest();

        $qb->field('nodeId')->equals($nodeId);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->sort('version', 'desc');

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param string      $nodeId
     * @param int|null    $version
     *
     * @return mixed
     */
    public function findOneByNodeIdAndVersionAndSiteId($nodeId, $version = null)
    {
        if (!empty($version)) {
            $qb = $this->createQueryBuilder('n');
            $qb->field('nodeId')->equals($nodeId);
            $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
            $qb->field('deleted')->equals(false);
            $qb->field('version')->equals((int) $version);

            return $qb->getQuery()->getSingleResult();
        } else {
            return $this->findWithPublishedAndLastVersionAndSiteId($nodeId);
        }
    }

    /**
     * @param string $nodeId
     *
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     *
     * @return mixed
     */
    public function findByNodeIdAndSiteId($nodeId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());

        return $qb->getQuery()->execute();
    }

    /**
     * @param string $nodeId
     *
     * @return mixed
     */
    public function findOneByNodeIdAndSiteIdAndLastVersion($nodeId)
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('nodeId')->equals($nodeId);
        $qb->field('deleted')->equals(false);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());
        $qb->sort('version', 'desc');

        $node = $qb->getQuery()->getSingleResult();

        return $node;
    }

    /**
     * @return array
     */
    public function findLastVersionBySiteId()
    {
        $qb = $this->createQueryBuilder('n');
        $qb->field('deleted')->equals(false);
        $qb->field('siteId')->equals($this->currentSiteManager->getCurrentSiteId());

        $list = $qb->getQuery()->execute();
        $nodes = array();

        foreach ($list as $node) {
            if (!empty($nodes[$node->getNodeId()])) {
                if ($nodes[$node->getNodeId()]->getVersion() < $node->getVersion()) {
                    $nodes[$node->getNodeId()] = $node;
                }
            } else {
                $nodes[$node->getNodeId()] = $node;
            }
        }

        return $nodes;
    }

    /**
     * @param string $path
     *
     * @return Cursor
     */
    public function findChildsByPath($path)
    {
        $qb = $this->buildTreeRequest();
        $qb->field('path')->equals(new \MongoRegex('/'.preg_quote($path).'.+/'));

        return $qb->getQuery()->execute();
    }
}
