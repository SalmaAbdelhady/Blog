<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/25/16
 * Time: 9:47 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Class Post
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post extends BaseThread
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="title",type="string")
     * @NotBlank()
     */
    protected $title;


    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false, separator="-", style="camel", unique=true)
     * @ORM\Column(name="slug",type="string")
     * @var string
     */
    protected $slug;

    /**
     * @var
     * @ORM\Column(name="content",type="text")
     * @NotBlank()
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author",referencedColumnName="id",onDelete="CASCADE")
     */
    protected $author;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category",inversedBy="posts")
     * @ORM\JoinColumn(name="category",referencedColumnName="id",onDelete="CASCADE")
     * @NotBlank()
     */
    protected $category;



    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment",mappedBy="thread")
     */
    protected $comments;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    /**
     * @var
     * @ORM\Column(name="is_published",type="boolean")
     */
    protected $isPublished;


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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }


    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $Slug
     */
    public function setSlug($Slug)
    {
        $this->slug = $Slug;
    }

    /**
     * @return boolean
     */
    public function isIsCommentable()
    {
        return $this->isCommentable;
    }

    /**
     * @param boolean $isCommentable
     */
    public function setIsCommentable($isCommentable)
    {
        $this->isCommentable = $isCommentable;
    }

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


}