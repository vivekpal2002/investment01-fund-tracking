<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BudgetCard extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $value;
    public $icon;
    public $color;

    public function __construct($title, $value, $icon = 'fi fi-rr-dollar', $color = 'primary')
    {
        $this->title = $title;
        $this->value = $value;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.budget-card');
    }
}
