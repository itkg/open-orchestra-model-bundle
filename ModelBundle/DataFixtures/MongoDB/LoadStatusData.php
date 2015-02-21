<?php

namespace OpenOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\ModelBundle\Document\Status;
use OpenOrchestra\ModelBundle\Document\TranslatedValue;

/**
 * Class LoadStatusData
 */
class LoadStatusData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $draft = $this->loadDraft();
        $manager->persist($draft);

        $pending = $this->loadPending();
        $manager->persist($pending);

        $published = $this->loadPublished();
        $manager->persist($published);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 40;
    }

    /**
     * @return Status
     */
    protected function loadDraft()
    {
        $draftEn = new TranslatedValue();
        $draftEn->setLanguage('en');
        $draftEn->setValue('draft');
        $draftFr = new TranslatedValue();
        $draftFr->setLanguage('fr');
        $draftFr->setValue('brouillon');
        $draftDe = new TranslatedValue();
        $draftDe->setLanguage('de');
        $draftDe->setValue('Entwurf');
        $draftEs = new TranslatedValue();
        $draftEs->setLanguage('es');
        $draftEs->setValue('proyecto');

        $draft = new Status();
        $draft->setName('draft');
        $draft->addLabel($draftEn);
        $draft->addLabel($draftFr);
        $draft->addLabel($draftDe);
        $draft->addLabel($draftEs);
        $draft->setDisplayColor('green');
        $draft->setInitial(true);

        $this->addReference('status-draft', $draft);

        return $draft;
    }

    /**
     * @return Status
     */
    protected function loadPending()
    {
        $pendingEn = new TranslatedValue();
        $pendingEn->setLanguage('en');
        $pendingEn->setValue('pending');
        $pendingFr = new TranslatedValue();
        $pendingFr->setLanguage('fr');
        $pendingFr->setValue('En attente');
        $pendingDe = new TranslatedValue();
        $pendingDe->setLanguage('de');
        $pendingDe->setValue('anstehend');
        $pendingEs = new TranslatedValue();
        $pendingEs->setLanguage('es');
        $pendingEs->setValue('pendiente');

        $pending = new Status();
        $pending->setName('pending');
        $pending->addLabel($pendingEn);
        $pending->addLabel($pendingFr);
        $pending->addLabel($pendingDe);
        $pending->addLabel($pendingEs);
        $pending->setDisplayColor('orange');

        $this->addReference('status-pending', $pending);

        return $pending;
    }

    /**
     * @return Status
     */
    protected function loadPublished()
    {
        $publishedEn = new TranslatedValue();
        $publishedEn->setLanguage('en');
        $publishedEn->setValue('published');
        $publishedFr = new TranslatedValue();
        $publishedFr->setLanguage('fr');
        $publishedFr->setValue('Publié');
        $publishedDe = new TranslatedValue();
        $publishedDe->setLanguage('de');
        $publishedDe->setValue('veröffentlicht');
        $publishedEs = new TranslatedValue();
        $publishedEs->setLanguage('es');
        $publishedEs->setValue('publicado');

        $published = new Status();
        $published->setName('published');
        $published->setPublished(true);
        $published->addLabel($publishedEn);
        $published->addLabel($publishedFr);
        $published->addLabel($publishedDe);
        $published->addLabel($publishedEs);
        $published->setDisplayColor('red');

        $this->addReference('status-published', $published);

        return $published;
    }
}
