<?php

namespace OpenOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\ModelBundle\Document\Keyword;

/**
 * Class LoadKeywordData
 */
class LoadKeywordData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $keyword1 = new Keyword();
        $keyword1->setLabel('Lorem');
        $manager->persist($keyword1);
        $this->addReference('keyword-lorem', $keyword1);

        $keyword2 = new Keyword();
        $keyword2->setLabel('Ipsum');
        $manager->persist($keyword2);
        $this->addReference('keyword-ipsum', $keyword2);

        $keyword3 = new Keyword();
        $keyword3->setLabel('Dolor');
        $manager->persist($keyword3);
        $this->addReference('keyword-dolor', $keyword3);

        $keyword4 = new Keyword();
        $keyword4->setLabel('Sit');
        $manager->persist($keyword4);
        $this->addReference('keyword-sit', $keyword4);

        $keyword5 = new Keyword();
        $keyword5->setLabel('Amet');
        $manager->persist($keyword5);
        $this->addReference('keyword-amet', $keyword5);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }

}
