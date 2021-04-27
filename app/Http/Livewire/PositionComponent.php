<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use App\Models\Position;
use Livewire\Component;

class PositionComponent extends Component
{
    use WithPagination;

    public $isUpdate = false;
    public $position_id;
    public $position_code;
    public $position_name;
    public $is_modified = 0;
    public $search;

    protected $listeners = [
        'destroy'
    ];

    protected $paginationTheme = "bootstrap";

    public function create()
    {
        $this->position_id = "";
        $this->position_code = "";
        $this->position_name = "";
        $this->isUpdate = false;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();
        Position::create([
            'position_code' => $this->position_code,
            'position_name' => $this->position_name,
        ]);
        $this->resetValidation();
        $this->resetPage();
        $this->emit('positionDataChange', 'Success create data');
    }

    public function edit($id)
    {
        $this->position_id = $id;
        $data = Position::find($id);
        $this->position_code = $data->position_code;
        $this->position_name = $data->position_name;
        $this->isUpdate = true;
        $this->resetValidation();
    }

    public function update()
    {
        $data = Position::find($this->position_id);
        $data->position_code = $this->position_code;
        $data->position_name = $this->position_name;
        $data->save();
        $allData = $this->read();
        $this->resetValidation();
        $this->gotoPage($allData->currentPage());
        $this->emit('positionDataChange', 'Success update data');
    }

    public function destroy($id)
    {
        Position::destroy($id);
        $allData = $this->read();
        if ($allData) {
            $this->gotoPage($allData->currentPage());
        } else {
            $this->resetPage();
        }
        $this->emit('positionDataChange', 'Success delete data');
    }

    public function rules()
    {
        return [
            'position_name' => 'required'
        ];
    }

    private function read()
    {
        if ($this->search) {
            return Position::where('position_code', 'like', '%' . $this->search . '%')
                ->orWhere('position_name', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(5);
        } else {
            return Position::orderBy('position_id', 'desc')
                ->paginate(5);
        }
    }

    public function render()
    {
        return view('livewire.position', [
            'data' => $this->read(),
            'count_data' => Position::count(),
        ])->layout('layouts.template');
    }
}
