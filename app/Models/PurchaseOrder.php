<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PurchaseOrder extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [
        "po_type",
        "supplier_no",
        "po_date",
        "quote_ref",
        "quote_date",
        "currency",
        "discount_type",
        "discount",
        "credit_period",
        "payment_terms",
        "delivery_location",
        "delivery_terms",
        "mr_no",
        "total_amount",
        "total_discount",
        "gross_amount",
        "remarks",
        "attachments",
        "vat",
        "total_vat",
        "po_prepared",
        "po_status",
        "deleted"
    ];
    protected $table ='purchase_order';
    protected $primaryKey='po_no';
    protected $fillable =
    [
        'po_type','supplier_no','po_date','discount','discount_type','quote_ref','quote_date','currency','credit_period','payment_terms','delivery_location','delivery_terms','mr_no','total_amount','total_discount','gross_amount','remarks','attachments','vat','total_vat','po_prepared','po_status','deleted'
    ];
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($purchaseorder)
        {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'purchase_order'")->AUTO_INCREMENT;

            $currentYear = substr(date('Y'), -2);
            $poNo = str_pad($results, 2, '0', STR_PAD_LEFT);
            $purchaseorder->po_code = 'AB'.$currentYear.'PO' . $poNo;
            $purchaseorder->deleted='0';
            $purchaseorder->po_status='0';

        });
    }
    public function PurchaseIssueItem()
    {
        return $this->hasOne(PurchaseOrderItem::class, 'po_item_no  ', 'id');
    }
}
