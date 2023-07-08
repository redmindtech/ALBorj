<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PaymentReceivables extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "id",
        "receivables_code",
        "project_no",
        "total_amount",
        'project_cost',
        "received_amt",
        "balance_amount",
        "source",
        "cheque_no",
        "cheque_date",
        "opening_bal",
        "closing_bal",
        "item_amount",
        "vat_amount",
        "deleted"
];
protected $table = 'payment_receivables';
protected $primaryKey = 'id';
protected $fillable =
    [
        "id",
        "receivables_code",
        "project_no",
        "total_amount",
        'project_cost',
        "received_amt",
        "balance_amount",
        "source",
        "cheque_no",
        "cheque_date",
        "opening_bal",
        "closing_bal",
        "item_amount",
        "vat_amount",
        "deleted"
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($payment_receivables) {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'payment_receivables'")->AUTO_INCREMENT;
            $currentYear = substr(date('Y'), -2);
            $paymentReceivables = str_pad($results, 2, '0', STR_PAD_LEFT);
            $payment_receivables->receivables_code = 'AB' .  $currentYear.'AR'. $paymentReceivables;
            $payment_receivables->deleted = '0';
        });
    }
    public function ProjectMaster() {
        return $this->belongsTo(ProjectMaster::class,'project_no','project_no');

    }
}
