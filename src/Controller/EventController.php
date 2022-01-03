<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AtlasAcademyAPI;
use App\Entity\Event;
use App\Entity\MaterialEvent;
use App\Entity\QuartzEvent;
use App\Entity\Material;

class EventController extends AbstractController
{
    /**
     * @Route("/planificateur-ressources", name="planificateurRessources")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $eventRepository = $em->getRepository(Event::class);
        $listeEvent = $eventRepository->findBy(['eventType' => 'eventQuest']);
        
        return $this->render('event/index.html.twig');
    }

    /**
     * @Route("/insertEventDatabase", name="insertEventDatabase")
     */
    public function insertEventDatabase(AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $listeEventAPI = $atlasAcademyAPI->getResultAPI('Event');
        $em = $this->getDoctrine()->getManager();
        $materialRepository = $em->getRepository(Material::class);
        foreach($listeEventAPI as $currentEvent)
        {
            $event = new Event();
            $event->setEventId($currentEvent['id']);
            $event->setEventType($currentEvent['type']);
            $event->setEventName($currentEvent['name']);
            $event->setEventStart($currentEvent['startedAt']);
            $event->setEventEnd($currentEvent['endedAt']);
            $em->persist($event);
            $em->flush();
            if(!empty($currentEvent['shop']) && $currentEvent['type'] == "eventQuest"){
                foreach($currentEvent['shop'] as $currentShopMaterial){
                    $material = new MaterialEvent();
                    $materialName = $materialRepository->findBy(['MaterialName' => $currentShopMaterial['name']]);
                    if(empty($materialName)){
                        $material->setMaterialId(null);
                    }else{
                        $material->setMaterialId($materialName[0]);
                    }
                    $material->setQuantity($currentShopMaterial['limitNum']);
                    $material->setEvent($event);
                    $em->persist($material);
                    $em->flush();
                }
            }
            if(!empty($currentEvent['rewards']) && $currentEvent['type'] == "eventQuest"){
                foreach($currentEvent['rewards'] as $currentRewardsMaterial){
                    foreach($currentRewardsMaterial['gifts'] as $currentGift){
                        if($currentGift['objectId'] == 2){
                            $quartz = new QuartzEvent();
                            $quartz->setQuartzQuantity($currentGift['num']);
                            $quartz->setEvent($event);
                            $em->persist($quartz);
                            $em->flush();
                        }
                    }
                }
            }
            if(!empty($currentEvent['missions']) && $currentEvent['type'] == "eventQuest"){
                foreach($currentEvent['missions'] as $currentMissionMaterial){
                    foreach($currentMissionMaterial['gifts'] as $currentGift){
                        if($currentGift['objectId'] == 2){
                            $quartz = new QuartzEvent();
                            $quartz->setQuartzQuantity($currentGift['num']);
                            $quartz->setEvent($event);
                            $em->persist($quartz);
                            $em->flush();
                        }
                    }
                }
            }
            if(!empty($currentEvent['warIds'] && $currentEvent['type'] == "eventQuest")){
                $warAPI = $atlasAcademyAPI->getWarAPI($currentEvent['warIds'][0]);
                if(!empty($warAPI['spots'])){
                    foreach($warAPI['spots'] as $currentSpot){
                        if(!empty($currentSpot['quest'])){
                            foreach($currentSpot['quest'] as $currentQuest){
                                if(!empty($currentQuest['gifts'])){
                                    foreach($currentQuest['gifts'] as $currentGift){
                                        if($currentGift['objectId'] == 2){
                                            $quartz = new QuartzEvent();
                                            $quartz->setQuartzQuantity($currentGift['num']);
                                            $quartz->setEvent($event);
                                            $em->persist($quartz);
                                            $em->flush();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return new Response('Event et MaterialEvent enregistrées');
    }

    /**
     * @Route("/checkapi", name="checkapi")
     */
    public function checkapi(AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $listeEventAPI = $atlasAcademyAPI->getResultAPI('Event');
        $em = $this->getDoctrine()->getManager();
        $materialRepository = $em->getRepository(Material::class);
        foreach($listeEventAPI as $currentEvent){
            if($currentEvent['type'] == 'eventQuest'){
                if(!empty($currentEvent['warIds'] && $currentEvent['type'] == "eventQuest")){
                    $warAPI = $atlasAcademyAPI->getWarAPI($currentEvent['warIds'][0]);
                    if(!empty($warAPI['spots'])){
                        foreach($warAPI['spots'] as $currentSpot){
                            if(!empty($currentSpot['quest'])){
                                foreach($currentSpot['quest'] as $currentQuest){
                                    if(!empty($currentQuest['gifts'])){
                                        foreach($currentQuest['gifts'] as $currentGift){
                                            if($currentGift['objectId'] == 2){
                                                var_dump('oui');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return new Response('Event et MaterialEvent enregistrées');
    }
}
