<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceivables extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "id",
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
        "deleted"
];
protected $table = 'payment_receivables';
protected $primaryKey = 'id';
protected $fillable =
    [
        "id",
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
        "deleted"
    ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($payment_receivables) {
            $payment_receivables->deleted = '0';
        });
    }
    public function ProjectMaster() {
        return $this->belongsTo(ProjectMaster::class,'project_no','project_no');

    }
}
