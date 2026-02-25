<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Comment;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'open',
        'priority' => 'medium',
    ];

    /**
     * Ticket belongs to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ticket has many Comments
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope filter status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope filter priority
     */
    public function scopePriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Status badge accessor
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'open' => 'bg-warning',
            'in_progress' => 'bg-info',
            'closed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Priority badge accessor
     */
    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => 'bg-secondary',
            'medium' => 'bg-primary',
            'high' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}