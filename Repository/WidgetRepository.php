<?php

namespace Tkuska\DashboardBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Tkuska\DashboardBundle\Entity\Widget;

/**
 * @method Widget|null find($id, $lockMode = null, $lockVersion = null)
 * @method Widget|null findOneBy(array $criteria, array $orderBy = null)
 * @method Widget[]    findAll()
 * @method Widget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WidgetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Widget::class);
    }
    
    // /**
    //  * Gets all widgets connected with user user account
    //  * @param \Symfony\Component\Security\Core\User\UserInterface $user
    //  * @return \Doctrine\ORM\QueryBuilder
    //  */
    // public function getMyWidgets(UserInterface $user)
    // {
    //     $userId = method_exists($user, 'getId') ? $user->getId() : -1;

    //     return $this->createQueryBuilder("w")
    //         ->select('w')
    //         ->where('w.user_id = :user_id')
    //         ->setParameter('user_id', $userId)
    //     ;
    // }

    /**
     * Get the current user's widgets.
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getMyWidgets(UserInterface $user)
    {
        $userId = method_exists($user, 'getId') ? $user->getId() : null;

        return $this->createQueryBuilder("w")
            ->select('w')
            ->where('w.user_id = :user_id')
            ->setParameter('user_id', $userId)
        ;
    }

    public function deleteMyWidgets($user_id)
    {
        $this->createQueryBuilder("w")
            ->delete()
            ->where("w.user_id = :user_id")
            ->setParameter("user_id", $user_id)
            ->getQuery()
            ->execute()
        ;
    }
}
