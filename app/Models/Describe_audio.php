<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Describe_audio extends Model
{
    use HasFactory;
    protected $table = 'describe_audio';
    protected $primaryKey = 'id';
    
    public function file(){
        return $this->hasOne(Uploaded_files::class, 'id', 'file_id');
    }
}
