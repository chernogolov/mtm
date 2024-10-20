<?php

namespace Chernogolov\Mtm\View;

use Illuminate\View\Component;
use Illuminate\View\View;

class TrixInput extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('mtm::components.trix-input');
    }
}
