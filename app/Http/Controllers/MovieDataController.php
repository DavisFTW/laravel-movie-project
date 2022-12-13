<?php

namespace App\Http\Controllers;
use App\Models\movieData;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

class MovieDataController extends Controller
{
private function getMoviebyIDAPI($ID){
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://mdblist.p.rapidapi.com/?i=$ID",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: mdblist.p.rapidapi.com",
                "X-RapidAPI-Key: ed024143ffmsh68a50b37c1d5b1cp11d77fjsn4a5ae1ec93b0"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
           //var_dump($response);
        }
} 

public function getMovieByName($name){
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://online-movie-database.p.rapidapi.com/title/find?q=$name",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: online-movie-database.p.rapidapi.com",
            "X-RapidAPI-Key: ed024143ffmsh68a50b37c1d5b1cp11d77fjsn4a5ae1ec93b0"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        //proceed
    }
}
    public function getMovie($movieArg){
        if($movieArg[0] == 't' && $movieArg[1] == 't')
        {
            
        }
}
       protected function insertData(string $data){
        return movieData::create([
            'movie_id' => $data,
        ]);
}
    protected function isDataPresent($tableName)
    {
        $count = movieData::get()->count(); 
        if($count >= 1){
            return true;
        } else{
            return false;
        }
}   
    protected function isUpdated($tableName, $requestedInterval)
    {
        // returns false if required 2 update
        $createdAtObj = DB::select("select created_at from movie_data"); //`$tableName`
        $currDate = new DateTime(date('Y-m-d H:i:s'));
        $dbDate = new DateTime($createdAtObj[1]->created_at);

        $dbInterval = $currDate->diff($dbDate)->format('%d');

        if ($dbInterval >= $requestedInterval) {
            return false;  
        } else {
            return true;
        }
}
    protected function apiPopular($reset = true){
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
        } 
        else {
            $arrayt = [];
            foreach ($response as $key => $value) {
                array_push($arrayt, $response[$key]);
            }
            if($reset){
                foreach ($arrayt as $key => $value) {
                    MovieDataController::insertData($arrayt[$key]);
                }
            }
            else{
                foreach ($arrayt as $key => $value) {
                    movieData::where('active', 1)->update(['movie_id' => $arrayt[$key]]);
                }
            }
        }
}
    function initDataWorks()
    {
        if(!MovieDataController::isDataPresent('movie_data'))
        {
            MovieDataController::apiPopular();
            return 0;
        }
        if (MovieDataController::isUpdated('movie_data', 7)) {
            return 0;
        }
        MovieDataController::apiPopular(false);
    }
}
