<?php

namespace OpenOrchestra\ModelBundle\Repository;

use OpenOrchestra\ModelInterface\Model\KeywordInterface;
use OpenOrchestra\ModelInterface\Repository\KeywordRepositoryInterface;

/**
 * Class KeywordRepository
 */
class KeywordRepository extends AbstractRepository implements KeywordRepositoryInterface
{
    /**
     * @param string $label
     *
     * @return KeywordInterface
     */
    public function findOneByLabel($label)
    {
        return $this->findOneBy(array('label' => $label));
    }

    /**
     * @return mixed
     */
    public function getManager()
    {
        return $this->getDocumentManager();
    }
}
