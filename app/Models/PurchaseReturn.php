<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PurchaseReturn extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [
        
        "pr_no",
        "pr_code",
        "po_no",
        "supplier_no",
        "currency",    
        "po_date", 
        "invoice_no",
        "pr_purchase_type",
        "project_no",
        "return_amount",        
        "freight",
        "vat_type",
        "vat_amount",
        "deleted"
        
    ];
    protected $table ='purchase_return';
    protected $primaryKey='pr_no';
    protected $fillable =
    [
        "pr_no",
        "pr_code",
        "po_no",
        "supplier_no",
        "currency",    
        "po_date", 
        "invoice_no",
        "pr_purchase_type",
        "project_no",
        "return_amount",        
        "freight",
        "vat_type",
        "vat_amount",
        "deleted"
        
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($pr) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'purchase_return'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $pr_no = str_pad($results, 3, '0', STR_PAD_LEFT);
            $pr->pr_code = 'AB' .  $currentYear. 'PR' . $pr_no;
            $pr->deleted='0';
            
        });
    }
}
