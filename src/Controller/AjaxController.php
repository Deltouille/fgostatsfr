<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Servant;
use App\Entity\ServantInfo;

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
        $servant = $servantInfoRepository->findByServandIdAndUser($getServantOfId, $this->getUser());
        //Si le servant existe dans la base de données, il est supprimé, SINON il est ajouté

        if(!empty($servant)){
            $em->remove($servant);
            $em->flush();

            return new Response('supprimé');
        }else{
            $addServant = new ServantInfo();
            $addServant->setNiveauServant(1);
            $addServant->setNiveauSkill1(1);
            $addServant->setNiveauSkill2(1);
            $addServant->setNiveauSkill3(1);
            $addServant->setNiveauBond(1);
            $addServant->setNiveauNP(1);
            $addServant->setServant($getServantOfId);
            $addServant->setUser($this->getUser());
            $em->persist($addServant);
            $em->flush();
            
            return new Response('ajouté');
        }
        
        
        
        //$obtainedServant = $servantRepository->find($id);
        //if($obtainedServant->getIsObtained() == false){
        //    $obtainedServant->setIsObtained(true);
        //    $em->persist($obtainedServant);
        //    $em->flush();
        //    return new Response('oui');
        //}else{
        //    $obtainedServant->setIsObtained(false);
        //    $em->persist($obtainedServant);
        //    $em->flush();
        //    return new Response('non');
        //}
    }
}
