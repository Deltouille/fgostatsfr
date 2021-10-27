<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Servant;
class FateController extends AbstractController
{
    /**
     * @Route("/fate", name="fate")
     */
    public function index(): Response
    {
        return $this->render('fate/index.html.twig', [
            'controller_name' => 'FateController',
        ]);
    }

    /**
     * @Route("/liste-servant", name="liste-servant")
     */
    public function listeServant(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $servantRepository = $em->getRepository(Servant::class);
        $listeServant = $servantRepository->findAll();
        return $this->render('fate/listeServant.html.twig', [
            'listeServant' => $listeServant,
        ]);
    }

    /**
     * @Route("/details-servant/{id}", name="details-servant")
     */
    public function detailServant(int $id): Response
    {
        $servantDetails = $this->getAtlasAcademyAPI($id);
        return $this->render('fate/detailsServant.html.twig', ['servantDetails' => $servantDetails]);
    }

    public function getAtlasAcademyAPI($id){
        $url = 'https://api.atlasacademy.io/nice/JP/servant/'.$id;
        $parameters = [
                'lang' => 'en',
            ];
        $headers = [
                'Accepts: application/json',
            ];
        $qs = http_build_query($parameters);
        // query string encode the parameters
        $request = "{$url}?{$qs}"; // create the request URL
        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
          CURLOPT_URL => $request,            // set the request URL
          CURLOPT_HTTPHEADER => $headers,     // set the headers 
          CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));
        $response = curl_exec($curl); // Send the request, save the response
        curl_close($curl); // Close request
        $var = json_decode($response, true);
        return $var;
    }
}
