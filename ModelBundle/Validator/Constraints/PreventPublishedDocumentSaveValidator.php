<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class PreventPublishedDocumentSaveValidator
 */
class PreventPublishedDocumentSaveValidator extends ConstraintValidator
{
    protected $translator;

    /**
     *
     * @param Translator $translator
     * @param DocumentManager $documentManager
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (array_key_exists('PHPOrchestra\ModelBundle\Model\StatusableInterface', class_implements($value))) {
            $status = $value->getStatus();
            if (! empty($status) && $status->isPublished()) {
                $this->context->addViolation($this->translator->trans($constraint->message));
            }
        }

        return;
    }
}
