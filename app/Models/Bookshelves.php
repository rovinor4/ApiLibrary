<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookshelves extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ["id"];

    public function Book()
    {
        return $this->hasMany(Book::class, "bookshelf_id", "id");
    }
}
