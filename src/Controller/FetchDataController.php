<?php

namespace App\Controller;

use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FetchDataController extends AbstractController
{
    /**
     * @Route("/leslocations", name="les_subdivisions", methods={"POST"})
     */
    public function lesSubDivisions(Request $request, EntityManagerInterface $em) {
        $typeLocation = $request->request->get('typeLocation');
        $parent = $request->request->get('parent');
        //$enfant_souhaite = null; //$request->request->get('subdivision);

		$qb = $em->getRepository(Location::class)->createQueryBuilder('l')
            //->innerJoin('l.typeLocation', 'tl')
            ->andWhere('l.parent = :parent')
            //->andWhere('tl.libelle = :typeLocation')
            ->orderBy('l.libelle', 'ASC')
            //->setParameters(['typeLocation' => $typeLocation, 'parent' => $parent]);
            ->setParameter('parent', $parent);
        $subDivisions = $qb->getQuery()->getResult();
        $subdivtype = $typeLocation == 'region' ? 'departement' : 'commune';
		$html = "<option> Select ".$subdivtype."</option>";

        foreach($subDivisions as $subDivision){
            //if($subDivision->getId()!=$enfant_souhaite) {
                $html .= "<option value='".$subDivision->getId()."'>".$subDivision->getLibelle()."</option>";
            /*} else {
                $html .= "<option value='".$subDivision->getId()."' selected>".$subDivision->getLibelle()."</option>";
            }*/
		}

		return new Response($html);
    }

    /**
     * @Route("/leslocationsdetype", name="les_locationsdetype", methods={"POST"})
     */
    public function lesDivisions(Request $request, EntityManagerInterface $em) {
        $typeLocation = $request->request->get('typeLocation');
        //$enfant_souhaite = null; //$request->request->get('subdivision);

		$qb = $em->getRepository(Location::class)->createQueryBuilder('l')
            //->innerJoin('l.typeLocation', 'tl')
            ->andWhere('l.typeLocation = :typeLocation')
            ->orderBy('l.libelle', 'ASC')
            //->setParameters(['typeLocation' => $typeLocation, 'parent' => $parent]);
            ->setParameter('typeLocation', $typeLocation);
        $divisions = $qb->getQuery()->getResult();
		$html = "<option> Select the zone of responsability</option>";

        foreach($divisions as $division){
            //if($subDivision->getId()!=$enfant_souhaite) {
            $html .= "<option value='".$division->getId()."'>".$division->getLibelle()."</option>";
            /*} else {
            $html .= "<option value='".$subDivision->getId()."' selected>".$subDivision->getLibelle()."</option>";
            }*/
		}

		return new Response($html);
    }
}