<?php

namespace PHPOrchestra\ModelBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use Assetic\Exception\Exception;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class GenerateIdListener
 */
class GenerateIdListener
{
    protected $container;
    protected $annotationReader;

    /**
     * @param Container $container
     * @param AnnotationReader $annotationReader
     */
    public function __construct(Container $container, AnnotationReader $annotationReader)
    {
        $this->container = $container;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $document = $event->getDocument();
        $className = get_class($document);
        $generateAnnotations = $this->annotationReader->getClassAnnotation(new \ReflectionClass($className), 'PHPOrchestra\ModelBundle\Mapping\Annotations\Document');
        if (!is_null($generateAnnotations)) {
            $generateAnnotations->initRepository($this->container);
            $documentManager = $event->getDocumentManager();
            $getSource = $generateAnnotations->getSource($document);
            $getGenerated = $generateAnnotations->getGenerated($document);
            $setGenerated = $generateAnnotations->setGenerated($document);

            if (is_null($document->$getGenerated())) {
                $sourceId = $document->$getSource();
                $accents = '/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig|tilde);/';
                $sourceId = htmlentities($sourceId, ENT_NOQUOTES, 'UTF-8');
                $sourceId = preg_replace($accents, '$1', $sourceId);
                $sourceId = preg_replace('/[[:^print:]]/', '_', $sourceId);
                $sourceId = strtolower($sourceId);
                $sourceId = rawurlencode($sourceId);
                $generatedId = $sourceId;
                $count = 0;

                while($generateAnnotations->exists($generatedId)){
                    $generatedId = $sourceId . '_' . $count;
                    $count++;
                }

                $document->$setGenerated($generatedId);
            }
        }
    }
}
