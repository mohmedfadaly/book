<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BookCard extends Component
{
    public $book;

    public function __construct($book)
    {
        $this->book = $book;
    }

    public function render()
    {
        return view('components.book-card');
    }
}
