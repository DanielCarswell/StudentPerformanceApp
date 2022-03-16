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
    public function attendance(Request $request) {
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

    public function assignment_marks(Request $request) {
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
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    public function upload_student_accounts(Request $request) {
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
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            return redirect()->route('accounts');
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    public function upload_students(Request $request) {
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
                    ->insert([
                        'student_id' => $data[0],
                        'class_id' => $request->class_id,
                        'grade' => 100.0,
                        'attendance' => 100.0
                    ]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
            $class = Classe::find($request->class_id);
            $this->add($class);
            return redirect()->route('class.students', $class);
        } else {
            throw new \Exception('No file was uploaded', Response::HTTP_BAD_REQUEST);
        }
    }

    public function add(Classe $class) {
        $studentsUnfiltered = User::with(['classes'])->get();

        $student_ids = [];

        foreach($studentsUnfiltered as $student) {
            $count = 0;
            $check = $student->classes->count();
            foreach($student->classes as $classe) {
                if($class->id == $classe->id)
                    break;
                else if($count == $check-1)
                    array_push($student_ids, $student->id);
                else
                    $count += 1;
            }
        }

        return;
    }
}
