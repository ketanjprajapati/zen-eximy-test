<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $table = 'invoice_details';

    protected $fillable = ['invoice_id', 'product_id', 'rate', 'unit', 'qty', 'disc_percentage', 'net_amount', 'total_amount'];

    public function invoice()
    {
        return $this->belongsTo(InvoiceMaster::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductMaster::class, 'product_id');
    }
}
