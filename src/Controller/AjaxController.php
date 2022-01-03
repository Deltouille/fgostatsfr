<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Servant;
use App\Entity\ServantInfo;
use App\Entity\CraftEssence;
use App\Entity\CraftEssenceInfo;
use App\Entity\Material;
use App\Entity\MaterialInfo;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index(): Response
    {
        return $this->render('ajax/index.html.twig', [
            'controller_name' => 'AjaxController',
        ]);
    }

    /**
     * @Route("/getServantMaterials", name="getServantMaterials")
     */
    public function getServantMaterials(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->all();
        $skillLvl = intval($data['skillLvl']);
        $servantId = intval($data['servantId']);
        $servantRepository = $em->getRepository(Servant::class);
        $materialRepository = $em->getRepository(MaterialInfo::class);
        $servant = $servantRepository->find($servantId);
        $materialServant = $materialRepository->findBy(['servant' => $servant], ['skillLvl' => "ASC"], $skillLvl - 1, null);
        $listeMaterialSkill = array();
        foreach($materialServant as $material){
            $currentMaterial = [
                'quantity' => $material->getQuantity() / 3,
                'idMaterial' => $material->getMaterial()->getId(),
            ];
            array_push($listeMaterialSkill, $currentMaterial);
        }
        return new JsonResponse($listeMaterialSkill);
    }

    /**
     * @Route("/getServantInfo", name="getServantInfo")
     */
    public function getServantInfo(Request $request){
        $data = $request->request->all();
        $id = intval($data['id']);
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $servant = $servantRepository->find($id);
        $serializedEntity = $this->container->get('serializer')->serialize($servant, 'json');
        return new response($serializedEntity);
        
    }

    /**
     * @Route("/ajout-servant/{id}", name="ajout-rapide-servant")
     */
    public function ajoutRapideServantCollectionUser(int $id){
        $em = $this->getDoctrine()->getManager();
        //On récupère le servant correspondant la l'id dans la table Servant
        $servantRepository = $em->getRepository(Servant::class);
        $getServantOfId = $servantRepository->find($id);
        //On récupère le servant correspondant a l'id du servant ET a l'id de l'utilisateur dans la table ServantInfo
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $servantInfo = $servantInfoRepository->findByServandIdAndUser($getServantOfId, $this->getUser());
        //Si le servant existe dans la base de données, il est supprimé, SINON il est ajouté
        if(empty($servantInfo)){
            $addServantInfo = new ServantInfo();
            $addServantInfo->setNiveauServant(1);
            $addServantInfo->setNiveauSkill1(1);
            $addServantInfo->setNiveauSkill2(1);
            $addServantInfo->setNiveauSkill3(1);
            $addServantInfo->setNiveauBond(1);
            $addServantInfo->setNiveauNP(1);
            $addServantInfo->setServant($getServantOfId);
            $addServantInfo->setUser($this->getUser());
            $em->persist($addServantInfo);
            $em->flush();
            
            return new Response('ajouté');

        }else{
            $em->remove($servantInfo[0]);
            $em->flush();

            return new Response('supprimé');
        }
    }

    /**
     * @Route("/ajout-craft-essence/{id}", name="ajout-rapide-craftessence")
     */
    public function ajoutRapideCraftEssenceCollectionUser(int $id){
        $em = $this->getDoctrine()->getManager();
        $craftEssenceRepository = $em->getRepository(CraftEssence::class);
        $getCraftEssenceOfId = $craftEssenceRepository->find($id);

        $craftEssenceInfoRepository = $em->getRepository(CraftEssenceInfo::class);
        $craftEssenceInfo = $craftEssenceInfoRepository->findByCeIdAndUser($getCraftEssenceOfId, $this->getUser());

        if(empty($craftEssenceInfo)){
            $addCraftEssenceInfo = new CraftEssenceInfo();
            $addCraftEssenceInfo->setNiveauCE(1);
            $addCraftEssenceInfo->setIsMaxLimitBreak(false);
            $addCraftEssenceInfo->setCraftEssence($getCraftEssenceOfId);
            $addCraftEssenceInfo->setUser($this->getUser());
            $em->persist($addCraftEssenceInfo);
            $em->flush();
            
            return new Response('ajouté');
        }else{
            $em->remove($craftEssenceInfo[0]);
            $em->flush();

            return new Response('supprimé');
        }
    }

    /**
     * @Route("/modification-rapide-ce", name="modificationRapideCE")
     */
    public function modificationRapideCraftEssence(Request $request): Response
    {
        $data = $request->request->all();
        $id = intval($data['id']);
        $name = $data['name'];

        $em = $this->getDoctrine()->getManager();
        $craftEssenceInfoRepository = $em->getRepository(CraftEssenceInfo::class);
        $craftEssence = $craftEssenceInfoRepository->findByCeIdAndUser($id, $this->getUser());
        
        switch($name){
            case 'niveauCe':
                $craftEssence[0]->setNiveauCE(intval($data['value']));
                $em->persist($craftEssence[0]);
                $em->flush();
                break;
            case 'isMLB':
                $craftEssence[0]->setIsMaxLimitBreak($data['value']);
                $em->persist($craftEssence[0]);
                $em->flush();
                break;
        }
        return new Response('update');
    }

    /**
     * @Route("/modification-rapide-servant", name="modificationRapideServant")
     */
    public function modificationRapideServant(Request $request): Response
    {
        $data = $request->request->all();
        $id = intval($data['id']);
        $name = $data['name'];
        $value = intval($data['value']);
        $em = $this->getDoctrine()->getManager();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $servant = $servantInfoRepository->findByServandIdAndUser($id, $this->getUser());
        switch($name){
            case 'skill1':
                $servant[0]->setNiveauSkill1($value);
                $em->persist($servant[0]);
                $em->flush();
                break;
            case 'skill2':
                $servant[0]->setNiveauSkill2($value);
                $em->persist($servant[0]);
                $em->flush();
                break;
            case 'skill3':
                $servant[0]->setNiveauSkill3($value);
                $em->persist($servant[0]);
                $em->flush();
                break;
            case 'bond':
                $servant[0]->setNiveauBond($value);
                $em->persist($servant[0]);
                $em->flush();
                break;
            case 'nplevel':
                $servant[0]->setNiveauNP($value);
                $em->persist($servant[0]);
                $em->flush();
                break;
            case 'nplevel':
                $servant[0]->setNiveauNP($value);
                $em->persist($servant[0]);
                $em->flush();
                break;
        }

        return new Response('update');
    }   
}
