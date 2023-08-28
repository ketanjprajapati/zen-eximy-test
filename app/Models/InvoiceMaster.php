<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceMaster extends Model
{
    use HasFactory;
    protected $table = 'invoice_masters';

    protected $fillable = ['invoice_no', 'invoice_date', 'customer_name', 'total_amount'];
    public function invoiceDetails()
{
    return $this->hasMany(InvoiceDetail::class, 'invoice_id');
}

}
