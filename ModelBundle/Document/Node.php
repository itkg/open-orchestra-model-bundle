<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Blameable\Traits\BlameableDocument;
use Gedmo\Timestampable\Traits\TimestampableDocument;
use PHPOrchestra\ModelBundle\Model\AreaInterface;
use PHPOrchestra\ModelBundle\Model\BlockInterface;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Model\StatusInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Description of Node
 *
 * @ODM\Document(
 *   collection="node",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\NodeRepository"
 * )
 */
class Node implements NodeInterface
{
    use BlameableDocument;
    use TimestampableDocument;

    /**
     * @var string $id
     *
     * @ODM\Id
     */
    protected $id;

    /**
     * @var string $nodeId
     *
     * @ODM\Field(type="string")
     */
    protected $nodeId;

    /**
     * @var string $nodeType
     *
     * @ODM\Field(type="string")
     */
    protected $nodeType;

    /**
     * @var string $siteId
     *
     * @ODM\Field(type="string")
     */
    protected $siteId;

    /**
     * @var string $parentId
     *
     * @ODM\Field(type="string")
     */
    protected $parentId;

    /**
     * @var string $path
     *
     * @ODM\Field(type="string")
     */
    protected $path;

    /**
     * @var string $alias
     *
     * @ODM\Field(type="string")
     */
    protected $alias;

    /**
     * @var string $name
     *
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var int $version
     *
     * @ODM\Field(type="int")
     */
    protected $version = 1;

    /**
     * @var string $language
     *
     * @ODM\Field(type="string")
     */
    protected $language;

    /**
     * @var StatusInterface $status
     *
     * @ODM\EmbedOne(targetDocument="EmbedStatus")
     */
    protected $status;

    /**
     * @var boolean
     *
     * @ODM\Field(type="boolean")
     */
    protected $deleted = false;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $templateId;

    /**
     * @var string
     *
     * @ODM\Field(type="string")
     */
    protected $theme;

    /**
     * @var boolean
     *
     * @ODM\Field(type="boolean")
     */
    protected $inMenu;

    /**
     * @var boolean
     *
     * @ODM\Field(type="boolean")
     */
    protected $inFooter;

    /**
     * @var ArrayCollection
     *
     * @ODM\EmbedMany(targetDocument="Area")
     */
    protected $areas;

    /**
     * @var BlockInterface
     *
     * @ODM\EmbedMany(targetDocument="Block")
     */
    protected $blocks;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->areas = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nodeId
     *
     * @param string $nodeId
     */
    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;
    }

    /**
     * Get nodeId
     *
     * @return string
     */
    public function getNodeId()
    {
        return $this->nodeId;
    }

    /**
     * Set nodeType
     *
     * @param string $nodeType
     */
    public function setNodeType($nodeType)
    {
        $this->nodeType = $nodeType;
    }

    /**
     * Get nodeType
     *
     * @return string $nodeType
     */
    public function getNodeType()
    {
        return $this->nodeType;
    }

    /**
     * Set siteId
     *
     * @param string $siteId
     */
    public function setSiteId($siteId)
    {
        $this->siteId = $siteId;
    }

    /**
     * Get siteId
     *
     * @return string $siteId
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * Set parentId
     *
     * @param string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * Get parentId
     *
     * @return string $parentId
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set alias
     *
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get alias
     *
     * @return string $alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set version
     *
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * Get version
     *
     * @return int $version
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set language
     *
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return string $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set status
     *
     * @param StatusInterface $status
     */
    public function setStatus(StatusInterface $status)
    {
        $this->status = EmbedStatus::createFromStatus($status);
    }

    /**
     * Get status
     *
     * @return StatusInterface $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Get deleted
     *
     * @return boolean $deleted
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set templateId
     *
     * @param string $templateId
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * Get templateId
     *
     * @return string $templateId
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * Set theme
     *
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get theme
     *
     * @return string $theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Add block
     *
     * @param BlockInterface $block
     */
    public function addBlock(BlockInterface $block)
    {
        $this->blocks->add($block);
    }

    /**
     * Set blocks
     *
     * @param Collection $block
     */
    public function setBlocks(Collection $blocks)
    {
        $this->blocks->clear();
        foreach($blocks as $block){
            $this->blocks->add($block);
        }
    }

    /**
     * @param BlockInterface $block
     *
     * @return bool|int|mixed|string
     */
    public function getBlockIndex(BlockInterface $block)
    {
        return $this->blocks->indexOf($block);
    }

    /**
     * @param int            $key
     * @param BlockInterface $block
     */
    public function setBlock($key, BlockInterface $block)
    {
        $this->blocks->set($key, $block);
    }

    /**
     * Remove block
     *
     * @param BlockInterface $block
     */
    public function removeBlock(BlockInterface $block)
    {
        $this->blocks->removeElement($block);
    }

    /**
     * Get blocks
     *
     * @return ArrayCollection $blocks
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param AreaInterface $area
     */
    public function addArea(AreaInterface $area)
    {
        $this->areas->add($area);
    }

    /**
     * @param Collection $areas
     */
    public function setAreas(Collection $areas)
    {
        $this->areas->clear();
        foreach($areas as $area){
            $this->areas->add($area);
        }
    }

    /**
     * @param AreaInterface $area
     */
    public function removeArea(AreaInterface $area)
    {
        $this->areas->removeElement($area);
    }

    /**
     * Remove subArea by areaId
     *
     * @param string $areaId
     */
    public function removeAreaByAreaId($areaId)
    {
        foreach ($this->getAreas() as $key => $area) {
            if ($areaId == $area->getAreaId()) {
                $this->getAreas()->remove($key);
                break;
            }
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * @param boolean $inFooter
     */
    public function setInFooter($inFooter)
    {
        $this->inFooter = $inFooter;
    }

    /**
     * @return boolean
     */
    public function getInFooter()
    {
        return $this->inFooter;
    }

    /**
     * @param boolean $inMenu
     */
    public function setInMenu($inMenu)
    {
        $this->inMenu = $inMenu;
    }

    /**
     * @return boolean
     */
    public function getInMenu()
    {
        return $this->inMenu;
    }

    /**
     * Clone method
     */
    public function __clone()
    {
        if (!is_null($this->id)) {
            $this->id = null;
            $this->areas = new ArrayCollection();
            $this->blocks = new ArrayCollection();
            $this->setCreatedAt(new \DateTime());
            $this->setUpdatedAt(new \DateTime());
        }
    }
}
