<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Kriteria extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'kriteria';

    protected $fillable = ['nama_kriteria', 'sifat_kriteria'];
    protected $guarded = [''];
    protected $ignoreChangedAttributes = ['updated_at'];

    public function getActivitylogAttributes(): array
    {
        return array_diff($this->fillable, $this->ignoreChangedAttributes);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logUnguarded()->logOnlyDirty();
    }

    // App\Models\Kriteria.php
    public function bobotKriteria()
    {
        return $this->hasOne(BobotKriteria::class, 'id_kriteria');
    }

}
