<?php

namespace Cachet\View\Components;

use Carbon\CarbonInterface;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Timestamp extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public readonly CarbonInterface $timestamp)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('cachet::components.timestamp');
    }
}
