<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Kendaraan;

class Sewa extends Model
{
    //
    protected $table = 'sewas';
    protected $primaryKey = 'id_sewas';
    protected $fillable = ['id_kendaraans','nama_customer','tanggal_mulai_sewa','tanggal_berakhir_sewa','harga_sewa'];
    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraans', 'id_kendaraans');
    }


}
