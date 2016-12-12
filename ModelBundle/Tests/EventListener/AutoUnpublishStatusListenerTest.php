<?php

namespace OpenOrchestra\ModelBundle\Tests\EventListener;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use Phake;
use OpenOrchestra\ModelBundle\Document\Status;
use OpenOrchestra\ModelBundle\EventListener\AutoUnpublishStatusListener;

/**
 * Class AutoUnpublishStatusListenerTest
 */
class AutoUnpublishStatusListenerTest extends AbstractBaseTestCase
{
    /**
     * @var AutoUnpublishStatusListener
     */
    protected $listener;

    protected $lifecycleEventArgs;
    protected $postFlushEventArgs;
    protected $statusRepository;
    protected $container;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->statusRepository = Phake::mock('OpenOrchestra\ModelBundle\Repository\StatusRepository');
        $this->container = Phake::mock('Symfony\Component\DependencyInjection\Container');
        Phake::when($this->container)->get(Phake::anyParameters())->thenReturn($this->statusRepository);
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        $this->postFlushEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\PostFlushEventArgs');

        $this->listener = new AutoUnpublishStatusListener();
        $this->listener->setContainer($this->container);
    }

    /**
     * Test if method is present
     */
    public function testCallable()
    {
        $this->assertTrue(is_callable(array($this->listener, 'preUpdate')));
        $this->assertTrue(is_callable(array($this->listener, 'postFlush')));
    }

    /**
     * @param Status $status
     * @param array  $documents
     *
     * @dataProvider provideStatus
     */
    public function testPreUpdate(Status $status, $documents)
    {
        Phake::when($this->statusRepository)->findOtherByAutoUnpublishTo(Phake::anyParameters())->thenReturn($documents);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($status);

        $this->listener->preUpdate($this->lifecycleEventArgs);

        foreach ($documents as $document) {
            Phake::verify($document)->setAutoUnpublishToState(false);
        }

        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $postFlushEvent = Phake::mock('Doctrine\ODM\MongoDB\Event\PostFlushEventArgs');
        Phake::when($postFlushEvent)->getDocumentManager()->thenReturn($documentManager);

        $this->listener->postFlush($postFlushEvent);

        foreach ($documents as $document) {
            Phake::verify($documentManager)->persist($document);
        }
        Phake::verify($documentManager, Phake::times(count($documents)))->flush();
    }

    /**
     * @return array
     */
    public function provideStatus()
    {
        $status = Phake::mock('OpenOrchestra\ModelBundle\Document\Status');
        Phake::when($status)->isPublishedState()->thenReturn(true);
        Phake::when($status)->isAutoUnpublishToState()->thenReturn(true);

        $document0 = Phake::mock('OpenOrchestra\ModelBundle\Document\Status');
        Phake::when($document0)->isInitialState()->thenReturn(true);

        return array(
            array($status, array($document0)),
            array($status, array()),
        );
    }
}
