<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class PartnerIndexLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $query = '';
    public $status = '';
    public function render()
    {
        $query = Project::orderBy('id', 'desc');

        if (!empty($this->query)) {
            $query->where(function ($q) {
                $q->where('project_name', 'like', '%' . $this->query . '%')
                    ->orWhere('project_id', 'like', '%' . $this->query . '%');
            });
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        $projects = $query->paginate(10)->withQueryString();

        return view('livewire.partner-index-livewire', ['projects' => $projects]);
    }
}
