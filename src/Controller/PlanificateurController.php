<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Material;
use App\Entity\Servant;

class PlanificateurController extends AbstractController
{
    /**
     * @Route("/planificateur", name="planificateur")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $materialRepository = $em->getRepository(Material::class);
        $listeServant = $servantRepository->findAll();
        $listeMaterial = $materialRepository->findBy(['MatertialType' => 'skillLvUp']);
        $listeServantArray = array();
        $i = 1;
        foreach($listeServant as $servant){
            $currentServant = array('id' => $servant->getId(),'face' => $servant->getFace());
            foreach($servant->getMaterialInfos() as $servantMaterial){
                foreach($listeMaterial as $material){
                    if($servantMaterial->getMaterial()->getMaterialId() == $material->getMaterialId()){
                        $currentServant[$material->getMaterialName()] = $servantMaterial->getQuantity();
                    }else{
                        $currentServant[$material->getMaterialName()] = 0;
                    }
                } 
            }
        }
        return $this->render('planificateur/index.html.twig', [
            'listeServant' => $listeServant,
            'listeMaterial' => $listeMaterial,
        ]);
    }
}
