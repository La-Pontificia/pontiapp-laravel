<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'reports';

    protected $perPage = 25;

    protected $fillable = ['id', 'title', 'fileUrl', 'ext', 'downloadLink', 'generatedBy', 'module'];

    protected $keyType = 'string';

    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class, 'id',  'generatedBy');
    }
}
