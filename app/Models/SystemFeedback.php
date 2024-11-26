<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemFeedback extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'system_feedbacks';

    protected $perPage = 25;

    protected $fillable = [
        'subject',
        'message',
        'type',
        'state',
        'send_by',
        'urgency',
        'files'
    ];

    static $rules = [
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'type' => 'required|string|max:255',
        'urgency' => 'required|string|max:255',
    ];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'send_by', 'id');
    }
}
