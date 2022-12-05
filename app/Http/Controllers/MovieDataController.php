<?php

namespace App\Http\Controllers;
use App\Models\movieData;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

class MovieDataController extends Controller
{
        protected function insertData(string $data)
    {
        return movieData::create([
            'movie_id' => $data,
        ]);
    }
    private function theGreatReset($table_name)
    {
        DB::statement("SET @count = 0;");
        DB::statement("UPDATE `$table_name` SET `$table_name`.`id` = @count:= @count + 1;");
        DB::statement("ALTER TABLE `$table_name` AUTO_INCREMENT = 1;");
    }


    protected function isDataPresent($tableName)
    {
        $count = DB::select("SELECT * FROM `$tableName` WHERE ID = 1;");
        IF($count >= 1){
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

    protected function apiPopular(){
        MovieDataController::theGreatReset('movie_data');
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
            foreach ($arrayt as $key => $value) {
                MovieDataController::insertData($arrayt[$key]);
            }
        }
    }
    function initDataWorks()
    {
        if(!MovieDataController::isDataPresent('movie_data'))
        {
            var_dump("ERROR: no data in db !");
            MovieDataController::apiPopular();
            return 0;
        }

        if (MovieDataController::isUpdated('movie_data', 7)) {
            var_dump("no need to update !");
            return 0;
        }

        //#FINISHME: find out how to update values
    }
}