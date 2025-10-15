<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class CarValuationForm extends Component
{
    public $make = '';
    public $model = '';
    public $year = '';
    public $mileage = '';
    
    public $years = [];
    
    public function mount()
    {
        // Generate years array from 1960 to 2026
        $this->years = array_map(function($year) {
            return [
                'value' => $year,
                'label' => (string)$year
            ];
        }, range(2026, 1960));
    }

    public function submit()
    {
        $validated = $this->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1960|max:2026',
            'mileage' => 'required|integer|min:0',
        ]);

        return redirect()->route('car-valuation.submit')->with([
            'form_data' => $validated
        ]);
    }

    public function render()
    {
        return view('livewire.car-valuation-form');
    }
}