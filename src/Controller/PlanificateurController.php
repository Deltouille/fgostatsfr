<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Material;
use App\Entity\Servant;
use App\Entity\ServantInfo;
use App\Entity\UserMaterialInfo;

class PlanificateurController extends AbstractController
{

    public function load(){
        $em = $this->getDoctrine()->getManager();
        $materialRepository = $em->getRepository(Material::class);
        $listeMaterial = $materialRepository->findBy(['MatertialType' => 'skillLvUp']);

        foreach($listeMaterial as $currentMaterial){
            $userMaterial = new UserMaterialInfo();
            $userMaterial->setUser($this->getUser());
            $userMaterial->setMaterial($currentMaterial);
            $userMaterial->setUserQuantity(0);
            $em->persist($userMaterial);
            $em->flush();
        }

        return new Response('oui');
    }

    /**
     * @Route("/planificateur-2", name="planificateur2")
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
     * @Route("/planificateur", name="planificateur")
     */
    public function inde2(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $materialRepository = $em->getRepository(Material::class);
        $userMaterialRepository = $em->getRepository(UserMaterialInfo::class);
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $listeInfoServant = $servantInfoRepository->findBy(['user' => $this->getUser()]);
        $listeMaterialInfo = $servantInfoRepository->findAll();

        $listeServant = $servantRepository->findAll();
        $listeMaterial = $materialRepository->findBy(['MatertialType' => 'skillLvUp']);
        $listeUserMaterial = $userMaterialRepository->findBy(['user' => $this->getUser()]);
        return $this->render('planificateur/index.html.twig', [
            'listeServant' => $listeServant,
            'listeMaterial' => $listeMaterial,
            'listeUserMaterial' => $listeUserMaterial,
            'listeInfoServant' => $listeInfoServant
        ]);
    }

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
