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
        $infoUtilisateur = $userInfoRepository->findBy(['user' => $this->getUser()]);
        $infoServant = $servantInfoRepository->findBy(['user' => $this->getUser()]);
        $allCharts = array();
        $result = $statistiqueManager->countInfo($infoServant);
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
            array_push($allCharts, $chart);
        }
        return $this->render('user/index.html.twig', ['infoUtilisateur' => $infoUtilisateur, 'allCharts' => $allCharts]);
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
}
