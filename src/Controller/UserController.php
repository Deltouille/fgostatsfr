<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserInfo;
use App\Entity\ServantInfo;
use App\Form\UserInfoType;
use App\Form\ServantInfoType;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil_utilisateur")
     */
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        $em = $this->getDoctrine()->getManager();
        $userInfoRepository = $em->getRepository(UserInfo::class);
        $servantInfoRepository = $em->getRepository(ServantInfo::class);
        $infoUtilisateur = $userInfoRepository->findBy(['user' => $this->getUser()]);
        $infoServant = $servantInfoRepository->findBy(['user' => $this->getUser()]);
        $allCharts = array();
        $result = $this->countInfo($infoServant);
        foreach($result as $info){
            $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
            $chart->setData([
                'labels' => array_keys($info),
                'datasets' => [
                    [
                        'label' => 'oui',
                        'backgroundColor' => [$this->generateHexColor($info)],
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

    public function generateHexColor($array){
        $listeCouleurs = array();
        //On génere un nombre X de couleurs hexadécimales correspondant au nombre de ligne dans le tableau
        foreach($array as $info){
            $randomColor =  '#'.dechex(rand(0x000000, 0xFFFFFF));
            array_push($listeCouleurs, $randomColor);
        }
        //On transforme le tableau en chaine de caracteres
        $stringColors = implode(', ', $listeCouleurs);
        return $listeCouleurs;
    }

    public function countInfo($infoServant)
    {
        $stars = array();
        $bonds = array();
        $niveauNP = array();

        foreach($infoServant as $servant){
            array_push($stars, $servant->getServant()->getRarity());
            array_push($bonds, $servant->getNiveauBond());
            array_push($niveauNP, $servant->getNiveauNP());
        }

        $countServantStars = array_count_values($stars);
        foreach($countServantStars as $key => $val){
            $countServantStars[$key.'★'] = $val;
            unset($countServantStars[$key]);
        }
        $countServantBonds = array_count_values($bonds);
        foreach($countServantBonds as $key => $val){
            $countServantBonds['Bond '.$key] = $val;
            unset($countServantBonds[$key]);
        }
        $countServantNiveauNP = array_count_values($niveauNP);
        foreach($countServantNiveauNP as $key => $val){
            $countServantNiveauNP['NP '.$key] = $val;
            unset($countServantNiveauNP[$key]);
        }

        $allInfo = array('servantStars' => $countServantStars, 'servantBonds' => $countServantBonds, 'servantNiveauNP' => $countServantNiveauNP,);

        return $allInfo;
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

    public function stat(ChartBuilderInterface $chartBuilder, $array): Response
    {
        $chartBuilder = new ChartBuilderInterface();
        $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
        $chart->setData([
            'labels' => ['5★', '4★', '3★', '2★', '1★'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => ['#FCBB00', '#FCF800', '#C8C8C7', '#D07236', '#7A3407'],
                    'borderColor' => 'rgb(0, 0, 0)',
                    'data' => [16, 10, 5, 2, 20],
                ],
            ],
        ]);

        $chart->setOptions([/* ... */]);

        return $this->render('user/stat.html.twig', [
            'chart' => $chart,
        ]);
    }
}
