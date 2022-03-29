<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Models\Assignment;
use App\Models\Classe;
use App\Models\User;

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

                    //Updates the students grades.
                    $this->update_student_grades($data[0]);
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
                        'fullname' => $data[1] . ' ' . $data[2],
                        'remember_token' => \Str::random(10),
                        'password' => \Hash::make($data[3]),
                        'updated_at' => now(),
                        'created_at' => now()
                    ]);

                    $id = 0;
                    $users = DB::table('users')->get();

                    //Get id of added user by looping til final user in database
                    //who will be the account just added.
                    foreach($users as $user) {
                        $id = $user->id;
                    }

                    //Add Student role to User.
                    DB::table('user_role')
                    ->insert([
                        'role_id' => 4,
                        'user_id' => $id
                    ]);

                    //Commit the transaction.
                    DB::commit();
                } catch (\Exception $e) {
                    dd('rip');
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

            //Loop through csv file up to 1000 rows seperated by comma as filedata if successful.
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

    /**
    * Upgrades students grade for the full class by calculating total grade by all assignments
    * meaning if a student has done 1 assignment and got 50%, their grade will be 50% or an assignment
    * with 50% and one with 100% 20% class worth on both then 75% class grade.
    *
    * @param int student_id
    * @return to.method.call  
    */
    public function update_student_grades(int $student_id) {
        //Gets all of the students classes.
        $classes = \DB::table('classes')
        ->select('classes.id', 'classes.name', 'student_class.grade', 'student_class.attendance')
        ->from('classes')
        ->join('student_class', 'student_class.class_id', '=', 'classes.id')
        ->join('users', 'users.id', '=', 'student_class.student_id')
        ->where('users.id', $student_id)
        ->get();

        //For all of the students classes.
        foreach($classes as $class) {
            //Gets all students assignments for the class.
            $assignments = \DB::table('assignments')
            ->select('assignments.id', 'student_assignment.percent', 'assignments.class_worth')
            ->from('assignments')
            ->join('student_assignment', 'student_assignment.assignment_id', '=', 'assignments.id')
            ->join('users', 'users.id', '=', 'student_assignment.user_id')
            ->join('classes', 'student_assignment.class_id', '=', 'classes.id')
            ->where('users.id', $student_id)
            ->where('classes.id', $class->id)
            ->get();

            //Initializing local varaibles.
            $class_grade = 0.0;
            $total_class_worth = 0.0;

            //for all assignments, add class_worth and class_grade.
            foreach($assignments as $assignment) {
                if($assignment->percent == 0)
                    continue;
                $total_class_worth += $assignment->class_worth;
                $class_grade += ($assignment->percent * ($assignment->class_worth/100));
            }

            //Update class grade by total class worth for current overall grade.
            if($total_class_worth != 0)
                \DB::table('student_class')
                    ->where('class_id', $class->id)
                    ->where('student_id', $student_id)
                    ->update([
                        'grade' => (($class_grade / $total_class_worth) * 100)
                    ]);
        }

        return;
    }
}
