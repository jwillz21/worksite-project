<?php

/* Old Plaid API integration*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InquiriesController extends Controller
{
  public function submitForm(Request $request)
  {
    $contact = new contact();
    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->phone = $request->phone;
    $contact->message = $request->price;

    $contact->save();
    return response()->json(['success'=>'Data is successfully added']);
  }
}
?>
