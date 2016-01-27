<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/25/16
 * Time: 9:47 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class Category
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @NotBlank()
     */
    protected $name;


    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true, separator="-", style="camel", unique=true)
     * @ORM\Column(name="slug",type="string",nullable=true)
     * @var string
     */
    protected $slug;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category",inversedBy="children")
     * @ORM\JoinColumn(name="parent",referencedColumnName="id",onDelete="CASCADE")
     */
    protected $parent;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category",mappedBy="parent")
     */
    protected $children;

    /**
     * @var
     * @ORM\Column(name="visibility",type="boolean")
     */
    protected $visibility;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Post",mappedBy="category")
     */
    protected $posts;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }

}