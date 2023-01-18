<?php

namespace App\Http\Controllers;
use App\Models\movieData;
use DOMDocument;
use Illuminate\Queue\LuaScripts;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

class MovieDataController extends Controller
{
        private function getMoviebyID($ID)
    {
        $array = json_decode($ID, true);
        $curr = $array['movie_id'];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://mdblist.p.rapidapi.com/?i=$curr",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: mdblist.p.rapidapi.com",
                "X-RapidAPI-Key: ce57f65596msh6dc04e854ba1d77p1e556djsn4069d16d8b62"
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

    public function getMovieByName($name)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://mdblist.p.rapidapi.com/?s=jaws",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: mdblist.p.rapidapi.com",
                "X-RapidAPI-Key: ce57f65596msh6dc04e854ba1d77p1e556djsn4069d16d8b62"
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
    protected function insertData(string $data)
    {
        return movieData::create([
            'movie_id' => $data,
        ]);
    }
    protected function isDataPresent($tableName)
    {
        $count = movieData::get()->count();
        if ($count >= 1) {
            return true;
        } else {
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
    protected function apiPopular($reset = true)
    {

        if($reset == false){
            return 0;
        }

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
            $arrayt = [];
            foreach ($response as $key => $value) {
                array_push($arrayt, $response[$key]);
            }
            if ($reset) {
                foreach ($arrayt as $key => $value) {
                    $this->insertData($arrayt[$key]);
                }
            } else {
                foreach ($arrayt as $key => $value) {
                    movieData::where('active', 1)->update(['movie_id' => $arrayt[$key]]);
                }
            }
        }
    }
    
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
    
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    function initDataWorks()
    {
        if (!$this->isDataPresent('movie_data')) {
            $this->apiPopular();
        }
        if (!$this->isUpdated('movie_data', 7)) {
            $this->apiPopular();
        }
        $this->apiPopular(false);
        $data = DB::select("select movie_id from movie_data LIMIT 10;");

        $test = json_encode($data[1]);
        $this->getMoviebyID($test);
        }
    }