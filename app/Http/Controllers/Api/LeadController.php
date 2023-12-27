<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lead;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContact;

class LeadController extends Controller
{
    //dati in arrivo dal form del client
    public function store(Request $request)
    {
        //dati dal client
        $data = $request->all();

        //validazione dei dati
        $validator = Validator::make($data, [
            'name' => 'required|min:2|max:255',
            'email' => 'required|min:2|max:255',
            'message' => 'required|max:255'
        ],
        [
            'name.required' => 'Il nome è obbligatorio',
            'name.min' => 'Il nome deve avere almeno 2 caratteri',
            'name.max' => 'Il nome deve avere meno di 255 caratteri',
            'email.required' => 'l\'indirizzo email è obbligatorio',
            'email.min' => 'l\'indirizzo email deve avere almeno 2 caratteri',
            'email.max' => 'l\'indirizzo email deve avere meno di 255 caratteri',
            'message.required' => 'Il messaggio è obbligatorio',
            'message.max' => 'Il messaggio deve essere minore di 255 caratteri'
        ]
        );

        //in caso di vadi invalidi restituisco il messaggio di errore, quindi $success = false
        if ($validator->fails()) {

            $success = false;
            $errors = $validator->errors();

            return response()->json(compact('success', 'errors'));

        };

        //se non ci sono errori salvo i dati nel db
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        //Invio la mail
        Mail::to('info@boolpress.com')->send(new NewContact($new_lead));

        //restituisco $success = true
        $success = true;

        return response()->json(compact('success'));
    }
}
