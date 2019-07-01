<?php

namespace App\Http\Controllers;

use App\Person;
use App\PlusOne;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $person = Auth::user()->person;
        if ($person instanceof Person) {
            $plusOne = $person->plusOne;
            $paySlipUploaded = $person->pay_slip_filename !== null;
            if ($plusOne instanceof PlusOne) {
                return view('home', [
                    'p' => $person,
                    'p1' => $plusOne,
                    'paySlipUploaded' => $paySlipUploaded
                ]);
            }
            return view('home', [
                'p' => $person,
                'paySlipUploaded' => $paySlipUploaded
            ]);
        } else {
            return view('home', ['paySlipUploaded' => false]);
        }
    }


    public function handleYourDetailsSave(Request $request) {
        $person = Auth::user()->person;
        if ($person instanceof Person) {
            $person->fill($request->all());
            $person->save();
            return back();
        }
        $newPerson = new Person();
        $newPerson->fill($request->all());
        $newPerson->is_plus_one = $request->get('is_plus_one') === 'on' ? true : false;
        Auth::user()->person()->save($newPerson);
        toastr()->success('Your details saved successfully!');
        return back();
    }

    public function handlePlusOneSave(Request $request) {
        $plusOne = Auth::user()->person->plusOne;
        if ($plusOne instanceof PlusOne) {
            $plusOne->fill($request->all());
            $plusOne->save();
            return back();
        }
        $newPlusOne = new PlusOne();
        $newPlusOne->fill($request->all());
        $person = Auth::user()->person;
        $person->plusOne()->save($newPlusOne);
        $person->is_plus_one = true;
        $person->save();
        toastr()->success('Your Plus One\'s details saved successfully!');
        return back();
    }

    public function handleSlipUpload(Request $request) {
        $path = Storage::putFile('public', $request->file('slipUpload'));
        $person = Auth::user()->person;
        $person->pay_slip_filename = str_replace('public/', '', $path);
        $person->save();
        toastr()->success('Payment slip uploaded successfully!');
        return back();
    }

}
