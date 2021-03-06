<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param string $orderBy
     * @return Post[]
     */
    public function findAll($orderBy = 'DESC')
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('post')
            ->from('AppBundle:Post', 'post')
            ->orderBy('post.createdAt', $orderBy)
            ->getQuery()
            ->getResult();
    }


    /**
     * @param $day
     * @param $month
     * @param $year
     * @param string $orderBy
     * @return Post
     */
    public function getPostsByDate($day, $month, $year,  $orderBy = 'DESC'){
        $qb =  $this->getEntityManager()->createQueryBuilder();
        return $qb->select('post')
            ->from('AppBundle:Post', 'post')
            ->where($qb->expr()->like('post.createdAt', '?1'))
            ->orderBy('post.createdAt', $orderBy)
            ->setParameter(1, $year . '-' . $month . '-' . $day . '%')->getQuery()
            ->getResult();
    }


    public function getPostsCreatedBy(User $user){
        $qb =  $this->getEntityManager()->createQueryBuilder();
        return $qb->select('post')
            ->from('AppBundle:Post', 'post')
            ->leftJoin('post.author', 'author')
            ->where('post.author = ' . $user->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $day
     * @param $month
     * @param $year
     * @param $slug
     * @return Post
     */
    public function getPostsByDateAndSlug($day, $month, $year, $slug){
            $qb =  $this->getEntityManager()->createQueryBuilder();
            $result =$qb->select('post')
            ->from('AppBundle:Post', 'post')
            ->where($qb->expr()->like('post.createdAt', '?1'))
            ->andWhere($qb->expr()->eq('post.slug', '?2'))
            ->setParameter(1, $year . '-' . $month . '-' . $day . '%')
            ->setParameter(2, $slug)
            ->getQuery()
            ->getResult();
            if(count($result) > 0) {
                return $result[0];
            } else {
                throw new NotFoundHttpException("L'article n'a pas été trouvé");
            };
    }

}
