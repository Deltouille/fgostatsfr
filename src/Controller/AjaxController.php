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
     * @Route("ajout-servant/{id}", name="ajout-rapide-servant")
     */
    public function ajoutRapideServantCollectionUser(int $id){
        $em = $this->getDoctrine()->getManager();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        //On récupère le servant correspondant la l'id dans la table Servant
        $getServantOfId = $servantInfoRepository->find($id);
        $servantRepository = $em->getRepository(Servant::class);
        //On récupère le servant correspondant a l'id du servant ET a l'id de l'utilisateur dans la table ServantInfo
        $servant = $servantInfoRepository->findBy(['user' => $this->getUser(), 'id' => $id]);
        //Si le servant existe dans la base de données, il est supprimé, SINON il est ajouté
        if($servant !== null){
            $em->remove($servant);
            $em->flush();

            return new Response('Servant supprimé de la collection');
        }else{
            $servant = new ServantInfo();
            $servant->setNiveauServant(1);
            $servant->setNiveauSkill1(1);
            $servant->setNiveauSkill2(1);
            $servant->setNiveauSkill3(1);
            $servant->setNiveauBond(1);
            $servant->setNiveauNP(1);
            $servant->setServant($getServantOfId);
            $servant->setUser($this->getUser());
            $em->persist($servant);
            $em->flush();
            
            return new Response('Servant ajouté a la collection');
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
