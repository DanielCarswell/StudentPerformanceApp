<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;

use App\Models\Assignment;
use App\Models\Classe;

class CSVUploadController extends Controller
{
    public function index(Request $request) {
        $file = $request->file('upload');

        if ($file) {
            $filename = $file->getClientOriginalName();
            $location = 'Uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);
            $file = fopen($filepath, "r");
            $imported = array();
            $i = 0;

            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }
                for ($c = 0; $c < $num; $c++) {
                    $imported[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading

            $j = 0;
            foreach ($imported as $data) {
                $j++;
                try {
                    DB::beginTransaction();
                    DB::table('student_assignment')
                    ->where('user_id', $data[0])
                    ->where('assignment_id', $request->assignment_id)
                    ->update([
                        'percent' => $data[1]
                    ]);
                    //Send Email Here
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            $assignment = Assignment::find($request->assignment_id);
            $class = Classe::find($assignment->class_id);
            
            return redirect()->route('assignment_grades', [$assignment, $class]);
        } else {
            //no file was uploaded
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
        return view('csvup.file_upload');
    }
}
