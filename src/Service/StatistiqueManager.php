<?php

namespace App\Service;

class StatistiqueManager 
{
    public function generateHexColor($array){
        $listeCouleurs = array();
        //On génere un nombre X de couleurs hexadécimales correspondant au nombre de ligne dans le tableau
        foreach($array as $info){
            $randomColor =  '#'.dechex(rand(0x000000, 0xFFFFFF));
            array_push($listeCouleurs, $randomColor);
        }
        //On transforme le tableau en chaine de caracteres
        $stringColors = implode('", "', $listeCouleurs);
        return $stringColors;
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
        //On défini l'ordre
        $orderStars = ['5★', '4★', '3★', '2★', '1★', '0★'];
        //On trie le tableau pour qu'il suive un orderStars descandant ((5 4 3 2 1))
        uksort($countServantStars, function($x, $y) use ($orderStars) {
            return array_search($x, $orderStars) > array_search($y, $orderStars);
        });

        $countServantBonds = array_count_values($bonds);
        foreach($countServantBonds as $key => $val){
            $countServantBonds['Bond '.$key] = $val;
            unset($countServantBonds[$key]);
        }
        //On défini l'ordre
        $orderBonds = ['Bond 10', 'Bond 9', 'Bond 8', 'Bond 7', 'Bond 6', 'Bond 5', 'Bond 4', 'Bond 3', 'Bond 2', 'Bond 1', 'Bond 0'];
        //On trie le tableau pour qu'il suive un orderBonds descandant ((5 4 3 2 1))
        uksort($countServantBonds, function($x, $y) use ($orderBonds) {
            return array_search($x, $orderBonds) > array_search($y, $orderBonds);
        });

        $countServantNiveauNP = array_count_values($niveauNP);
        foreach($countServantNiveauNP as $key => $val){
            $countServantNiveauNP['NP '.$key] = $val;
            unset($countServantNiveauNP[$key]);
        }
        //On défini l'ordre
        $orderNP = ['NP5', 'NP4', 'NP3', 'NP2', 'NP1'];
        //On trie le tableau pour qu'il suive un orderNP descandant ((5 4 3 2 1))
        uksort($countServantNiveauNP, function($x, $y) use ($orderNP) {
            return array_search($x, $orderNP) > array_search($y, $orderNP);
        });

        $allInfo = array('servantStars' => $countServantStars, 'servantBonds' => $countServantBonds, 'servantNiveauNP' => $countServantNiveauNP);
        //dd($allInfo);
        return $allInfo;
    }

    public function countInfoCraftEssence($infoCraftEssence){
        $niveauCE = array();
        $rarityCE = array();
        $typeCE = array();
        $mlbCE = array();

        foreach($infoCraftEssence as $craftEssence){
            array_push($niveauCE, $craftEssence->getNiveauCE());
            array_push($rarityCE, $craftEssence->getCraftEssence()->getCERarity());
            array_push($typeCE, $craftEssence->getCraftEssence()->getCEType());
            array_push($mlbCE, $craftEssence->getCraftEssence()->getCEType());
        }
        $countNiveauCE = array_count_values($niveauCE);
        foreach($countNiveauCE as $key => $val){
            $countNiveauCE['Niveau '.$key] = $val;
            unset($countNiveauCE[$key]);
        }

        $countRarityCE = array_count_values($rarityCE);
        foreach($countRarityCE as $key => $val){
            $countRarityCE[$key.'★'] = $val;
            unset($countRarityCE[$key]);
        }
        $countTypeCE = array_count_values($mlbCE);

        $countMlbCE = array_count_values($mlbCE);
        foreach($countRarityCE as $key => $val){
            $countRarityCE['MLB '.$key] = $val;
            unset($countRarityCE[$key]);
        }
        $countCEMlb = array_count_values($niveauCE);

        $allInfo = array('countNiveauCE' => $countNiveauCE, 'countRarityCE' => $countRarityCE, 'countTypeCE' => $countTypeCE, 'countCEMlb' => $countTypeCE);

        return $allInfo;

    }

    public function countInfoInvocation($infoInvocation){
        $dates = array();
        $nombreSQ = array();
        $nombreServant5 = array();
        $nombreServant4 = array();
        $nombreCE5 = array();

        foreach($infoInvocation as $invocation){
            array_push($dates, $invocation->getDateInvocation());
            array_push($nombreSQ, $invocation->getNombreSQUsed());
            array_push($nombreServant5, $invocation->getNombreServant5());
            array_push($nombreServant4, $invocation->getNombreServant4());
            array_push($nombreCE5, $invocation->getNombreCraftEssence5());
        }

        $allInfo = array(
            'nombreSaintQuartz' => $nombreSQ,
            'dates' => $dates,
            'nombreServant5' => $nombreServant5,
            'nombreServant4' => $nombreServant4,
            'nombreCE5' => $nombreCE5,

        );

        return $allInfo;

    }
}