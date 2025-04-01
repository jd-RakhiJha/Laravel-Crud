<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\Sections;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'dob',
        'class_id',
        'section_id',
    ];

    protected $casts = [
        'dob' => 'date',
        'class_id' => 'integer',
        'section_id' => 'integer',
    ];

    /**
     * Relationship with Classes
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Relationship with Sections
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }
}
