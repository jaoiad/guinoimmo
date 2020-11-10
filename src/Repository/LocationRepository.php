<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{

    /**
     * @var paginatorInterface
     * 
     */
     private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Location::class);
        $this->paginator= $paginator;
    }

    /**
     * @return paginationInterface 
     * 
     */

    public function findSearch(SearchData $search): PaginationInterface    {

        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.categories', 'c');


        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.denomination Like :q')
                ->setParameter('q', "%{$search->q}%");
            }

            if(!empty($search->min)){
                $query=$query
                ->andWhere('p.cout >= :min')
                ->setParameter('min', $search->min);

            }

        if (!empty($search->max)) {
            $query = $query
                ->andWhere('p.cout <= :max')
                ->setParameter('max', $search->max);
        }


        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories',$search->categories);
        }
          $query= $query->getQuery();
          return $this->paginator->paginate(
                $query,
           $search->page,
          10
          );
    }
}
