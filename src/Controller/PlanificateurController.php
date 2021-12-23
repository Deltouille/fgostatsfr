<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Material;
use App\Entity\Servant;
use App\Entity\ServantInfo;

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

    /**
     * @Route("/planificateur-servant", name="planificateur-servant")
     */
    public function planificateur() : Response
    {
        $em = $this->getDoctrine()->getManager();
        
        $servantRepository = $em->getRepository(Servant::class);
        $materialRepository = $em->getRepository(Material::class);
        $servantInfoRepository = $em->getRepository(ServantInfo::class);

        $listeServant = $servantRepository->findAll();
        $listeMaterial = $materialRepository->findBy(['MatertialType' => 'skillLvUp']);
        $listeInfoServant = $servantInfoRepository->findBy(['user' => $this->getUser()]);
        return $this->render('planificateur/planificateur.html.twig', [
            'listeServant' => $listeServant,
            'listeMaterial' => $listeMaterial,
            'listeInfoServant' => $listeInfoServant
        ]);
    }
}
