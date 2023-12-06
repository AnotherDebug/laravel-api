<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:20',
            'date_start' => 'required|date',
            'description' => 'required|max:500',
            //'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Inserire il nome di un Progetto',
            'name.min' => 'Il nome del Progetto deve contenere almeno 3 caratteri',
            'name.max' => 'Il nome del Progetto deve contenere meno di 20 caratteri',
            'date_start.required' => 'E\' richiesta la data di inizio del progetto',
            'date_start.date' => 'Inserisci una data valida per la data di inizio del progetto',
            'description.required' => 'E\' richiesta la descrizione del Progetto',
            'description.max' => 'La descrizione del Progetto deve contenere meno di 500 caratteri',
            //'image.image' => 'Inserisci una immagine valida',
            //'image.mimes' => 'Inserisci una immagine valida di tipo jpeg, png, jpg, gif o svg',
        ];
    }
}
