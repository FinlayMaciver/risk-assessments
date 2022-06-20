<?php

namespace App\Http\Controllers;

use App\Models\Form;

class FormController extends Controller
{
    public function archive(Form $form)
    {
        $form->archive();
        return redirect()->route('form.show', $form);
    }
}
