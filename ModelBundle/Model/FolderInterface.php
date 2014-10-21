<?php

namespace PHPOrchestra\ModelBundle\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Interface FolderInterface
 */
interface FolderInterface extends TimestampableInterface, BlameableInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return FolderInterface
     */
    public function getParent();

    /**
     * @param FolderInterface $parent
     */
    public function setParent(FolderInterface $parent);

    /**
     * @return Collection
     */
    public function getSubFolders();

    /**
     * @param string $siteId
     *
     * @return Collection
     */
    public function getSubFoldersBySiteId($siteId);

    /**
     * @param FolderInterface $subFolder
     */
    public function addSubFolder(FolderInterface $subFolder);

    /**
     * @param FolderInterface $subFolder
     */
    public function removeSubFolder(FolderInterface $subFolder);

    /**
     * @return Collection
     */
    public function getSites();

    /**
     * @param SiteInterface $site
     */
    public function addSite(SiteInterface $site);

    /**
     * @param SiteInterface $site
     */
    public function removeSite(SiteInterface $site);
}
