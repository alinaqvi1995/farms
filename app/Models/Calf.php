<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calf extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'mother_id', 'farm_id', 'tag_number', 'gender',
        'birth_date', 'birth_weight', 'current_weight',
        'weaning_date', 'notes', 'created_by'
    ];

    protected $casts = [
        'weaning_date' => 'datetime',
    ];

    public function mother()
    {
        return $this->belongsTo(Animal::class, 'mother_id');
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
