<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

use Doctrine\ORM\QueryBuilder;
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
        $this->paginator = $paginator;
    }

    /**
     * @return paginationInterface 
     * 
     */

    public function findSearch(SearchData $search): PaginationInterface
    {

        $query = $this->getSearchQuery($search)->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            10
        );
    }

    /**
     * recupere le prix min et max qui reflete la bdd pour une recherche
     * @return integer[]
     */

    public function findMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.cout) as min', 'MAX(p.cout) as max')
            ->getQuery()
            ->getScalarResult();
        return [(int)$results[0]['min'], (int)$results[0]['max']];
    }

    private function getSearchQuery(SearchData $search, $ignorePrice=false): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.categories', 'c');


        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.denomination Like :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->min) && $ignorePrice === false) {
            $query = $query
                ->andWhere('p.cout >= :min')
                ->setParameter('min', $search->min);
        }

        if (!empty($search->max)&& $ignorePrice === false) {
            $query = $query
                ->andWhere('p.cout <= :max')
                ->setParameter('max', $search->max);
        }


        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        return $query;
    }
}
