<?php

namespace App\Http\Livewire\Concerns;

use App\Models\Form;
use Livewire\WithPagination;

trait CanFilterForms
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $multiFilter = '';
    public $expiresInDays = '';
    public $authUserOnly = '0';
    public $signedUserOnly = '0';
    public $inReviewers = '0';
    public $orderBy = [
        'column' => 'forms.created_at',
        'order' => 'asc',
    ];

    protected $queryStringCanFilterForms = [
        'statusFilter' => ['except' => ''],
        'expiresInDays' => ['except' => ''],
        'authUserOnly' => ['except' => '0'],
        'signedUserOnly' => ['except' => '0'],
        'inReviewers' => ['except' => '0'],
    ];

    protected function findAllMatchingForms()
    {
        if (strlen(trim($this->search)) > 2) {
            return $this->getFormsViaScout();
        }

        return $this->getFormsViaEloquent();
    }

    protected function getFormsViaScout()
    {
        return Form::search($this->search)
            ->query(function ($query) {
                return $query->current();
            })
            ->get()
            ->when(
                $this->multiFilter !== '',
                fn ($forms) => $forms->filter(
                    fn ($form) => $form->multi_user == $this->multiFilter
                )
            )
            ->when(
                $this->statusFilter !== '',
                fn ($forms) => $forms->filter(
                    fn ($form) => $form->status == $this->statusFilter
                )
            )
            ->when(
                $this->inReviewers,
                fn ($forms) => $forms->filter(
                    fn ($form) => $form->supervisor_id == auth()->id() || $form->reviewers->pluck('id')->contains(
                        auth()->id()
                    )
                )
            )
            ->when(
                $this->authUserOnly,
                fn ($forms) => $forms->filter(fn ($form) => $form->user_id == auth()->id())
            )
            ->when($this->expiresInDays > 0, fn ($forms) => $forms->filter(
                fn ($form) => $form->review_date->diffInDays(now()) <= $this->expiresInDays &&
                    $form->review_date->isAfter(now())
            ))
            ->sortBy([$this->orderBy['column'], $this->orderBy['order']])
            ->load(['user', 'users', 'supervisor'])
            ->when(
                $this->signedUserOnly,
                fn ($forms) => $forms->filter(fn ($form) => $form->users->pluck('id')->contains(auth()->id()))
            );
    }

    protected function getFormsViaEloquent()
    {
        return Form::current()->with(['user', 'supervisor'])
                ->when(
                    $this->statusFilter !== '',
                    fn ($query) => $query->where('status', $this->statusFilter)
                )
                ->when(
                    $this->multiFilter !== '',
                    fn ($query) => $query->where('multi_user', $this->multiFilter)
                )
                ->when(
                    $this->inReviewers,
                    fn ($query) =>
                            $query->whereHas('reviewers', fn ($q) => $q->where('user_id', auth()->user()->id))
                                ->orWhere('supervisor_id', auth()->user()->id)
                )
                ->when(
                    $this->authUserOnly,
                    fn ($query) => $query->where('user_id', '=', auth()->id())
                )
                ->when(
                    $this->signedUserOnly,
                    fn ($query) => $query->whereHas('users', fn ($q) => $q->where('user_id', auth()->user()->id))
                )
                ->when(
                    $this->expiresInDays > 0,
                    fn ($query) => $query->where('review_date', '>=', now())->where('review_date', '<=', now()->addDays($this->expiresInDays))
                )
                ->orderBy(
                    $this->orderBy['column'],
                    $this->orderBy['order']
                )->get();
    }

    public function toggleSort($column)
    {
        $this->resetPage();
        if ($this->orderBy['column'] == $column) {
            $this->orderBy['order'] = $this->orderBy['order'] == 'asc' ? 'desc' : 'asc';
        } else {
            $this->orderBy['column'] = $column;
            $this->orderBy['order'] = 'asc';
        }
    }
}
