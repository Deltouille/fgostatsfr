<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Entity\UserInfo;
use App\Entity\CraftEssence;
use App\Entity\ServantInfo;
use App\Entity\CraftEssenceInfo;
use App\Entity\Invocation;

use App\Form\UserInfoType;
use App\Form\ServantInfoType;

use App\Service\StatistiqueManager;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil_utilisateur")
     */
    public function index(ChartBuilderInterface $chartBuilder, StatistiqueManager $statistiqueManager): Response
    {
        $em = $this->getDoctrine()->getManager();

        $userInfoRepository = $em->getRepository(UserInfo::class);
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $craftEssenceInfoRepository = $em->getRepository(CraftEssenceInfo::class);
        $invocationRepository = $em->getRepository(Invocation::class);

        $infoUtilisateur = $userInfoRepository->findBy(['user' => $this->getUser()]);
        $infoServant = $servantInfoRepository->findBy(['user' => $this->getUser()]);
        $infoCraftEssence = $craftEssenceInfoRepository->findBy(['user' => $this->getUser()]);
        $infoInvocation = $invocationRepository->findBy(['user' => $this->getUser()]);

        $servantCharts = array();
        $craftEssenceCharts = array();
        
        $result = $statistiqueManager->countInfo($infoServant);
        $resultCraftEssence = $statistiqueManager->countInfoCraftEssence($infoCraftEssence);
        $resultInvocation = $statistiqueManager->countInfoInvocation($infoInvocation);
        foreach($result as $info){
            $randomColors = $statistiqueManager->generateHexColor($info);
            $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
            $chart->setData([
                'labels' => array_keys($info),
                'datasets' => [
                    [
                        'label' => 'oui',
                        'backgroundColor' => [$randomColors],
                        'borderColor' => 'rgb(0, 0, 0)',
                        'data' => array_values($info),
                    ],
                ],
            ]);

            $chart->setOptions([/* ... */]);
            array_push($servantCharts, $chart);
        }

        foreach($resultCraftEssence as $info){
            $randomColors = $statistiqueManager->generateHexColor($info);
            $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
            $chart->setData([
                'labels' => array_keys($info),
                'datasets' => [
                    [
                        'label' => 'oui',
                        'backgroundColor' => [$randomColors],
                        'borderColor' => 'rgb(0, 0, 0)',
                        'data' => array_values($info),
                    ],
                ],
            ]);

            $chart->setOptions([/* ... */]);
            array_push($craftEssenceCharts, $chart);
        }

        $chartInvocation = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chartInvocation->setData([
            'labels' => $resultInvocation['dates'],
            'datasets' => [
                [
                    'type' => 'line',
                    'lineTension' => 0,
                    'label' => 'nombre de saint quartz',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $resultInvocation['nombreSaintQuartz'],
                    'order' => '2',
                ],
                [
                    'type' => 'bar',
                    'label' => 'Servants 5',
                    'backgroundColor' => 'yellow',
                    'data' => $resultInvocation['nombreServant5'],
                    'order' => '1',
                ],
                [
                    'type' => 'bar',
                    'label' => 'Servants 4',
                    'backgroundColor' => 'green',
                    'data' => $resultInvocation['nombreServant4'],
                ],
                [
                    'type' => 'bar',
                    'label' => 'Craft Essence 5',
                    'backgroundColor' => 'blue',
                    'data' => $resultInvocation['nombreCE5'],
                ],
            ],
        ]);
        $chartInvocation->setOptions(['chartInvocation']);

        return $this->render('user/index.html.twig', ['infoUtilisateur' => $infoUtilisateur, 'servantCharts' => $servantCharts, 'craftEssenceCharts' => $craftEssenceCharts, 'chartInvocation' => $chartInvocation, 'listeServant' => $infoServant, 'listeCraftEssence' => $infoCraftEssence]);
    }

    /**
     * @Route("/ajouter-information", name="ajoutInfo")
     */
    public function addInfo(Request $request): Response
    {
        $infoUtilisateur = new UserInfo();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UserInfoType::class, $infoUtilisateur);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()){
                $user = $this->getUser();
                $infoUtilisateur->setUser($user);
                $em->persist($infoUtilisateur);
                $em->flush();
                return $this->redirectToRoute('profil_utilisateur');
            }
        }
        return $this->render('user/ajoutInfo.html.twig', ['infoUtilisateur' => $infoUtilisateur, 'form' => $form->createView()]);
    }

    /**
     * @Route("/modification-rapide-des-servants", name="modification-rapide-servant")
     */
    public function modificationServant(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $listeServantUser = $servantInfoRepository->findBy(['user' => $this->getUser()]);

        return $this->render('user/modificationRapideServant.html.twig', ['listeServantUser' => $listeServantUser]);
    }

    /**
     * @Route("/modification-rapide-des-craft-essences", name="modification-rapide-craft-essence")
     */
    public function modificationCraftEssence(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $craftEssenceRepository = $em->getRepository(CraftEssenceInfo::class);
        $listeCraftEssenceUser = $craftEssenceRepository->findBy(['user' => $this->getUser()]);

        return $this->render('user/modificationRapideCraftEssence.html.twig', ['listeCraftEssenceUser' => $listeCraftEssenceUser]);
    }

    /**
     * @Route("/ajouter-un-servant-a-la-collection", name="ajout-servant")
     */
    public function addServant(Request $request): Response
    {
        $infoServant = new ServantInfo();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ServantInfoType::class, $infoServant);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted()){
                $user = $this->getUser();
                $infoServant->setUser($user);
                $em->persist($infoServant);
                $em->flush();
                return $this->redirectToRoute('profil_utilisateur');
            }
        }
        return $this->render('user/ajoutServant.html.twig', ['infoServant' => $infoServant, 'form' => $form->createView()]);
    }

    /**
     * @Route("/ma-collection-de-servants", name="servantCollection")
     */
    public function userServantCollection(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $listeServantCollection = $servantInfoRepository->findBy(['user' => $this->getUser()]);
        
        return $this->render('user/collectionServant.html.twig', ['listeServantCollection' => $listeServantCollection]);
    }

    /**
     * @Route("/ma-collection-de-craft-essence", name="craftEssenceCollection")
     */
    public function userCraftEssenceCollection(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $craftEssenceInfoRepository = $em->getRepository(CraftEssenceInfo::class);
        $listeCraftEssenceCollection = $craftEssenceInfoRepository->findBy(['user' => $this->getUser()]);
        
        return $this->render('user/collectionCraftEssence.html.twig', ['listeCraftEssenceCollection' => $listeCraftEssenceCollection]);
    }
}
