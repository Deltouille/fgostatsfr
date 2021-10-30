<?php

namespace App\Service;

class StatistiqueManager 
{
    public function generateHexColor($array){
        $listeCouleurs = array();
        //On génere un nombre X de couleurs hexadécimales correspondant au nombre de ligne dans le tableau
        foreach($array as $info){
            $randomColor =  "'".'#'.dechex(rand(0x000000, 0xFFFFFF))."'";
            array_push($listeCouleurs, $randomColor);
        }
        //On transforme le tableau en chaine de caracteres
        $stringColors = implode(', ', $listeCouleurs);
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

        $allInfo = array('servantStars' => $countServantStars, 'servantBonds' => $countServantBonds, 'servantNiveauNP' => $countServantNiveauNP);

        return $allInfo;
    }
}