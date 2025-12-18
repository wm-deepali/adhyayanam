<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    use HasFactory;
    protected $table = 'header_settings';
    protected $fillable = [
        'script',
        'twitter_card',
        'og_tags',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'canonical_url',
        'company_logo',
        'contact_number',
        'email_id',
        'whatsapp_number',
        'map_embbed',
        'address',
        'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
