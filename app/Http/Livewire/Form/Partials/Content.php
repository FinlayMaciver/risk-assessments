<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Form;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
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
    public $section = [];
    public $users = [];
    public $userIds = [];
    public Collection $risks;
    public Collection $substances;
    public Collection $microOrganisms;
    public $files;
    public $newFiles = [];
    public $valid = true;

    public function mount(Form $form)
    {
        $this->form = $form;
        $this->supervisor = $form->supervisor;
        $this->labGuardian = $form->labGuardian;
        $this->section = $form->{Str::lower($form->type).'Section'};
        $this->users = $form->users->toArray();
        $this->risks = $form->risks;
        $this->substances = $form->substances;
        $this->microOrganisms = $form->microOrganisms;
        $this->files = $form->files;
        $this->substances->each(fn ($substance) => $substance->hazard_ids = $substance->hazards->pluck('id'));
        $this->substances->each(fn ($substance) => $substance->route_ids = $substance->routes->pluck('id'));
        $this->microOrganisms->each(fn ($substance) => $substance->route_ids = $substance->routes->pluck('id'));
    }

    protected $listeners = [
        'userUpdated',
        'userDeleted',
        'supervisorUpdated',
        'labGuardianUpdated',
        'updateSubstanceHazards',
        'updateSubstanceRoutes',
        'updateMicroOrganismRoutes'
    ];

    protected $rules = [
        'form.type' => 'required|string',
        'form.multi_user' => 'boolean',
        'form.user_id' => 'required',
        'form.title' => 'required|string',
        'form.location' => 'required|string',
        'form.description' => 'required|string',
        'form.control_measures' => 'string',
        'form.work_site' => 'string',
        'form.further_risks' => 'string',
        'form.disposal_methods' => 'string',
        'form.eye_protection' => 'boolean',
        'form.face_protection' => 'boolean',
        'form.hand_protection' => 'boolean',
        'form.foot_protection' => 'boolean',
        'form.respiratory_protection' => 'boolean',
        'form.other_protection' => 'string',

        //Emergencies
        'form.instructions' => 'boolean',
        'form.spill_neutralisation' => 'boolean',
        'form.eye_irrigation' => 'boolean',
        'form.body_shower' => 'boolean',
        'form.first_aid' => 'boolean',
        'form.breathing_apparatus' => 'boolean',
        'form.external_services' => 'boolean',
        'form.poison_antidote' => 'boolean',
        'form.other_emergency' => 'string',

        //Supervision
        'form.routine_approval' => 'boolean',
        'form.specific_approval' => 'boolean',
        'form.personal_supervision' => 'boolean',

        //Monitoring
        'form.airborne_monitoring' => 'boolean',
        'form.biological_monitoring' => 'boolean',

        //Informing
        'form.inform_lab_occupants' => 'boolean',
        'form.inform_cleaners' => 'boolean',
        'form.inform_contractors' => 'boolean',
        'form.inform_other' => 'string',

        //Risks
        'risks.*.risk' => 'required',
        'risks.*.severity' => 'required_with:risks.*.risk',
        'risks.*.control_measures' => 'required_with:risks.*.risk',
        'risks.*.likelihood_without' => 'required_with:risks.*.risk',
        'risks.*.likelihood_with' => 'required_with:risks.*.risk',

        //Files
        'files.*.id' => '',
        'files.*.form_id' => '',
        'files.*.filename' => '',
        'files.*.original_filename' => '',
        'files.*.mimetype' => '',
        'files.*.size' => '',

        //General section
        'section.chemicals_involved' => '',

        //Substances
        'substances.*.substance' => 'required',
        'substances.*.quantity' => 'required_with:substances.*.substance',
        'substances.*.single_acute_effect' => 'required_with:substances.*.substance',
        'substances.*.repeated_low_effect' => 'required_with:substances.*.substance',
        'substances.*.hazard_ids' => '',
        'substances.*.route_ids' => '',

        //MicroOrganisms
        'microOrganisms.*.micro_organism' => 'required',
        'microOrganisms.*.classification' => 'required_with:microOrganisms.*.micro_organism',
        'microOrganisms.*.risk' => 'required_with:microOrganisms.*.micro_organism',
        'microOrganisms.*.single_acute_effect' => 'required_with:microOrganisms.*.micro_organism',
        'microOrganisms.*.repeated_low_effect' => 'required_with:microOrganisms.*.micro_organism',
        'microOrganisms.*.route_ids' => '',

        //Supervisor + lab guardian
        'form.supervisor_id' => '',
        'form.lab_guardian_id' => '',
    ];

    protected $messages = [
        'form.title.required' => 'Please provide a title',
        'form.location.required' => 'Please provide a location',
        'form.description.required' => 'Please provide a description',

        'risks.*.risk.required' => 'Please provide a description',
        'risks.*.severity.required_with' => 'Please select a severity',
        'risks.*.control_measures.required_with' => 'Please describe control measures',
        'risks.*.likelihood_without.required_with' => 'Please select likelihood without',
        'risks.*.likelihood_with.required_with' => 'Please select likelihood with',

        'substances.*.substance.required' => 'Please provide a substance name',
        'substances.*.quantity.required_with' => 'Please select a quantity',
        'substances.*.single_acute_effect.required_with' => 'Please select the effect',
        'substances.*.repeated_low_effect.required_with' => 'Please select the effect',

        'microOrganisms.*.micro_organism.required' => 'Please provide a micro-organism name',
        'microOrganisms.*.classification.required_with' => 'Please select the hazard classification',
        'microOrganisms.*.risk.required_with' => 'Please select the risk level',
        'microOrganisms.*.single_acute_effect.required_with' => 'Please select the effect',
        'microOrganisms.*.repeated_low_effect.required_with' => 'Please select the effect',
    ];

    public function render()
    {
        return view('livewire.form.partials.content');
    }

    public function addUser()
    {
        $this->users[] = new User();
    }

    public function addRisk()
    {
        $this->risks->push(new Risk());
    }

    public function deleteRisk($index)
    {
        $this->risks->forget($index);
    }

    public function addSubstance()
    {
        $this->substances->push(new Substance());
    }

    public function deleteSubstance($index)
    {
        $this->substances->forget($index);
    }

    public function updateSubstanceHazards($hazards, $index)
    {
        $this->substances[$index]->hazard_ids = $hazards;
    }

    public function updateSubstanceRoutes($routes, $index)
    {
        $this->substances[$index]->route_ids = $routes;
    }

    public function addMicroOrganism()
    {
        $this->microOrganisms->push(new MicroOrganism());
    }

    public function deleteMicroOrganism($index)
    {
        $this->microOrganisms->forget($index);
    }

    public function updateMicroOrganismRoutes($routes, $index)
    {
        $this->microOrganisms[$index]->route_ids = $routes;
    }

    public function userUpdated(User $user, $index)
    {
        $this->users[$index] = $user;
        $this->userIds[] = $user->id;
    }

    public function userDeleted(User $user, $index)
    {
        unset($this->users[$index]);
        $this->userIds = array_diff($this->userIds, [$user->id]);
    }

    public function supervisorUpdated($user)
    {
        if ($user === null) {
            $this->form->supervisor_id = null;
            $this->valid = false;
        } else {
            $this->form->supervisor_id = $user['id'];
            $this->valid = true;
        }
    }

    public function labGuardianUpdated($user)
    {
        if ($user == null) {
            $this->form->supervisor_id = null;
            $this->valid = false;
        } else {
            $this->form->lab_guardian_id = $user['id'];
            $this->valid = true;
        }
    }

    public function save()
    {
        if ($this->validate()) {
            $this->valid = false;
        }

        $this->valid = true;
        $form = Form::updateOrCreate(
            ['id' => $this->form['id'] ?? null],
            $this->form->attributesToArray()
        );

        //Users
        if ($form->multi_user) {
            $form->users()->sync($this->userIds);
        } else {
            $form->users()->sync([]);
        }

        //Risks
        $this->risks->each(fn ($risk) => $form->updateRisk($risk));
        $deletedRisks = $this->form->risks->diff($this->risks);
        $deletedRisks->each(fn ($risk) => $risk->delete());

        //General
        if ($form->type == 'General') {
            $form->addGeneralSection($this->section);
        }

        //Substances - Chemical or Biological
        if ($form->type == 'Chemical' || $form->type == 'Biological') {
            $this->substances->each(fn ($substance) => $form->addSubstance($substance));
            $deletedSubstances = $this->form->substances->diff($this->substances);
            $deletedSubstances->each(fn ($substance) => $form->deleteSubstance($substance));
        }

        //Micro-organisms - Biological only
        if ($form->type == 'Biological') {
            $this->microOrganisms->each(fn ($microOrganism) => $form->addMicroOrganism($microOrganism));
            $deletedMicroOrganisms = $this->form->microOrganisms->diff($this->microOrganisms);
            $deletedMicroOrganisms->each(fn ($microOrganism) => $form->deleteMicroOrganism($microOrganism));
        }

        //Files
        foreach ($this->newFiles as $newFile) {
            $form->addFile($newFile);
        }
        $deletedFiles = $this->form->files->diff($this->files);
        $deletedFiles->each(fn ($file) => $form->deleteFile($file));

        session()->flash('success_message', 'Saved form');
        return redirect()->route('home');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
