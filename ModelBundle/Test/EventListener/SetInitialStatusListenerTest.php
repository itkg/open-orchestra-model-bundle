<?php

namespace OpenOrchestra\BackofficeBundle\Test\EventListener;

use Phake;
use OpenOrchestra\ModelBundle\Document\Node;
use OpenOrchestra\ModelBundle\Document\Status;
use OpenOrchestra\ModelBundle\EventListener\SetInitialStatusListener;

/**
 * Class SetInitialStatusListenerTest
 */
class SetInitialStatusListenerTest extends \PHPUnit_Framework_TestCase
{
    protected $listener;
    protected $lifecycleEventArgs;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->lifecycleEventArgs = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');

        $this->listener = new SetInitialStatusListener();
    }

    /**
     * Test if method is present
     */
    public function testCallable()
    {
        $this->assertTrue(is_callable(array(
            $this->listener,
            'prePersist'
        )));
    }

    /**
     * @param Node   $node
     * @param Status $status
     *
     * @dataProvider provideNodeForPersist
     */
    public function testprePersist(Node $node, Status $status)
    {
        $documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        $statusRepository = Phake::mock('OpenOrchestra\ModelBundle\Repository\StatusRepository');
        Phake::when($statusRepository)->findOneByInitial()->thenReturn($status);
        Phake::when($documentManager)->getRepository('OpenOrchestraModelBundle:Status')->thenReturn($statusRepository);
        Phake::when($this->lifecycleEventArgs)->getDocument()->thenReturn($node);
        Phake::when($this->lifecycleEventArgs)->getDocumentManager()->thenReturn($documentManager);

        $this->listener->prePersist($this->lifecycleEventArgs);

        Phake::verify($node, Phake::times(1))->setStatus($status);
    }

    /**
     *
     * @return array
     */
    public function provideNodeForPersist()
    {
        $node = Phake::mock('OpenOrchestra\ModelBundle\Document\Node');
        $status = Phake::mock('OpenOrchestra\ModelBundle\Document\Status');

        return array(
            array($node, $status)
        );
    }
}
