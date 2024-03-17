<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    //index
    public function index(Request $request)
    {
        $doctors = DB::table('doctors')
            ->when($request->input('name'), function ($query, $doctor_name) {
                return $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.doctors.index', compact('doctors'));
    }

    //create
    public function create()
    {
        return view('pages.doctors.create');
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'doctor_name' => 'required',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_email' => 'required|email',
            'sip' => 'required',
            'id_ihs' => 'required',
            'nik' => 'required',
        ]);

        $doctor = new Doctor;
        $doctor->doctor_name = $request->doctor_name;
        $doctor->doctor_specialist = $request->doctor_specialist;
        $doctor->doctor_phone = $request->doctor_phone;
        $doctor->doctor_email = $request->doctor_email;
        $doctor->sip = $request->sip;
        $doctor->id_ihs = $request->id_ihs;
        $doctor->nik = $request->nik;
        $doctor->save();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image->storeAs('public/doctors', $doctor->id . '.' . $image->getClientOriginalExtension());
            $doctor->photo = 'storage/doctors/' . $doctor->id . '.' . $image->getClientOriginalExtension();
            $doctor->save();
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor create successfully');
    }



    //show
    public function show($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.show', compact('doctor'));
    }

    //edit
    public function edit($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.edit', compact('doctor'));
    }



    //update
    public function update(Request $request, $id)

    {
        $request->validate([
            'doctor_name' => 'required',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_email' => 'required|email',
            'photo' => 'nullable|url',
            'sip' => 'required',
            'id_ihs' => 'required',
            'nik' => 'required',
        ]);

        DB::table('doctors')->where('id', $id)->update([
            'doctor_name' => $request->doctor_name,
            'doctor_specialist' => $request->doctor_specialist,
            'doctor_phone' => $request->doctor_phone,
            'doctor_email' => $request->doctor_email,
            'photo' => $request->photo,
            'sip' => $request->sip,
        ]);


        return redirect()->route('doctors.index')->with('success', 'Doctor update successfully');
    }

    //destroy
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deletes successfully');
    }
}
