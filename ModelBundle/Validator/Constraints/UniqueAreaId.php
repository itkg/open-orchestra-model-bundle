<?php

namespace OpenOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueAreaId
 */
class UniqueAreaId extends Constraint
{
    public $message = 'open_orchestra_model_validators.document.area.unique_area_id';

    /**
     * @return string|void
     */
    public function validatedBy()
    {
        return 'unique_area_id';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
