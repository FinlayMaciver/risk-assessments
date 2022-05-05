<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Form;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Content extends Component
{
    use WithFileUploads;

    public Form $form;
    public $supervisor;
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
        $this->coshhSection = $form->coshhSection;
        $this->supervisor = $form->supervisor;
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
        'updateSubstanceHazards',
        'updateSubstanceRoutes',
        'updateMicroOrganismRoutes',
    ];

    protected $rules = [
        'form.multi_user' => 'boolean',
        'form.user_id' => 'required',
        'form.title' => 'required|string',
        'form.management_unit' => 'required|string',
        'form.location' => 'required|string',
        'form.review_date' => 'required|date',
        'form.description' => 'required|string',
        'form.type' => 'required|string',

        //COSHH
        'coshhSection.control_measures' => 'string|nullable',
        'coshhSection.work_site' => 'string|nullable',
        'coshhSection.further_risks' => 'string|nullable',
        'coshhSection.disposal_methods' => 'string|nullable',
        'coshhSection.eye_protection' => 'boolean|nullable',
        'coshhSection.face_protection' => 'boolean|nullable',
        'coshhSection.hand_protection' => 'boolean|nullable',
        'coshhSection.foot_protection' => 'boolean|nullable',
        'coshhSection.respiratory_protection' => 'boolean|nullable',
        'coshhSection.other_protection' => 'string|nullable',

        //Emergencies
        'coshhSection.instructions' => 'boolean|nullable',
        'coshhSection.spill_neutralisation' => 'boolean|nullable',
        'coshhSection.eye_irrigation' => 'boolean|nullable',
        'coshhSection.body_shower' => 'boolean|nullable',
        'coshhSection.first_aid' => 'boolean|nullable',
        'coshhSection.breathing_apparatus' => 'boolean|nullable',
        'coshhSection.external_services' => 'boolean|nullable',
        'coshhSection.poison_antidote' => 'boolean|nullable',
        'coshhSection.other_emergency' => 'string|nullable',

        //Supervision
        'coshhSection.routine_approval' => 'boolean|nullable',
        'coshhSection.specific_approval' => 'boolean|nullable',
        'coshhSection.personal_supervision' => 'boolean|nullable',

        //Monitoring
        'coshhSection.airborne_monitoring' => 'boolean|nullable',
        'coshhSection.biological_monitoring' => 'boolean|nullable',

        //Informing
        'coshhSection.inform_lab_occupants' => 'boolean|nullable',
        'coshhSection.inform_cleaners' => 'boolean|nullable',
        'coshhSection.inform_contractors' => 'boolean|nullable',
        'coshhSection.inform_other' => 'string|nullable',

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
    ];

    protected $messages = [
        'form.title.required' => 'Please provide a title',
        'form.management_unit.required' => 'Please provide a management unit',
        'form.location.required' => 'Please provide a location',
        'form.review_date.required' => 'Please provide a review date',
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


        //Substances - Chemical or Biological
        if ($form->type == 'Chemical' || $form->type == 'Biological') {
            $form->addCoshhSection($this->coshhSection);
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

        if ($form->supervisor) {
            $form->supervisor->notify(new FormSubmitted($form));
        }

        session()->flash('success_message', 'Saved form');
        return redirect()->route('home');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
}
