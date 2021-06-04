<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Form;
use App\Models\FormRisk;
use App\Models\GeneralFormDetails;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Content extends Component
{
    use WithFileUploads;

    public $form = [];
    public $newFiles = [];

    protected $listeners = [
        'riskChanged' => 'updateRisks',
    ];

    protected $rules = [
        'form.id' => '',
        'form.type' => 'required|string',
        'form.multi_user' => 'required|boolean',
        'form.user_id' => 'required',
        'form.title' => 'required|string',
        'form.location' => 'required|string',
        'form.description' => 'required|string',
        'form.control_measures' => 'required|string',
        'form.work_site' => 'required|string',
        'form.further_risks' => 'string',
        'form.disposal_methods' => 'required|string',
        'form.eye_protection' => 'required|boolean',
        'form.face_protection' => 'required|boolean',
        'form.hand_protection' => 'required|boolean',
        'form.foot_protection' => 'required|boolean',
        'form.respiratory_protection' => 'required|boolean',
        'form.other_protection' => 'string',

        //Emergencies
        'form.instructions' => 'required|boolean',
        'form.spill_neutralisation' => 'required|boolean',
        'form.eye_irrigation' => 'required|boolean',
        'form.body_shower' => 'required|boolean',
        'form.first_aid' => 'required|boolean',
        'form.breathing_apparatus' => 'required|boolean',
        'form.external_services' => 'required|boolean',
        'form.poison_antidote' => 'required|boolean',
        'form.other_emergency' => 'string',

        //Supervision
        'form.routine_approval' => 'required|boolean',
        'form.specific_approval' => 'required|boolean',
        'form.personal_supervision' => 'required|boolean',

        //Monitoring
        'form.airborne_monitoring' => 'required|boolean',
        'form.biological_monitoring' => 'required|boolean',

        //Informing
        'form.inform_lab_occupants' => 'required|boolean',
        'form.inform_cleaners' => 'required|boolean',
        'form.inform_contractors' => 'required|boolean',
        'form.inform_other' => 'string',

        //Supervisor/Guardians
        'form.supervisor_id' => '',
        'form.lab_guardian_id' => '',

        //Files
        'form.files.*' => '',

        //Risks
        // 'form.risks' => '',
        // 'form.risks.*.description' => 'string',
        // 'form.risks.*.severity' => 'required_with:form.risks.*.description|string',
        // 'form.risks.*.control_measures' => 'string',
        // 'form.risks.*.likelihood_with' => 'string',
        // 'form.risks.*.likelihood_without' => 'string',

        //General form
        'form.general.chemicals_involved' => '',
    ];

    protected $messages = [
        'form.title.required' => 'Please provide a title'
    ];

    public function render()
    {
        return view('livewire.form.partials.content');
    }

    public function updateRisks($risks)
    {
        $this->form['risks'] = $risks;
    }

    public function save()
    {
        $this->emit('validate');
        // $this->validate();

        // $form = Form::updateOrCreate(
        //     [
        //     'id' => $this->form['id'] ?? null],
        //     Arr::except($this->form, ['risks', 'files', 'general'])
        // );

        // foreach ($this->form['risks'] as $risk) {
        //     $risk = FormRisk::updateOrCreate([
        //         'id' => $risk['id'] ?? null,
        //         'form_id' => $form->id,
        //     ], $risk);
        // }
        // if ($form->type == 'General') {
        //     $generalSection = GeneralFormDetails::updateOrCreate(
        //         ['form_id' => $form->id,],
        //         $this->form['general']
        //     );
        // }
        //Chemical form sections
        //Biological form sections

        //foreach new file store
        //foreach removed file remove
    }
}
