<?php

/* Old Plaid API integration*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryNotification;
use App\Inquiry;

class InquiryController extends Controller
{
  public function submitForm(Request $request)
  {
    $errorFound = false;

    if(!isset($request->name) || $request->name === "null"){
      $errors['nameError'] = 'This field is required';
      $errorFound = true;
    } else if(strlen($request->name) > 50) {
      $errors['nameError'] = 'Character limit of 50 exceeded';
      $errorFound = true;
    }
    if(!isset($request->phone) || $request->phone === "null"){
      $errors['phoneError'] = 'This field is required';
      $errorFound = true;
    }

    if(!isset($request->email) || $request->email === "null"){
      $errors['emailError'] = 'This field is required';
      $errorFound = true;
    } else if(strlen($request->email) > 50) {
      $errors['emailError'] = 'Character limit of 50 exceeded';
      $errorFound = true;
    } else if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
      $errors['emailError'] = 'Email must be a valid email';
      $errorFound = true;
    }

    if(!isset($request->message) || $request->message === "null"){
      $errors['messageError'] = 'This field is required';
      $errorFound = true;
    } else if(strlen($request->message) > 500) {
      $errors['messageError'] = 'Character limit of 500 exceeded';
      $errorFound = true;
    }

    if($errorFound) return response()->json($errors, 400);

     $inquiry = new Inquiry();
     $inquiry->name = $request->name;
     $inquiry->email = $request->email;
     $inquiry->phone = $request->phone;
     $inquiry->message = $request->message;
     $inquiry->save();

     Mail::send(new InquiryNotification());
    return response()->json(['success'=>'Data is successfully added'], 200);
  }
}
?>
