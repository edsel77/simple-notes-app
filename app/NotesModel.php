<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotesModel extends Model
{
    protected $table = 'notes';

    protected $fillable = [
        'note'
    ]; 
}
