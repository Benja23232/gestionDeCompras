<?php

namespace App\Repository;

use App\Entity\Pago;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pago>
 */
class PagoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pago::class);
    }

    /**
     * Devuelve todos los pagos realizados entre dos usuarios.
     *
     * @param User $pagador Usuario que realizó el pago.
     * @param User $receptor Usuario que recibió el pago.
     * @return Pago[] Lista de pagos entre ambos.
     */
    public function findPagosEntreUsuarios(User $pagador, User $receptor): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.pagador = :pagador')
            ->andWhere('p.receptor = :receptor')
            ->setParameter('pagador', $pagador)
            ->setParameter('receptor', $receptor)
            ->getQuery()
            ->getResult();
    }
}
