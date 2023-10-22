<?php

namespace App\Services;

use App\Entity\StatusUser;
use App\Entity\Location;
use App\Entity\TypeLocation;
use App\Entity\Programme;
use App\Entity\UserInfos;
//use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

class FetchDataService
{
    const PATH_TO_CONFIG = '/config/packages/uvdesk_mailbox.yaml';

    //protected $container;
	protected $requestStack;
    protected $entityManager;
    //protected $fileUploadService;
    //protected $userService;

    public function __construct(
        //ContainerInterface $container,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager
        /*FileUploadService $fileUploadService,
        UserService $userService*/)
    {
        //$this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        //$this->fileUploadService = $fileUploadService;
        //$this->userService = $userService;
    }

    public function getStatusUsers()
    {
        static $statusUsers;
        if (null !== $statusUsers)
            return $statusUsers;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('su.id','su.libelle As libelle')->from(StatusUser::class, 'su')
                ->orderBy('su.libelle', 'ASC');

        return $statusUsers = $qb->getQuery()->getArrayResult();
    }

    public function getUserPrograms()
    {
        static $userPrograms;
        if (null !== $userPrograms)
            return $userPrograms;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('p.id', 'p.libelle As libelle')->from(Programme::class, 'p')
            ->orderBy('p.libelle', 'ASC');

        return $userPrograms = $qb->getQuery()->getArrayResult();
    }

    public function getRegions() {
        static $regions;
        if (null !== $regions)
            return $regions;

		$qb = $this->entityManager->createQueryBuilder();
        $qb->select('l.id','l.libelle As name')->from(Location::class, 'l')
                ->innerJoin('l.typeLocation', 'tl')
                ->andWhere('tl.libelle = :typeLocation')
                ->orderBy('l.libelle', 'ASC')
                ->setParameter('typeLocation', 'Region');

        return $regions = $qb->getQuery()->getArrayResult();
    }

    public function getSubdivisionsOf($division, $parent) {

		$qb = $this->entityManager->createQueryBuilder();
        $qb->select('l.id','l.libelle As name')->from(Location::class, 'l')
                ->innerJoin('l.typeLocation', 'tl')
                ->andWhere('tl.libelle = :typeLocation')
                ->andWhere('l.parent = :parent')
                ->orderBy('l.libelle', 'ASC')
                ->setParameters(['typeLocation' => $division, 'parent' => $parent]);

        return $qb->getQuery()->getArrayResult();
    }

    public function getTypeLocations() {

		$qb = $this->entityManager->createQueryBuilder();
        $qb->select('tl.id','tl.libelle As libelle')->from(TypeLocation::class, 'tl')
                ->orderBy('tl.libelle', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    public function getUserLocation($user) {

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('ui')->from(UserInfos::class, 'ui')
            ->addSelect('c')
            ->innerJoin('ui.commune', 'c')
            ->andWhere('ui.user = :user')
            ->setParameter('user', $user);
        $userInfo = $qb->getQuery()->getOneOrNullResult();
        return $userInfo != null ? $userInfo->getCommune() : null;

    }

    public function getTicketLocation($ticket) {

        $qb = $this->entityManager->getRepository->createQueryBuilder();
        $qb->select('tl')->from(TicketLocation::class, 'tl')
            ->addSelect('l')
            ->innerJoin('tl.location', 'l')
            ->andWhere('tl.ticket = :ticket')
            ->setParameter('user', $ticket);
        $ticketLocation = $qb->getQuery()->getOneOrNullResult();
        return $ticketLocation != null ? $ticketLocation->getLocation() : null;

    }

    public function getCommunesOf($location) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('l.id')->from(Location::class, 'l');
        switch($location->getTypeLocation()->getLibelle()) {
            case TypeLocation::COMMUNE :
                return [$location->getId()];
            case TypeLocation::DEPARTEMENT :
                $qb->addWhere('l.parent = :parent')->setParameter('parent', $location);
                break;
            case TypeLocation::REGION :
                $qb->innerJoin('l.parent', 'd')
                    ->andWhere('d.parent = :parent')->setParameter('parent', $location);
                break;
        }
        return $qb->getQuery()->getSingleColumnResult(); //->getArrayResult();
    }

}
