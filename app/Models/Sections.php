<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClassModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sections extends Model
{
    use HasFactory;

    protected $table = 'sections';

    protected $fillable = [
        'class_id',
        'name',
        'capacity',
        'status',
    ];

    protected $casts = [
        'class_id' => 'integer',
        'capacity' => 'integer',
        'status' => 'boolean',
    ];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }


    public function students()
    {
        return $this->hasMany(Student::class, 'student_id');
    }
}
