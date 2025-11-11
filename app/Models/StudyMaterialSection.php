<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterialSection extends Model
{
    use HasFactory;

    protected $table = 'study_material_sections';

    protected $fillable = [
        'study_material_id',
        'title',
        'description',
    ];

    /**
     * 🔗 Relationship: Each section belongs to one Study Material.
     */
    public function studyMaterial()
    {
        return $this->belongsTo(StudyMaterial::class, 'study_material_id');
    }
}
