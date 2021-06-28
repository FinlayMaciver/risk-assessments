<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Form;
use App\Models\GeneralFormDetails;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Content extends Component
{
    use WithFileUploads;

    public Form $form;
    public $supervisor;
    public $labGuardian;
    public $risks;
    public $substances;
    public $section;
    public $files;
    public $newFiles = [];

    public function mount(Form $form)
    {
        $this->form = $form;
        $this->supervisor = $form->supervisor;
        $this->labGuardian = $form->labGuardian;
        $this->section = $form->{Str::lower($form->type).'Section'};
        $this->substances = $form->substances;
        $this->risks = $form->risks;
        $this->files = $form->files;
    }

    protected $listeners = [
        'risksUpdated',
        'supervisorUpdated',
        'labGuardianUpdated',
        'substancesUpdated'
    ];

    protected $rules = [
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

        //Risks
        'risks.*.description' => 'string',
        'risks.*.severity' => 'string',
        'risks.*.control_measures' => 'string',
        'risks.*.likelihood_with' => 'string',
        'risks.*.likelihood_without' => 'string',

        //General section
        'section.chemicals_involved' => 'string',

        // Substances
        'substances.*.substance' => 'string',
        'substances.*.quantity' => 'string',
        'substances.*.single_acute_effect' => 'string',
        'substances.*.repeated_low_effect' => 'string',
        'substances.*.hazard_ids' => '',
        'substances.*.route_ids' => '',

        //Supervisor + lab guardian
        'form.supervisor_id' => '',
        'form.lab_guardian_id' => '',
    ];

    protected $messages = [
        'form.title.required' => 'Please provide a title'
    ];

    public function render()
    {
        return view('livewire.form.partials.content');
    }

    public function risksUpdated($risks)
    {
        $this->risks = $risks;
    }

    public function substancesUpdated($substances)
    {
        $this->substances = $substances;
    }

    public function supervisorUpdated(User $user)
    {
        $this->form->supervisor_id = $user->id;
    }

    public function labGuardianUpdated(User $user)
    {
        $this->form->lab_guardian_id = $user->id;
    }

    public function save()
    {
        $this->validate();

        $form = Form::updateOrCreate(
            ['id' => $this->form['id'] ?? null],
            $this->form->attributesToArray()
        );

        //Risks
        foreach ($this->risks as $risk) {
            $id = $form->risks()->updateOrCreate(['id' => $risk->id], $risk->attributesToArray());
        }

        foreach ($this->form->risks->diff($this->risks) as $deletedRisk) {
            $deletedRisk->delete();
        }

        //General
        if ($form->type == 'General') {
            $generalSection = GeneralFormDetails::updateOrCreate(
                ['form_id' => $form->id],
                ['chemicals_involved' => $this->section['chemicals_involved']]
            );
        }

        //Chemical
        if ($form->type == 'Chemical') {
            foreach ($this->substances as $substance) {
                $savedSubstance = $form->substances()->updateOrCreate(['id' => $substance->id], $substance->makeHidden(['hazard_ids', 'route_ids'])->attributesToArray());
                $savedSubstance->hazards()->sync($substance->hazard_ids);
            }
            foreach ($this->form->substances->diff($this->substances) as $deletedSubstance) {
                $deletedSubstance->delete();
            }
        }

        //Biological

        //Files

        //foreach new file store
        //foreach removed file remove
    }
}
