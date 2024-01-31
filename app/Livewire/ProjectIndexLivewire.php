<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectIndexLivewire extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $query = '';
    public function render()
    {
        $query = Project::orderBy('id', 'desc');
        if (!empty($this->query)) {
            $query = Project::where('project_name', 'like', '%' . $this->query . '%')->orWhere('project_id', 'like', '%' . $this->query . '%')->orderBy('id', 'desc');
        }
        $projects = $query->paginate(10)->withQueryString();
        return view('livewire.project-index-livewire', ['projects' => $projects]);
    }
}
