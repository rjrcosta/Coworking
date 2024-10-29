<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class IndexLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        
        $foreach = "";
        $labels = "";
        $rotapesquisa = "";
        $paginacao = "";
        $btns = "";
       
        

        return view('layouts.index', [
            'rotapesquisa' => $rotapesquisa,
            'labels' => $labels,
            'foreach ' => $foreach,
            'paginação' => $paginacao,
            'btnshow' => $btns,
        ]);
    }
}
