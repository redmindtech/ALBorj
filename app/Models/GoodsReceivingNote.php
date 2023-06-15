<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsReceivingNote extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [
        
        "grn_code",
        "grn_date",
        "po_no",
        "project_no",
        "supplier_no",    
        "po_date", 
        "grn_purchase_type",
        "due_Date",
        
        "misc_expenses",        
        "freight",
        "dis_type",
        "vat",
        "remarks",
        "filename",
        "attachments",
        "gross_amount",
        "total_amount",
        "discount_amount",
        "grn_invoice_no",
        "vat_amount",
        "discount",
        "deleted"
        
    ];
    protected $table ='goods_received_note';
    protected $primaryKey='grn_no';
    protected $fillable =
    [
        "grn_code",
        "grn_date",
        "po_no",
        "project_no",
        "supplier_no",    
        "po_date", 
        "grn_purchase_type",
        "due_Date",
        
        "misc_expenses",    
        "freight",
        "dis_type",
        "vat",
        "remarks",
        "filename",
        "attachments",
        "gross_amount",
        "total_amount",
        "discount_amount",
        "grn_invoice_no",
        "vat_amount",
        "discount",
        "deleted"
        
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($grn) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES 
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'goods_received_note'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $grnNo = str_pad($results, 3, '0', STR_PAD_LEFT);
            $grn->grn_code = 'AB' .  $currentYear. 'GRN' . $grnNo;
            $grn->deleted='0';
            
        });
    }
}