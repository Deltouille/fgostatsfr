<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Servant;
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
     * @Route("toggleIsObtained/{id}", name="toggleIsObtained")
     */
    public function toggleObtainedServant(int $id){
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $obtainedServant = $servantRepository->find($id);
        if($obtainedServant->getIsObtained() == false){
            $obtainedServant->setIsObtained(true);
            $em->persist($obtainedServant);
            $em->flush();
            return new Response('oui');
        }else{
            $obtainedServant->setIsObtained(false);
            $em->persist($obtainedServant);
            $em->flush();
            return new Response('non');
        }
    }
}
