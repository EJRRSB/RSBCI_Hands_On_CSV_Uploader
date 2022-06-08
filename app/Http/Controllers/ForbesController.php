<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\User;
use App\Models\ForbesTop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForbesController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
        $this->middleware('auth');
    }




    public function index()
    {    
        
        return view('home');
    }
    




    // AJAX REQUEST
    public function getForbesData(Request $request)
    {  
        $search_field = $request->search_option;
         
        // READ VALUES
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowpage = $request->get('length');
        
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
 
  
        $columnIndex = $columnIndex_arr[0]['column'];  
        // $columnName = $columnIndex_arr[$columnIndex]['data']; 
        $columnSortOrder = $order_arr[0]['dir']; 
        $searchValue = $search_arr['value']; 

        // Total record count
        $totalRecords = ForbesTop::select('count(*) as allcount')->count(); 
 
        // Total record count with search
        $totalRecordswithFilter = ForbesTop::select('count(*) as allcount')->where($search_field,'like','%' . $searchValue . '%')->count();
 

        // Total records with search
        $records = ForbesTop::select('forbes_tops.*')
                            ->where($search_field,'like','%' . $searchValue . '%')
                            ->orderBy('year',$columnSortOrder)
                            ->skip($start)
                            ->take($rowpage)
                            ->get(); 
                             

        $data_arr = array();
        foreach($records as $record)
        {   
            $data_arr[] = array(
                "id" => $record->id,
                "year" => $record->year,
                "rank" => $record->rank,
                "recipient" => $record->recipient,
                "country" => $record->country,
                "career" => $record->career,
                "tied" => $record->tied,
                "title" => $record->title   
            );
        } 
        
        echo json_encode(
            array(
                "draw" => intval($draw), 
                "recordsTotal"    => intval($totalRecords),
			    "recordsFiltered" => intval($totalRecordswithFilter),
                "aaData" => $data_arr 
            )
        );
    }












    public function store()
    {  
        

        if(empty(request()->file('csv_file'))){ // check file if empty
            $this->Json_return(201, 'Csv file is required.');
            die;
        } 

        $path = file(request()->file('csv_file')->getRealPath()); // get file and data
        $data = array_map('str_getcsv', $path); 
                  

        ForbesTop::truncate(); //truncate table
        $counter = 0; //set counter
        foreach($data as $row){ // read csv

            if($counter > 0){
                $for_validation = array( 
                    'user_id' => auth()->user()->id,
                    'year' => $row[0],
                    'rank' => $row[1],
                    'recipient' => $row[2],
                    'country' => $row[3],
                    'career' => $row[4],
                    'tied' => $row[5],
                    'title' => $row[6]
                );
                
                $validated = Validator::make($for_validation, [
                    'year' => 'required|numeric',
                    'rank' => 'required|numeric',
                    'recipient' => 'required',
                    'country' => 'required',
                    'career' => 'required',
                    'tied' => 'required|numeric',
                    'title' => 'required',
                ]);
 
 

                if ($validated->fails()) {  
                    $this->Json_return(202, $validated->errors()->add('line', 'Error line number: ' .$counter + 1 . '. [' . $counter . ' out of ' . count($data). ' data have been inserted]')); // return validation error
                    die;
                }else{  

                    $insert = ForbesTop::insert($for_validation); // insert data
                    if(!$insert){
                        $this->Json_return(201, $counter . ' inserted data out of ' . count($data));  // return query error
                        die;
                    }
                }
            }

            $counter ++; 

        }    

 
        $this->Json_return(200, 'Data successfully added!'); // return success 

  
    }

    

    public function Json_return($status, $message)
    {
        echo json_encode(array(
            "statusCode" => $status,
            "message" => $message
        )); 
    }





    public function getAvailableDates()
    { 
        $years = ForbesTop::select('year')->groupBy('year')->orderBy('year','desc')->get();
        $this->Json_return(200, $years);
    }




    public function getReports()
    {
        
        // $data = request()->validate([
        //     'caption' => 'required',
        //     'image' => ['required','image'] 
        // ]);
        
        $reportData = auth()->user()->forbesTop()->get();
        
        $this->Json_return(200, $reportData);
    }

 
}  