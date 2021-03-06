<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Servant;
use App\Entity\ServantInfo;
use App\Service\AtlasAcademyAPI;
class ServantController extends AbstractController
{
    /**
     * @Route("/fate", name="fate")
     */
    public function index(): Response
    {
        return $this->render('fate/index.html.twig', [
            'controller_name' => 'FateController',
        ]);
    }

    /**
     * @Route("/liste-servant", name="liste-servant")
     */
    public function listeServant(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $listeServantBDD = $servantRepository->findAll();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $listeServant = array();
        foreach($listeServantBDD as $currentServant){
            if($servantInfoRepository->findByServandIdAndUser($currentServant, $this->getUser())){
                $servant = [
                    'id' => $currentServant->getId(),
                    'servantName' => $currentServant->getServantName(),
                    'classe' => $currentServant->getClasse(),
                    'rarity' => $currentServant->getRarity(),
                    'servantInfo' => $currentServant->getServantInfo(),
                    'charaGraph' => $currentServant->getCharaGraph(),
                    'face' => $currentServant->getFace(),
                    'obtenus' => true,
                ];
                array_push($listeServant, $servant);
            }else{
                $servant = [
                    'id' => $currentServant->getId(),
                    'servantName' => $currentServant->getServantName(),
                    'classe' => $currentServant->getClasse(),
                    'rarity' => $currentServant->getRarity(),
                    'servantInfo' => $currentServant->getServantInfo(),
                    'charaGraph' => $currentServant->getCharaGraph(),
                    'face' => $currentServant->getFace(),
                    'obtenus' => false,
                ];
                array_push($listeServant, $servant);
            }
        }
        return $this->render('fate/listeServant.html.twig', [
            'listeServant' => $listeServant,
        ]);
    }

    /**
     * @Route("/liste-servant-a-obtenir", name="liste-servant-non-obtenus")
     */
    public function listeServantNonObtenus(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $listeServantBDD = $servantRepository->findAll();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $listeServant = array();
        foreach($listeServantBDD as $currentServant){
            if(!$servantInfoRepository->findByServandIdAndUser($currentServant, $this->getUser())){
                $servant = [
                    'id' => $currentServant->getId(),
                    'servantName' => $currentServant->getServantName(),
                    'classe' => $currentServant->getClasse(),
                    'rarity' => $currentServant->getRarity(),
                    'servantInfo' => $currentServant->getServantInfo(),
                    'charaGraph' => $currentServant->getCharaGraph(),
                    'face' => $currentServant->getFace(),
                    'obtenus' => false,
                ];
                array_push($listeServant, $servant);
            }
        }
        return $this->render('fate/listeServant2.html.twig', [
            'listeServant' => $listeServant,
        ]);
    }

    /**
     * @Route("/details-servant/{id}", name="details-servant")
     */
    public function detailServant(int $id): Response
    {
        //$servantDetails = $this->getAtlasAcademyAPI($id);
        //return $this->render('fate/detailsServant.html.twig', ['servantDetails' => $servantDetails]);
    }


    /**
     * @Route("/insertServantInDatabase", name="insertServantInDatabase")
     */
    public function insertServantInDatabase(AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $listeServantAInserer = array();  
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $listeServantAPI = $atlasAcademyAPI->getResultAPI('Servant');
        
        foreach($listeServantAPI as $currentServant){
            $servant = [
                'id' => $currentServant['collectionNo'],
                'name' => $currentServant['name'],
                'className' => $currentServant['className'],
                'type' => $currentServant['type'],
                'flag' => $currentServant['flag'],
                'rarity' => $currentServant['rarity'],
                'charaGraph' => $currentServant['extraAssets']['charaGraph']['ascension'],
                'face' => $currentServant['extraAssets']['faces']['ascension'],
            ];
            array_push($listeServantAInserer, $servant);
        }

        usort($listeServantAInserer, function($firstId, $secondId){    
            return $firstId['id'] <=> $secondId['id'];              
        });   
        
        foreach($listeServantAInserer as $currentServant){
            $getServant = $servantRepository->find($currentServant['id']);
            if($getServant == null){
                foreach($currentServant['charaGraph'] as $graph){   //Oblig?? de faire de cette m??thode car $dataAsc = $currentServant['charaGraph'][4] retourne Error : Undefined Offset : 4 alors qu'il existe
                    $dataAsc = $graph;  
                }
                foreach($currentServant['face'] as $face){    //Pareil que le foreach au dessus, mais avec $dataIcn = $currentServant['face'][4]
                    $dataIcn = $face;  
                }
                $servant = new Servant();
                $servant->setServantName($currentServant['name']);
                $servant->setClasse($currentServant['className']);
                $servant->setRarity($currentServant['rarity']);
                $servant->setCharaGraph($dataAsc);
                //$servant = $servantRepository->find($currentServant['id']);
                $servant->setFace($dataIcn);
                $em->persist($servant);
                $em->flush();
            }
        }

        return new Response('Servants enregistr??es');
    }

}
