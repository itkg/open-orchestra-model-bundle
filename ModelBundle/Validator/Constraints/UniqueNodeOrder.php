<?php

namespace OpenOrchestra\ModelBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class UniqueNodeOrder
 */
class UniqueNodeOrder extends Constraint
{
    public $message = 'open_orchestra_model_validators.document.node.unique_node_order';

    /**
     * @return string|void
     */
    public function validatedBy()
    {
        return 'unique_node_order';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
