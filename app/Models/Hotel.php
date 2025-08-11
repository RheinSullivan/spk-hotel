<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Hotel extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'hotels';

    protected $fillable = ['nama_hotel', 'alamat', 'rating', 'fasilitas', 'harga', 'deskripsi'];
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

    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_hotel');
    }
}
