<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploaded_files extends Model
{
    use HasFactory;
    protected $table = 'uploaded_files';
    protected $primaryKey = 'id';
}
