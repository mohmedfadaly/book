<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    protected $table = 'borrowed_books';
    protected $fillable = [
        'book_id',
        'borrowable_id',
        'borrowable_type',
    ];
    public function borrowable()
    {
        return $this->morphTo();
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
