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
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $userInfoRepository = $em->getRepository(UserInfo::class);
        $infoUtilisateur = $userInfoRepository->findBy(['user' => $this->getUser()]);
        return $this->render('user/index.html.twig', ['infoUtilisateur' => $infoUtilisateur]);
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

    /**
     * @Route("/", name="homepage")
     */
    public function stat(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([/* ... */]);

        return $this->render('user/stat.html.twig', [
            'chart' => $chart,
        ]);
    }
}
