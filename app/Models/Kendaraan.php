<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{

    protected $table= 'kendaraans';
    protected $primaryKey = 'id_kendaraans';
    protected $fillable = ['nomor_kendaraan','tipe_kendaraan'];

    public function sewa(): HasMany {
        return $this->hasMany(related: Sewa::class);
    }


}
