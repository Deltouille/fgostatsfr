<?php

namespace App\Service;

class AtlasAcademyAPI 
{
    public function getResultAPI($data)
    {
        if($data == 'CraftEssence'){
            $url = 'https://api.atlasacademy.io/export/JP/nice_equip_lang_en.json';
        }
        if($data == 'Servant'){
            $url = "https://api.atlasacademy.io/export/JP/nice_servant_lang_en.json";
            //$url = "https://api.atlasacademy.io/nice/JP/servant/1?lore=true&lang=en";
        }
        if($data == 'Material'){
            $url = "https://api.atlasacademy.io/export/JP/nice_item_lang_en.json";
        }
        if($data == 'Event'){
            $url = "https://api.atlasacademy.io/export/NA/nice_event.json";
        }
        if($data == 'War'){
            $url = "https://api.atlasacademy.io/export/JP/basic_war_lang_en.json";
        }
        $parameters = [];
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

    public function getWarAPI($data)
    {

        $url = "https://api.atlasacademy.io/nice/JP/war/".$data;
        $parameters = [];
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