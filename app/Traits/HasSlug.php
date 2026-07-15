<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug();
            }
        });

        static::updating(function ($model) {
            $sourceField = $model->slugSourceField();

            // agar slug manually clear kiya gaya ya source field (name/title) change hua aur slug already us purane source se match karta tha
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }

    /**
     * Model apna source field define karega (e.g. 'name' ya 'title')
     */
    public function slugSourceField(): string
    {
        return property_exists($this, 'slugSource') ? $this->slugSource : 'name';
    }

    public function generateUniqueSlug(): string
    {
        $source = $this->{$this->slugSourceField()};
        $baseSlug = Str::slug($source);
        $slug = $baseSlug;
        $counter = 1;

        $query = static::where('slug', $slug);
        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        while ($query->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;

            $query = static::where('slug', $slug);
            if ($this->exists) {
                $query->where($this->getKeyName(), '!=', $this->getKey());
            }
        }

        return $slug;
    }
}