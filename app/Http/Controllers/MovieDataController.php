<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MovieDataController as ControllersMovieDataController;
use Illuminate\Http\Request;
use App\Models\movieData;

class MovieDataController extends Controller
{
    protected function create(string $data)
    {
        return movieData::create([
            'movie_id' => $data, 
        ]);
    }

    function getPopular(){

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://imdb8.p.rapidapi.com/title/get-most-popular-movies?homeCountry=US&purchaseCountry=US&currentCountry=US",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: imdb8.p.rapidapi.com",
                "X-RapidAPI-Key: ce57f65596msh6dc04e854ba1d77p1e556djsn4069d16d8b62"
            ],
        ]);

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        $response = str_replace('/title/', '', $response);
        $response = str_replace('/', '', $response);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // print_r($response);
        }

        $arrayt = [];
        foreach ($response as $key => $value) {
        // $arrayt. = $response[$key];
        array_push($arrayt, $response[$key]);
        }

        //create($response);
        foreach ($arrayt as $key => $value) {
            MovieDataController::create($arrayt[$key]);
        }
        // MovieDataController::create($arrayt);
    }
}
