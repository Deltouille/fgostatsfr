<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Servant;
use App\Entity\ServantInfo;
use App\Entity\CraftEssence;
use App\Entity\CraftEssenceInfo;

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
     * @Route("/modification-rapide-servant/{id}/{modName}/{value}", name="modificationRapideServant")
     */
    public function modificationRapideServant(int $id, string $modName, int $value): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $servant = $servantInfoRepository->find($id);

        switch($modName){
            case 'skill1':
                $servant->setNiveauSkill1($value);
                $em->persist($servant);
                $em->flush();
                return 'oui';
                break;
            case 'skill2':
                $servant->setNiveauSkill2($value);
                $em->persist($servant);
                $em->flush();
                return 'oui';
                break;
            case 'skill3':
                $servant->setNiveauSkill3($value);
                $em->persist($servant);
                $em->flush();
                return 'oui';
                break;
            case 'bond':
                $servant->setNiveauBond($value);
                $em->persist($servant);
                $em->flush();
                return 'oui';
                break;
            case 'nplevel':
                $servant->setNiveauNP($value);
                $em->persist($servant);
                $em->flush();
                return 'oui';
                break;
        }
    }   
}
