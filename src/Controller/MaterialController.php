<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Material;
use App\Entity\Servant;
use App\Entity\MaterialInfo;
use App\Service\AtlasAcademyAPI;

class MaterialController extends AbstractController
{
    /**
     * @Route("/material", name="material")
     */
    public function index(): Response
    {
        return $this->render('material/index.html.twig', [
            'controller_name' => 'MaterialController',
        ]);
    }

    /**
     * @Route("/insertMaterialInDatabase", name="insertMaterialInDatabase")
     */
    public function insertMaterialInDatabase(AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $listeMaterial = array();
        $listeMaterialAPI = $atlasAcademyAPI->getResultAPI('Material');
        $em = $this->getDoctrine()->getManager();
        $materialAPI = $em->getRepository(Material::class);
        foreach($listeMaterialAPI as $material){
            $materialArray = [
                'id' => $material['id'],
                'name' => $material['name'],
                'type' => $material['type'],
                'icon' => $material['icon'],
            ];

            
            array_push($listeMaterial, $materialArray); 
        }
        usort($listeMaterial, function($firstId, $secondId){    
            return $firstId['id'] <=> $secondId['id'];              
        });
        
        foreach($listeMaterial as $material){
            $insertMaterial = new Material();
            $insertMaterial->setMaterialId($material['id']);
            $insertMaterial->setMaterialName($material['name']);
            $insertMaterial->setMatertialType($material['type']);
            $insertMaterial->setMaterialIcon($material['icon']);
            $em->persist($insertMaterial);
            $em->flush();
        }

        return new Response('Matériaux enregistrées');
    }

    /**
     * @Route("/insertMaterialInfoInDatabase", name="insertMaterialInDatabase")
     */
    public function insertMaterialInfoInDatabase(AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $listeServantAPI = $atlasAcademyAPI->getResultAPI('Servant');
        $em = $this->getDoctrine()->getManager();
        $materialInfo = $em->getRepository(MaterialInfo::class);
        $servantdb = $em->getRepository(Servant::class);
        $materialdb = $em->getRepository(Material::class);
        
        foreach($listeServantAPI as $servant){
            $id = $servant['collectionNo'];
            foreach($servant['skillMaterials'] as $skillMaterials){
                foreach($skillMaterials['items'] as $item){
                    $materialEntity = $materialdb->findBy(['MaterialId' => $item['item']['id']]);
                    $material = new MaterialInfo();
                    $material->setQuantity($item['amount']*3);
                    $material->setMaterial($materialEntity[0]);
                    $material->setServant($servantdb->find($id));
                    $em->persist($material);
                    $em->flush();
                }
            }
        }

        return new Response('MaterialInfo enregistrées');
    }
}
