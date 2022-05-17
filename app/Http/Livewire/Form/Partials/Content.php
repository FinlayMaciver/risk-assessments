<?php

namespace App\Http\Livewire\Form\Partials;

use App\Models\Form;
use App\Models\Impact;
use App\Models\Likelihood;
use App\Models\MicroOrganism;
use App\Models\Risk;
use App\Models\Substance;
use App\Models\User;
use App\Notifications\FormSubmitted;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Content extends Component
{
    use WithFileUploads;

    public Form $form;
    public $supervisor;
    public $coshhSection;
    public $reviewers = [];
    public $reviewerIds = [];
    public Collection $risks;
    public Collection $substances;
    public Collection $microOrganisms;
    public $files;
    public $newFiles = [];
    public $valid = true;
    public $likelihoods = [];
    public $impacts = [];

    public function mount(Form $form)
    {
        $this->form = $form;
        $this->coshhSection = $form->coshhSection;
        $this->supervisor = $form->supervisor;
        $this->reviewers = $form->reviewers->toArray();
        $this->risks = $form->risks;
        $this->substances = $form->substances;
        $this->microOrganisms = $form->microOrganisms;
        $this->files = $form->files;
        $this->substances->each(fn ($substance) => $substance->hazard_ids = $substance->hazards->pluck('id'));
        $this->substances->each(fn ($substance) => $substance->route_ids = $substance->routes->pluck('id'));
        $this->microOrganisms->each(fn ($substance) => $substance->route_ids = $substance->routes->pluck('id'));
        $this->likelihoods = Likelihood::all();
        $this->impacts = Impact::all();
    }

    protected $listeners = [
        'reviewerUpdated',
        'reviewerDeleted',
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
        'risks.*.hazard' => 'required',
        'risks.*.consequences' => 'required',
        'risks.*.likelihood_without' => 'required',
        'risks.*.impact_without' => 'required',
        'risks.*.control_measures' => 'required_with:risks.*.hazard',
        'risks.*.likelihood_with' => 'required',
        'risks.*.impact_with' => 'required',
        'risks.*.comments' => 'string|nullable',

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

        //Supervisor
        'form.supervisor_id' => '',
    ];

    protected $messages = [
        'form.title.required' => 'Please provide a title',
        'form.management_unit.required' => 'Please provide a management unit',
        'form.location.required' => 'Please provide a location',
        'form.review_date.required' => 'Please provide a review date',
        'form.description.required' => 'Please provide a description',

        'risks.*.hazard.required' => 'Please provide a description of the hazard',
        'risks.*.consequences.required' => 'Please provide a description of the consequences',
        'risks.*.likelihood_without.required' => 'Please select a likelihood',
        'risks.*.impact_without.required' => 'Please select an impact',
        'risks.*.control_measures.required_with' => 'Please provide control measures',
        'risks.*.likelihood_with.required' => 'Please select a likelihood',
        'risks.*.impact_with.required' => 'Please select an impact',

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

    public function updateRiskRating($index)
    {
        if ($this->risks[$index]->likelihood_without && $this->risks[$index]->impact_without) {
            $risk_rating_without = $this->getRiskRating($this->risks[$index]->likelihood_without, $this->risks[$index]->impact_without);
            $this->risks[$index]->risk_rating_without = $risk_rating_without;
            $this->risks[$index]->blurb_without = $this->getRiskBlurb($risk_rating_without);
        }
        if ($this->risks[$index]->likelihood_with && $this->risks[$index]->impact_with) {
            $risk_rating_with = $this->getRiskRating($this->risks[$index]->likelihood_with, $this->risks[$index]->impact_with);
            $this->risks[$index]->risk_rating_with = $risk_rating_with;
            $this->risks[$index]->blurb_with = $this->getRiskBlurb($risk_rating_with);
        }
    }

    public function getRiskRating($likelihood, $impact)
    {
        return Likelihood::find($likelihood)->value * Impact::find($impact)->value;
    }

    public function getRiskBlurb($rating)
    {
        if ($rating <= 2) {
            return 'Very Low Risk: No further action is usually required but ensure that existing controls are maintained and reviewed regularly';
        } elseif ($rating <= 6) {
            return 'Low Risk: Look to improve at the next review or if there is a significant change. Monitor the situation periodically to determine if new control measures are required';
        } elseif ($rating <= 12) {
            return 'Moderate Risk: Moderate risks may be tolerated for short periods while further control measures to reduce the risk are being planned and implemented. Improvements should be made within the specified timescale, if these are possible.';
        } elseif ($rating <= 16) {
            return 'High Risk: Take immediate action and stop the activity if necessary, maintain existing controls rigorously. The continued effectiveness of control measures should be monitored periodically.';
        } else {
            return 'Very High Risk: Stop the activity and take immediate action to reduce the risk, a detailed plan should be developed and implemented before work commences or continues. Senior management should monitor the plan.';
        }
    }

    public function addReviewer()
    {
        $this->reviewers[] = new User();
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

    public function reviewerUpdated(User $reviewer, $index)
    {
        $this->reviewers[$index] = $reviewer;
        $this->reviewerIds[] = $reviewer->id;
    }

    public function reviewerDeleted($reviewer, $index)
    {
        unset($this->reviewers[$index]);
        if ($reviewer) {
            $this->reviewerIds = array_diff($this->reviewerIds, [$reviewer['id']]);
        }
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

        //Reviewers
        $form->reviewers()->sync($this->reviewerIds);

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
