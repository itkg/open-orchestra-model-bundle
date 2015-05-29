<?php

namespace OpenOrchestra\ModelBundle\Repository;

use OpenOrchestra\ModelBundle\Repository\RepositoryTrait\PaginateAndSearchFilterTrait;
use OpenOrchestra\ModelInterface\Model\ReadSiteInterface;
use OpenOrchestra\ModelInterface\Model\SiteInterface;
use OpenOrchestra\ModelInterface\Repository\SiteRepositoryInterface;

/**
 * Class SiteRepository
 */
class SiteRepository extends AbstractRepository implements SiteRepositoryInterface
{
    use PaginateAndSearchFilterTrait;

    /**
     * @param string $siteId
     *
     * @return SiteInterface
     */
    public function findOneBySiteId($siteId)
    {
        return $this->findOneBy(array('siteId' => $siteId));
    }

    /**
     * @param $siteId
     *
     * @return SiteInterface
     */
    public function findOneBySiteIdNotDeleted($siteId)
    {
        return $this->findOneBy(array('siteId' => $siteId, 'deleted' => false));
    }


    /**
     * @param boolean $deleted
     *
     * @return array
     */
    public function findByDeleted($deleted)
    {
        return $this->findBy(array('deleted' => $deleted));
    }


    /**
     * @param boolean     $deleted
     * @param array|null  $columns
     * @param string|null $search
     * @param array|null  $order
     * @param int|null    $skip
     * @param int|null    $limit
     *
     * @return array
     */
    public function findByDeletedForPaginateAndSearch($deleted, $columns = null, $search = null, $order = null, $skip = null, $limit = null)
    {
        $qa = $this->createAggregationQuery();
        $qa->match(array('deleted' => $deleted));
        $qa = $this->generateFilterForPaginateAndSearch($qa, $columns, $search, $order, $skip, $limit);

        return $this->hydrateAggregateQuery($qa);
    }

    /**
     * @param boolean $deleted
     *
     * @return int
     */
    public function countByDeleted($deleted)
    {
        $qa = $this->createAggregationQuery();
        $qa->match(array('deleted' => $deleted));

        return $this->countDocumentAggregateQuery($qa);
    }

    /**
     * @param boolean      $deleted
     * @param array|null   $columns
     * @param array|null   $search
     *
     * @return int
     */
    public function countByDeletedFilterSearch($deleted, $columns = null, $search = null)
    {
        $qa = $this->createAggregationQuery();
        $qa->match(array('deleted' => $deleted));

        $qa = $this->generateFilterForSearch($qa, $columns, $search);

        return $this->countDocumentAggregateQuery($qa);
    }

    /**
     * @param string $domain
     *
     * @return ReadSiteInterface
     */
    public function findByAliasDomain($domain)
    {
        $qb = $this->createQueryBuilder();
        $qb->field('aliases.domain')->equals($domain);

        return $qb->getQuery()->getSingleResult();
    }
}
