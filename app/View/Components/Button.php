<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $url;
    public $btnText;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url, $btnText)
    {
        $this->url = $url;
        $this->btnText = $btnText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
