<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 1/27/16
 * Time: 9:51 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @param $limit
     * @param $page
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllPostsQuery($limit, $page)
    {
        $query = $this->createQueryBuilder('p');
        $query = $query->select('p')
            ->where($query->expr()->eq('p.isPublished', true))
            ->orderBy('p.updated', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($page);

        return $query;
    }

    /**
     * @param Category $category
     * @param          $limit
     * @param          $page
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPostsByCategoryQuery(Category $category, $limit, $page)
    {
        $query = $this->createQueryBuilder('p');
        $categoriesIds[] = $category->getId();
        $categories      = $category->getChildren();
        foreach ($categories as $cat) {
            $categoriesIds [] = $cat->getId();
        }
        return $query->select('p')
            ->where($query->expr()->eq('p.isPublished', true))
            ->andWhere($query->expr()->in('p.category', $categoriesIds))
            ->orderBy('p.updated', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult($page);
    }
}