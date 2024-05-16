<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters) {
        $query->when($filters['tag'] ?? false, function($query, $tag) {
            return $query->where('tags', 'like', '%' . $tag . '%');
        });
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%');
        });
    }
}
