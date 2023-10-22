<?php

namespace App\Repository;

use App\Entity\TicketLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
//use Doctrine\ORM\Query;
//use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Collections\Criteria;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
/*use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\ParameterBag;*/
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @extends ServiceEntityRepository<TicketLocation>
 *
 * @method TicketLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TicketLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TicketLocation[]    findAll()
 * @method TicketLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketLocationRepository extends ServiceEntityRepository
{
    const LIMIT = 15;
    const TICKET_GLOBAL_ACCESS = 1;
    const TICKET_GROUP_ACCESS = 2;
    const TICKET_TEAM_ACCESS  = 3;
    const DEFAULT_PAGINATION_LIMIT = 15;

    private $container;
    private $requestStack;
    private $safeFields = ['page', 'limit', 'sort', 'order', 'direction'];

    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        parent::__construct($registry, TicketLocation::class);
        $this->container = $container;
    }

    public function add(TicketLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TicketLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /*
    public function prepareBaseTicketQuery(User $user, /*$communesCouvertes,* / array $supportGroupIds = [], array $supportTeamIds = [], array $params = [], bool $filterByStatus = true)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select("
                DISTINCT ticket,
                supportGroup.name as groupName,
                supportTeam.name as teamName,
                priority,
                type.code as typeName,
                agent.id as agentId,
                agent.email as agentEmail,
                agentInstance.profileImagePath as smallThumbnail,
                customer.id as customerId,
                customer.email as customerEmail,
                customerInstance.profileImagePath as customersmallThumbnail,
                CONCAT(customer.firstName, ' ', customer.lastName) AS customerName,
                CONCAT(agent.firstName,' ', agent.lastName) AS agentName
            ")
            ->from(TicketLocation::class, 'ticketLocation')
            ->leftJoin('ticketLocation.ticket', 'ticket')
            ->leftJoin('ticket.type', 'type')
            ->leftJoin('ticket.agent', 'agent')
            ->leftJoin('ticket.threads', 'threads')
            ->leftJoin('ticket.priority', 'priority')
            ->leftJoin('ticket.customer', 'customer')
            ->leftJoin('ticket.supportTeam', 'supportTeam')
            ->leftJoin('ticket.supportTags', 'supportTags')
            ->leftJoin('agent.userInstance', 'agentInstance')
            ->leftJoin('ticket.supportLabels', 'supportLabel')
            ->leftJoin('ticket.supportGroup', 'supportGroup')
            ->leftJoin('customer.userInstance', 'customerInstance')
            ->where('customerInstance.supportRole = 4')
            ->andWhere("agent.id IS NULL OR agentInstance.supportRole != 4")
            ->andWhere('ticket.isTrashed = :isTrashed')->setParameter('isTrashed', isset($params['trashed']) ? true : false);

        /*if($communesCouvertes != null) {
            $queryBuilder->andWhere('ticketLocation.location in (:locations) ')->setparameter('locations',$communesCouvertes);
        }* /

        if (!isset($params['sort'])) {
            $queryBuilder->orderBy('ticket.updatedAt', Criteria::DESC);
        }

        if ($filterByStatus) {
            $queryBuilder->andWhere('ticket.status = :status')->setParameter('status', isset($params['status']) ? $params['status'] : 1);
        }

        $this->addPermissionFilter($queryBuilder, $user, $supportGroupIds, $supportTeamIds);

        // applyFilter according to params
        return $this->prepareTicketListQueryWithParams($queryBuilder, $params, $user);
    }
    */

    public function prepareBaseTicketQuery(User $user, array $supportGroupIds = [], array $supportTeamIds = [], array $params = [], bool $filterByStatus = true)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select("
                DISTINCT ticketlocation,
                supportGroup.name as groupName,
                supportTeam.name as teamName,
                priority,
                type.code as typeName,
                agent.id as agentId,
                agent.email as agentEmail,
                agentInstance.profileImagePath as smallThumbnail,
                customer.id as customerId,
                customer.email as customerEmail,
                customerInstance.profileImagePath as customersmallThumbnail,
                CONCAT(customer.firstName, ' ', customer.lastName) AS customerName,
                CONCAT(agent.firstName,' ', agent.lastName) AS agentName
            ")
            ->from(TicketLocation::class, 'ticketlocation')
            ->innerJoin('ticketlocation.ticket', 'ticket')
            ->leftJoin('ticket.type', 'type')
            ->leftJoin('ticket.agent', 'agent')
            ->leftJoin('ticket.threads', 'threads')
            ->leftJoin('ticket.priority', 'priority')
            ->leftJoin('ticket.customer', 'customer')
            ->leftJoin('ticket.supportTeam', 'supportTeam')
            ->leftJoin('ticket.supportTags', 'supportTags')
            ->leftJoin('agent.userInstance', 'agentInstance')
            ->leftJoin('ticket.supportLabels', 'supportLabel')
            ->leftJoin('ticket.supportGroup', 'supportGroup')
            ->leftJoin('customer.userInstance', 'customerInstance')
            ->where('customerInstance.supportRole = 4')
            ->andWhere("agent.id IS NULL OR agentInstance.supportRole != 4")
            ->andWhere('ticket.isTrashed = :isTrashed')->setParameter('isTrashed', isset($params['trashed']) ? true : false);

        if (!isset($params['sort'])) {
            $queryBuilder->orderBy('ticket.updatedAt', Criteria::DESC);
        }

        if ($filterByStatus) {
            $queryBuilder->andWhere('ticket.status = :status')->setParameter('status', isset($params['status']) ? $params['status'] : 1);
        }

        $this->addPermissionFilter($queryBuilder, $user, $supportGroupIds, $supportTeamIds);

        // applyFilter according to params
        return $this->prepareTicketListQueryWithParams($queryBuilder, $params, $user);
    }

    public function prepareTicketListQueryWithParams($queryBuilder, $params, $actAsUser = null)
    {
        foreach ($params as $field => $fieldValue) {
            if (in_array($field, $this->safeFields)) {
                continue;
            }

            if($actAsUser != null ) {
                $userInstance = $actAsUser->getAgentInstance();
                if (!empty($userInstance) && ('ROLE_AGENT' == $userInstance->getSupportRole()->getCode() && $field == 'mine') || ('ROLE_ADMIN' == $userInstance->getSupportRole()->getCode()) && $field == 'mine') {
                    $fieldValue = $actAsUser->getId();
                }
            }

            switch ($field) {
                case 'label':
                    $queryBuilder->andwhere('supportLabel.id = :labelIds');
                    $queryBuilder->setParameter('labelIds', $fieldValue);
                    break;
                case 'starred':
                    $queryBuilder->andWhere('ticket.isStarred = 1');
                    break;
                case 'search':
                    $value = trim($fieldValue);
                    $queryBuilder->andwhere("ticket.subject LIKE :search OR ticket.id  LIKE :search OR customer.email LIKE :search OR CONCAT(customer.firstName,' ', customer.lastName) LIKE :search OR agent.email LIKE :search OR CONCAT(agent.firstName,' ', agent.lastName) LIKE :search");
                    $queryBuilder->setParameter('search', '%'.urldecode($value).'%');
                    break;
                case 'unassigned':
                    $queryBuilder->andWhere("agent.id is NULL");
                    break;
                case 'notreplied':
                    $queryBuilder->andWhere('ticket.isReplied = 0');
                    break;
                case 'mine':
                    $queryBuilder->andWhere('agent = :agentId')->setParameter('agentId', $fieldValue);
                    break;
                case 'new':
                    $queryBuilder->andwhere('ticket.isNew = 1');
                    break;
                case 'priority':
                    $queryBuilder->andwhere('priority.id = :priority')->setParameter('priority', $fieldValue);
                    break;
                case 'type':
                    $queryBuilder->andwhere('type.id IN (:typeCollection)')->setParameter('typeCollection', explode(',', $fieldValue));
                    break;
                case 'agent':
                    $queryBuilder->andwhere('agent.id IN (:agentCollection)')->setParameter('agentCollection', explode(',', $fieldValue));
                    break;
                case 'customer':
                    $queryBuilder->andwhere('customer.id IN (:customerCollection)')->setParameter('customerCollection', explode(',', $fieldValue));
                    break;
                case 'group':
                    $queryBuilder->andwhere('supportGroup.id IN (:groupIds)');
                    $queryBuilder->setParameter('groupIds', explode(',', $fieldValue));
                    break;
                case 'team':
                    $queryBuilder->andwhere("supportTeam.id In(:subGrpKeys)");
                    $queryBuilder->setParameter('subGrpKeys', explode(',', $fieldValue));
                    break;
                case 'tag':
                    $queryBuilder->andwhere("supportTags.id In(:tagIds)");
                    $queryBuilder->setParameter('tagIds', explode(',', $fieldValue));
                    break;
                case 'source':
                    $queryBuilder->andwhere('ticket.source IN (:sources)');
                    $queryBuilder->setParameter('sources', explode(',', $fieldValue));
                    break;
                case 'after':
                    $date = \DateTime::createFromFormat('d-m-Y H:i', $fieldValue.' 23:59');
                    if ($date) {
                        // $date = \DateTime::createFromFormat('d-m-Y H:i', $this->userService->convertTimezoneToServer($date, 'd-m-Y H:i'));
                        $queryBuilder->andwhere('ticket.createdAt > :afterDate');
                        $queryBuilder->setParameter('afterDate', $date);
                    }
                    break;
                case 'before':
                    $date = \DateTime::createFromFormat('d-m-Y H:i', $fieldValue.' 00:00');
                    if ($date) {
                        //$date = \DateTime::createFromFormat('d-m-Y H:i', $container->get('user.service')->convertTimezoneToServer($date, 'd-m-Y H:i'));
                        $queryBuilder->andwhere('ticket.createdAt < :beforeDate');
                        $queryBuilder->setParameter('beforeDate', $date);
                    }
                    break;
                case 'repliesLess':
                    $queryBuilder->andWhere('threads.threadType = :threadType')->setParameter('threadType', 'reply')
                        ->groupBy('ticket.id')
                        ->andHaving('count(threads.id) < :threadValueLesser')->setParameter('threadValueLesser', intval($params['repliesLess']));
                    break;
                case 'repliesMore':
                    $queryBuilder->andWhere('threads.threadType = :threadType')->setParameter('threadType', 'reply')
                        ->groupBy('ticket.id')
                        ->andHaving('count(threads.id) > :threadValueGreater')->setParameter('threadValueGreater', intval($params['repliesMore']));
                    break;
                case 'mailbox':
                    $queryBuilder->andwhere('ticket.mailboxEmail IN (:mailboxEmails)');
                    $queryBuilder->setParameter('mailboxEmails', explode(',', $fieldValue));
                    break;
                default:
                    break;
            }
        }

        return $queryBuilder;
    }

    public function addPermissionFilter($qb, User $user, array $supportGroupReferences = [], array $supportTeamReferences = [])
    {
        $userInstance = $user->getAgentInstance();

        if (!empty($userInstance) && ('ROLE_AGENT' == $userInstance->getSupportRole()->getCode() && $userInstance->getTicketAccesslevel() != self::TICKET_GLOBAL_ACCESS)) {
            $qualifiedGroups = empty($this->params['group']) ? $supportGroupReferences : array_intersect($supportGroupReferences, explode(',', $this->params['group']));
            $qualifiedTeams = empty($this->params['team']) ? $supportTeamReferences : array_intersect($supportTeamReferences, explode(',', $this->params['team']));

            switch ($userInstance->getTicketAccesslevel()) {
                case self::TICKET_GROUP_ACCESS:
                    $qb
                        ->andWhere("ticket.agent = :agentId OR supportGroup.id IN(:supportGroupIds) OR supportTeam.id IN(:supportTeamIds)")
                        ->setParameter('agentId', $user->getId())
                        ->setParameter('supportGroupIds', $qualifiedGroups)
                        ->setParameter('supportTeamIds', $qualifiedTeams);
                    break;
                case self::TICKET_TEAM_ACCESS:
                    $qb
                        ->andWhere("ticket.agent = :agentId OR supportTeam.id IN(:supportTeamIds)")
                        ->setParameter('agentId', $user->getId())
                        ->setParameter('supportTeamIds', $qualifiedTeams);
                    break;
                default:
                    $qb
                        ->andWhere("ticket.agent = :agentId")
                        ->setParameter('agentId', $user->getId());
                    break;
            }
        }

        return $qb;
    }


    //    /**
//     * @return TicketLocation[] Returns an array of TicketLocation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TicketLocation
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
