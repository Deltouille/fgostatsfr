<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CraftEssence;
use App\Entity\CraftEssenceInfo;
use App\Service\AtlasAcademyAPI;

class CraftEssenceController extends AbstractController
{
    /**
     * @Route("/craft-essence", name="craft_essence")
     */
    public function listeCraftEssence(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $craftEssenceRepository = $em->getRepository(CraftEssence::class);
        $listeCraftEssenceBDD = $craftEssenceRepository->findAll();
        $craftEssenceInfoRepository = $em->getRepository(CraftEssenceInfo::class);
        $listeCraftEssence = array();
        foreach($listeCraftEssenceBDD as $currentCraftEssence){
            if($craftEssenceInfoRepository->findByCeIdAndUser($currentCraftEssence, $this->getUser())){
                $craftEssence = [
                    'id' => $currentCraftEssence->getId(),
                    'ceName' => $currentCraftEssence->getCEName(),
                    'ceRarity' => $currentCraftEssence->getCERarity(),
                    'ceType' => $currentCraftEssence->getCEType(),
                    'ceInfos' => $currentCraftEssence->getCraftEssenceInfos(),
                    'ceUrl' => $currentCraftEssence->getUrlImage(),
                    'obtenus' => true,
                ];
                array_push($listeCraftEssence, $craftEssence);
            }else{
                $craftEssence = [
                    'id' => $currentCraftEssence->getId(),
                    'ceName' => $currentCraftEssence->getCEName(),
                    'ceRarity' => $currentCraftEssence->getCERarity(),
                    'ceType' => $currentCraftEssence->getCEType(),
                    'ceInfos' => $currentCraftEssence->getCraftEssenceInfos(),
                    'ceUrl' => $currentCraftEssence->getUrlImage(),
                    'obtenus' => false,
                ];
                array_push($listeCraftEssence, $craftEssence);
            }
        }
        return $this->render('craft_essence/listeCraftEssence.html.twig', [
            'listeCraftEssence' => $listeCraftEssence,
        ]);
    }

    /**
     * @Route("/craft-essence/by-rarity/{id}", name="craft-essence-by-rarity")
     */
    public function showCraftEssenceByRarity(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $craftEssenceRepository = $em->getRepository(CraftEssence::class);
        $listeCraftEssenceBDD = $craftEssenceRepository->findBy(['CERarity' => $id]);
        $craftEssenceInfoRepository = $em->getRepository(CraftEssenceInfo::class);
        $listeCraftEssence = array();
        foreach($listeCraftEssenceBDD as $currentCraftEssence){
            if($craftEssenceInfoRepository->findByCeIdAndUser($currentCraftEssence, $this->getUser())){
                $craftEssence = [
                    'id' => $currentCraftEssence->getId(),
                    'ceName' => $currentCraftEssence->getCEName(),
                    'ceRarity' => $currentCraftEssence->getCERarity(),
                    'ceType' => $currentCraftEssence->getCEType(),
                    'ceInfos' => $currentCraftEssence->getCraftEssenceInfos(),
                    'ceUrl' => $currentCraftEssence->getUrlImage(),
                    'obtenus' => true,
                ];
                array_push($listeCraftEssence, $craftEssence);
            }else{
                $craftEssence = [
                    'id' => $currentCraftEssence->getId(),
                    'ceName' => $currentCraftEssence->getCEName(),
                    'ceRarity' => $currentCraftEssence->getCERarity(),
                    'ceType' => $currentCraftEssence->getCEType(),
                    'ceInfos' => $currentCraftEssence->getCraftEssenceInfos(),
                    'ceUrl' => $currentCraftEssence->getUrlImage(),
                    'obtenus' => false,
                ];
                array_push($listeCraftEssence, $craftEssence);
            }
        }
        return $this->render('craft_essence/listeCraftEssence.html.twig', [
            'listeCraftEssence' => $listeCraftEssence,
        ]);
    }

    /**
     * @Route("/insertCraftEssenceInDatabase", name="insertCraftEssenceInDatabase")
     */
    public function insertCraftEssenceInDatabase(AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $listeCraftEssenceAInserer = array();  
        $em = $this->getDoctrine()->getManager();
        $craftEssenceRepository = $em->getRepository(CraftEssence::class);
        $listeCraftEssenceAPI = $atlasAcademyAPI->getResultAPI('CraftEssence');
        
        foreach($listeCraftEssenceAPI as $currentCraftEssence)    //On parcours la réponse de l'api.
        {
            //dd($currentCraftEssence);
            $craftEssence = [
                'id' => $currentCraftEssence['collectionNo'], 
                'name' => $currentCraftEssence['name'], 
                'rarity' => $currentCraftEssence['rarity'],
                'type' => $currentCraftEssence['flag'],
                'url' => $currentCraftEssence['extraAssets']['charaGraph']['equip'][$currentCraftEssence['id']],
                'icon' => $currentCraftEssence['extraAssets']['faces']['equip'][$currentCraftEssence['id']] 
            ];
            array_push($listeCraftEssenceAInserer, $craftEssence);  
        }
        usort($listeCraftEssenceAInserer, function($firstId, $secondId){    
            return $firstId['id'] <=> $secondId['id'];              
        });                                                         

        foreach($listeCraftEssenceAInserer as $currentCraftEssence){
            //$CE = new CraftEssence();
            //$CE->setCEName($currentCraftEssence['name']);
            //$CE->setCERarity($currentCraftEssence['rarity']);
            //$CE->setCEType($currentCraftEssence['type']);
            //$CE->setUrlImage($currentCraftEssence['url']);
            $CE = $craftEssenceRepository->find($currentCraftEssence['id']);
            $CE->setCEIcon($currentCraftEssence['icon']);
            $em->persist($CE);
            $em->flush();
        }

        return new Response('Craft Essences enregistrées');
    }
}
