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
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
    * Upload Attendance for students from CSV file.
    *
    * @param \Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function attendance(Request $request) {
        //Get file from request.
        $file = $request->file('upload');

        if ($file) {
            $filename = $file->getClientOriginalName();
            $location = 'Uploads';
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);
            $file = fopen($filepath, "r");
            $imported = array();
            $i = 0;

            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
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
                    DB::table('student_class')
                    ->where('student_id', $data[0])
                    ->where('class_id', $request->class_id)
                    ->update([
                        'attendance' => $data[1]
                    ]);
                    //Send Email Here
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            $class = Classe::find($request->class_id);
            
            return redirect()->route('class_attendance', $class);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * Upload Assignments marks from CSV file.
    *
    * @param \Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function assignment_marks(Request $request) {
        //Get file from request.
        $file = $request->file('upload');

        //If file exists.
        if ($file) {
            //Get file name and initialize location to save.
            $filename = $file->getClientOriginalName();
            $location = 'Uploads';
            //Move file to location and get filepath of that file in the location.
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            //Open file and initalize local variables.
            $file = fopen($filepath, "r");
            $imported = array();
            $i = 0;

            //Loop throug csv file up to 1000 rows seperated by comma as filedata if successful.
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                //Skip first row as it involves titles not data.
                if ($i == 0) {
                    $i++;
                    continue;
                }
                //Set imported at position i equal to each part of row in file data.
                for ($c = 0; $c < $num; $c++) {
                    $imported[$i][] = $filedata[$c];
                }

                //increment i.
                $i++;
            }
            fclose($file); //Close after reading

            //Initialize new incremental variable.
            $j = 0;
            foreach ($imported as $data) {
                //Increment j.
                $j++;
                //Try catch for Exceptions.
                try {
                    //Begin transaction incase wrongful data add.
                    DB::beginTransaction();
                    //Update student assignment marks.
                    DB::table('student_assignment')
                    ->where('user_id', $data[0])
                    ->where('assignment_id', $request->assignment_id)
                    ->update([
                        'percent' => $data[1]
                    ]);
                    //Commit the transaction.
                    DB::commit();
                } catch (\Exception $e) {
                    //Rollback the transaction.
                    DB::rollBack();
                }
            }
            $assignment = Assignment::find($request->assignment_id);
            $class = Classe::find($assignment->class_id);
            
            return redirect()->route('assignment_grades', [$assignment, $class]);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * Upload student accounts to Database from CSV file.
    *
    * @param \Illuminate\Http\Request request 
    * @return route.redirect  
    */
    public function upload_student_accounts(Request $request) {
        //Get file from request.
        $file = $request->file('upload');

        //If file exists.
        if ($file) {
            //Get file name and initialize location to save.
            $filename = $file->getClientOriginalName();
            $location = 'Uploads';
            //Move file to location and get filepath of that file in the location.
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            //Open file and initalize local variables.
            $file = fopen($filepath, "r");
            $imported = array();
            $i = 0;

            //Loop throug csv file up to 1000 rows seperated by comma as filedata if successful.
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                //Skip first row as it involves titles not data.
                if ($i == 0) {
                    $i++;
                    continue;
                }
                //Set imported at position i equal to each part of row in file data.
                for ($c = 0; $c < $num; $c++) {
                    $imported[$i][] = $filedata[$c];
                }

                //increment i.
                $i++;
            }
            fclose($file); //Close after reading

            //Initialize new incremental variable.
            $j = 0;
            foreach ($imported as $data) {
                //Increment j.
                $j++;
                //Try catch for Exceptions.
                try {
                    //Begin transaction incase wrongful data add.
                    DB::beginTransaction();
                    //Insert users to database.
                    DB::table('users')
                    ->insert([
                        'email' => $data[0],
                        'firstname' => $data[1],
                        'lastname' => $data[2],
                        'password' => $data[3],
                        'fullname' => $data[1] . ' ' . $data[2],
                        'username' => substr($data[1], 0) . ' ' . substr($data[2], 0) . rand(10000, 99999),
                        'remember_token' => Str::random(10),
                        'created_at' => now(),
                        'updated_at' => now(),
                        'password' => Hash::make($request->password)
                    ]);
                    //Commit the transaction.
                    DB::commit();
                } catch (\Exception $e) {
                    //Rollback the transaction.
                    DB::rollBack();
                }
            }
            return redirect()->route('accounts');
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
    * Upload students to a class from csv file.
    *
    * @param \Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function upload_students(Request $request) {
        //Get file from request.
        $file = $request->file('upload');

        //If file exists.
        if ($file) {
            //Get file name and initialize location to save.
            $filename = $file->getClientOriginalName();
            $location = 'Uploads';
            //Move file to location and get filepath of that file in the location.
            $file->move($location, $filename);
            $filepath = public_path($location . "/" . $filename);

            //Open file and initalize local variables.
            $file = fopen($filepath, "r");
            $imported = array();
            $i = 0;

            //Loop throug csv file up to 1000 rows seperated by comma as filedata if successful.
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                //Skip first row as it involves titles not data.
                if ($i == 0) {
                    $i++;
                    continue;
                }
                //Set imported at position i equal to each part of row in file data.
                for ($c = 0; $c < $num; $c++) {
                    $imported[$i][] = $filedata[$c];
                }

                //increment i.
                $i++;
            }
            fclose($file); //Close after reading

            //Initialize new incremental variable.
            $j = 0;
            foreach ($imported as $data) {
                //Increment j.
                $j++;
                //Try catch for Exceptions.
                try {
                    //Begin transaction incase wrongful data add.
                    DB::beginTransaction();
                    //Add student to class.
                    DB::table('student_class')
                    ->insert([
                        'student_id' => $data[0],
                        'class_id' => $request->class_id
                    ]);

                    //Get all assignments for class.
                    $assignments = Assignment::where('class_id', $request->class_id)->get();

                    //Add student association to all assignments for class.
                    foreach($assignments as $assignment)
                    {
                        DB::table('student_assignment')
                        ->insert(['class_id' => $request->class_id, 'user_id' => $data[0], 'assignment_id' => $assignment->id]);
                    }

                    //Commit the transaction.
                    DB::commit();
                } catch (\Exception $e) {
                    //Rollback the transaction.
                    DB::rollBack();
                }
            }
            //get class model for view.
            $class = Classe::find($request->class_id);
            
            return redirect()->route('class.students', $class);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }
}
