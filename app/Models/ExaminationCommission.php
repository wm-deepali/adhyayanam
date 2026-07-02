<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExaminationCommission extends Model
{
    use HasFactory;

    protected $table = 'examination_commission';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'canonical_url',
        'image',
        'alt_tag',
        'status',
        'created_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commission) {
            if (empty($commission->slug)) {
                $commission->slug = self::generateUniqueSlug($commission->name);
            }
        });

        static::updating(function ($commission) {
            if ($commission->isDirty('name')) {
                $commission->slug = self::generateUniqueSlug(
                    $commission->name,
                    $commission->id
                );
            }
        });
    }

    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 1;

        while (
            self::where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'exam_com_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'exam_com_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'examination_commission_id');
    }
}