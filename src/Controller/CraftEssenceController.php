<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CraftEssence;
class CraftEssenceController extends AbstractController
{
    /**
     * @Route("/craft_essence", name="craft_essence")
     */
    public function index(): Response
    {
        $listeCraftEssence = array();   //Tableau qui vas servir a récupèrer toutes les craft essences et leurs informations.
        $result = $this->getAtlasAcademyAPI();  //On récupère la réponse de l'api d'AtlasAcademy qui vas contenir toutes les craft essences et leurs informations associès.
        foreach($result as $currentCraftEssence)    //On parcours la réponse de l'api.
        {
            $craftEssence = [
                'Id' => $currentCraftEssence['collectionNo'], //On sauvegarde le "collectionNo" de la craft essence en cours pour l'utiliuser en temps qu'ID.
                'Name' => $currentCraftEssence['name'], //On sauvegarde le nom de la craft essence en cours.
                'Url' => $currentCraftEssence['extraAssets']['charaGraph']['equip'][$currentCraftEssence['id']] //On sauvegarde le l'url de l'image de la craft essence.
            ];
            array_push($listeCraftEssence, $craftEssence);  //On push dans le tableau "listeCraftEssence" la craft essence en cours.
        }
        usort($listeCraftEssence, function($firstId, $secondId){    //On trie le tableau "listeCraftEssence" afin de mettre dans l'ordre de l'ID (collectionNo) de la craft essence -
            return $firstId['Id'] <=> $secondId['Id'];              //au lieu de l'ordre dans lequel la craft essence est push dans le tableau car le premier ID retourné par l'api -
        });                                                         //est 191, donc on met l'id 1 en premier.

        return $this->render('craft_essence/listeCraftEssence.html.twig', ['listeCraftEssence' => $listeCraftEssence]);
    }

    public function getAtlasAcademyAPI(){
        $url = 'https://api.atlasacademy.io/export/JP/nice_equip_lang_en.json';
        $parameters = [
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
