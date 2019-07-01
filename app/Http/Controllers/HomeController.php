<?php

namespace App\Http\Controllers;

use App\Person;
use App\PlusOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $validator = Validator::make($request->all(), [
            'full_name' => 'string|min:3|required',
            'it_number' => 'string|min:9|max:11|required',
            'grad_year' => 'numeric|min:2000|max:2020|required',
            'grad_month' => ['required', Rule::in(['march', 'august'])],
            'personal_email' => 'email|required',
            'work_email' => 'email|nullable',
            'phone' => 'string|size:10|required',
            'is_plus_one' => ['sometimes', Rule::in(['on'])],
            'total_amount' => 'numeric|min:3000|max:6000|required'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $err) {
                toastr()->error($err);
            }
            return back()->withInput($request->all());
        }
        $person = Auth::user()->person;
        if ($person instanceof Person) {
            $person->fill($request->all());
            $person->save();
            toastr()->success('Your details saved successfully!');
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
        $validator = Validator::make($request->all(), [
            'full_name' => 'string|min:3|required',
            'nic' => 'string|min:9|max:15|required'
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $err) {
                toastr()->error($err);
            }
            return back();
        }
        $plusOne = Auth::user()->person->plusOne;
        if ($plusOne instanceof PlusOne) {
            $plusOne->fill($request->all());
            $plusOne->save();
            toastr()->success('Your Plus One\'s details saved successfully!');
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
        $validator = Validator::make($request->all(), [
            'slipUpload' => 'image|required'
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return back();
        }
        $path = Storage::putFile('public', $request->file('slipUpload'));
        $person = Auth::user()->person;
        $person->pay_slip_filename = str_replace('public/', '', $path);
        $person->save();
        toastr()->success('Payment slip uploaded successfully!');
        return back();
    }

}
