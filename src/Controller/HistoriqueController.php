<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\FileException;
use Symfony\Component\HttpFoundation\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use App\Form\HistoriqueType;
use thiagoalessio\TesseractOCR\TesseractOCR;
use App\Service\AtlasAcademyAPI;
use App\Service\StatistiqueManager;
use App\Entity\CraftEssence;
use App\Entity\Servant;
use App\Entity\HistoriqueImage;
use App\Entity\Invocation;
use GuzzleHttp\Client;


class HistoriqueController extends AbstractController
{
    /**
     * @Route("/ajout-roll", name="ajout-roll")
     */
    public function addRoll(Request $request, SluggerInterface $slugger, AtlasAcademyAPI $atlasAcademyAPI): Response
    {
        $em = $this->getDoctrine()->getManager();
        $ceRepository = $em->getRepository(CraftEssence::class);
        $servantRepository = $em->getRepository(Servant::class);
        $invocationRepository = $em->getRepository(Invocation::class);
        $form = $this->createForm(HistoriqueType::class);
        //Serviras a stocker le nombre de Craft Essence 5* obtenues
        $countCE5 = 0;
        //Serviras a stocker le nombre de Servant 4* obtenus
        $countServant4 = 0;
        //Serviras a stocker le nombre de Servant 5* obtenus
        $countServant5 = 0;
        //Si la requête est une requête POST
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            //Si le formulaire est envoyé et que le formulaire et valide
            if($form->isSubmitted() && $form->isValid()){
                //On récupère l'image envoyée via le formulaire
                $image = $form->get('image')->getData();
                //Si c'est bien une image
                if($image){
                    //On récupère le nom de l'image
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    //On génère un nouveau nom depuis son nom de départ
                    $safeFilename = $slugger->slug($originalFilename);
                    //On ajoute une uniqId
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                    //Et on essaie de déplacer cette image dans le dossier public, sinon on retour une erreur
                    try{
                        $image->move($this->getParameter('image_upload'), $newFilename, );
                    }catch(FileException $e){
                        return new Response($e->getMessage());
                    }
                    //On récupère le chemin de l'image sur le serveur
                    $filePath = $this->getParameter('kernel.project_dir').'/public/historique/'.$newFilename;
                    //On récupère l'URL de l'image                    
                    //Si l'utilisateur a choisis TesseractOCR
                    if($form->get('typeOCR')->getData() == 'TesseractOCR'){
                        //On créer un nouvel objet Tessact qui auras en parametre le chemin de l'image
                        //Tessaract vas permettre (en partie) de récupèrer les caractères présents sur une image et les renvoyer sous forme de chaîne de caractère
                        $tesseractInstance = new TesseractOCR($filePath);
                        //On indique a Tessaract que la langue présente sur l'image est japonaise
                        $tesseractInstance->lang("jpn", "eng");
                        //On exectue Tesseract
                        $result = $tesseractInstance->run();
                        //On vas chercher les caractères japonais de "Servant" et "Craft Essence" présents dans la chaine retournée par Tesseract pour les remplacer
                        $search = array('サーヴァント', '概念礼装');
                        $replace = array('Servant', 'Craft Essence');
                        $str = str_replace($search, $replace, $result);
                        //On transforme la chaîne retournée par Tessaract sous forme de tableau, délimité par les "\n"
                        $array_str = explode("\n", $str);
                        $array_got = array();
                        //On parcours toutes les lignes
                        foreach($array_str as $currentLine){
                            //Si la ligne courante contient le mot "Servant" ou "Craft Essence"
                            if(str_contains($currentLine, "Craft Essence") || str_contains($currentLine, "Servant")){
                                //On récupère sous forme de tableau toute la partie après le caractère 】dans une chaine type "[servant] 3 machin"
                                $getPartieDeDroite = explode("】", $currentLine);
                                $getName = explode(" ", $getPartieDeDroite[1]);
                                //On regarde si le premier élément du tableau existe et si il est vide, car Tessarct ne fonctionnant pas très bien, on peux avoir des fois un tableau ressemblant a ["", "4", "Servant", etc...] et ["4", "Servant", etc...]
                                if($getName[0] == ""){
                                    $itemName = $getName[2];
                                    
                                }else{
                                    $itemName = $getName[1];
                                }
                                //Si la ligne courante contient le mot Craft Essence
                                if(str_contains($currentLine, "Craft Essence")){
                                    //On recupère le détails de la Craft Essence qui as le nom
                                    $detailCraftEssence = $atlasAcademyAPI->getCE($itemName);
                                    //Si la Craft Essence a été reconnue
                                    if(!empty($detailCraftEssence)){
                                        //On récupère l'ID de la craft essence
                                        $id = $detailCraftEssence[0]["collectionNo"];
                                        //On créer un nouvel objet HistoriqueImage
                                        $historique = new HistoriqueImage();
                                        //On set la craft essence
                                        $historique->setCraftEssence($ceRepository->find($id));
                                        //On set le servant
                                        $historique->setServant(null);
                                        //On set la date
                                        $historique->setDate(date("Y-m-d"));
                                        //On set l'utilisateur
                                        $historique->setUser($this->getUser());
                                        //On persist
                                        $em->persist($historique);
                                        $em->flush();
                                        if($ceRepository->find($id)->getCERarity() == 5 ){
                                            $countCE5 = $countCE5 + 1;
                                        }
                                    }else{
                                        break;
                                    }
                                }
                                //Si la ligne courante contient le mot Servant
                                if(str_contains($currentLine, "Servant")){
                                    //On recupère le détails du servant qui as le nom
                                    $detailServant = $atlasAcademyAPI->getServant($itemName);
                                    //Si le Servant a été reconnue
                                    if(!empty($detailServant)){
                                        //On récupère l'ID du servant
                                        $id = $detailServant[0]["collectionNo"];
                                        //On créer un nouvel objet HistoriqueImage
                                        $historique = new HistoriqueImage();
                                        //On set la craft essence
                                        $historique->setCraftEssence(null);
                                        //On set le servant
                                        $historique->setServant($servantRepository->find($id));
                                        //On set la date
                                        $historique->setDate(date("Y-m-d"));
                                        //On set l'utilisateur
                                        $historique->setUser($this->getUser());
                                        //On persist
                                        $em->persist($historique);
                                        $em->flush();
                                        if($servantRepository->find($id)->getRarity() == 5 ){
                                            $countServant5 = $countServant5 + 1;
                                        }
                                        if($servantRepository->find($id)->getRarity() == 4 ){
                                            $countServant4 = $countServant4 + 1;
                                        }
                                    }else{
                                        break;
                                    }
                                }
                            }
                        }
                    }elseif($form->get('typeOCR')->getData() == 'OCR.SPACE'){
                        $result = $this->getTextFromImage($filePath);
                        $text = $result["ParsedResults"][0]["ParsedText"];
                        $search = array('サーウアント', '概念礼装');
                        $replace = array('Servant', 'Craft Essence');
                        $str = str_replace($search, $replace, $text);
                        $array_str = explode("\n", $str);
                        $array_got = array();
                        foreach($array_str as $currentLine){
                            if(str_contains($currentLine, "Craft Essence") || str_contains($currentLine, "Servant")){
                            
                            }
                        }
                    } 
                }
                $invocation = new Invocation();
                $invocation->setNombreServant5($countServant5);
                $invocation->setNombreServant4($countServant4);
                $invocation->setNombreCraftEssence5($countCE5);
                $invocation->setDateInvocation(date("Y-m-d"));
                $invocation->setUser($this->getUser());
                $invocation->setNombreSQUsed($form->get('quartz')->getData());
                $em->persist($invocation);
                $em->flush();
                unlink($filePath);
                return $this->redirectToRoute('historique');
            }
        }
        return $this->render('historique/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    public function getTextFromImage($pathOfFile){
        $fileData = fopen($pathOfFile, 'r');
        $client = new Client();
        try {
        $r = $client->request('POST', 'https://api.ocr.space/parse/image',[
            'headers' => ['apiKey' => 'helloworld'],
            'multipart' => [['name' => 'language', 'contents' => 'jpn'],['name' => 'file','contents' => $fileData]]
        ], ['file' => $fileData]);
        $response =  json_decode($r->getBody(),true);
        if(!isset($response['ErrorMessage'])) {
            return $response;
        } else {
            header('HTTP/1.0 400 Forbidden');
            //faire page erreur
            echo $response['ErrorMessage'];
        }
        } catch(Exception $err) {
            header('HTTP/1.0 403 Forbidden');
            //faire page erreur
            echo $err->getMessage();
        }

    }

    /**
     * @Route("/historique-invocation", name="historique")
     */
    public function index(ChartBuilderInterface $chartBuilder, StatistiqueManager $statistiqueManager): Response
    {
        $em = $this->getDoctrine()->getManager();
        $historiqueRepository = $em->getRepository(HistoriqueImage::class);
        $listeHistorique = $historiqueRepository->findBy(['user' => $this->getUser()], ['id' => 'DESC'], null, null);

        $resultHistorique = $statistiqueManager->countInfoHistorique($listeHistorique);
        $historiqueCharts = array();

        foreach($resultHistorique as $info){
            $chart = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
            $chart->setData([
                'labels' => array_keys($info),
                'datasets' => [
                    [
                        'label' => 'oui',
                        'backgroundColor' => ["rgb(251, 191, 36, 0.05)", "rgb(245, 158, 11, 0.05)", "rgb(192, 192, 192, 0.05)"],
                        'borderColor' => ["rgb(251, 191, 36)", "rgb(245, 158, 11)", "rgb(192, 192, 192)"],
                        'data' => array_values($info),
                    ],
                ],
            ]);
            $chart->setOptions([/* ... */]);
            array_push($historiqueCharts, $chart);
        }

        return $this->render('historique/historique.html.twig', [
            'listeHistorique' => $listeHistorique,
            'historiqueCharts' => $historiqueCharts,
        ]);
    }
}
