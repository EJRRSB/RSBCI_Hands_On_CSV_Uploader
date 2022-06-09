<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use File;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CsvController extends Controller
{
    //
    public function __construct()
    {  
        $this->middleware('auth');
    }



    public function create_csv()
    {
        $faker = Faker::create();
        // these are the headers for the csv file. Not required but good to have one incase of system didn't recongize it properly
        $headers = array(
            'Content-Type' => 'text/csv'
        );


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }


        //creating the download file
        $filename =  public_path("files/sample_created.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "Year",
            "Rank",
            "Recipient",
            "Country",
            "Career",
            "Tied",
            "Title"
        ]);

        
        //adding the data from the array 
        $counter = 0;        
        $year = 1999;     
        for ($i = 0; $i <= 10000; $i++)
        { 
            $counter++;
            $name = $faker->name;
 
            fputcsv($handle, [
                $year,
                $counter, 
                $name, 
                $faker->country,
                $faker->jobTitle, 
                '0', 
                $name, 
            ]);
            
            if($counter == 10){
                $counter = 0;                
                if($year == date("Y")){$year =  date("Y");}else{$year++;}
               
            }

        } 
          
        fclose($handle);

        
        //download command
        return Response::download($filename, "sample_created.csv", $headers);

    }

          

}
