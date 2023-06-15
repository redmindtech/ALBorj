<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MaterialIssue extends Model
{
    use HasFactory;
    const REQUEST_INPUTS =
    [
        "mir_code",
        "location",
        "issue_date",
        "issue_ref_no",
        "mr_no",
        "receiving_employee",
        "remarks","project_no","type",
    ];
    protected $table ='material_issue_return';
    protected $primaryKey='mir_no';
    protected $fillable =
    [
        'mir_code','location','issue_date','issue_ref_no','receiving_employee','remarks','project_no','type','mr_no'
    ];
    protected static function booted()
    {
        parent::boot();

        static::creating(function ($materialissue)
        {
            $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'material_issue_return'")->AUTO_INCREMENT;

            $currentYear = substr(date('Y'), -2);
            $mirNo = str_pad($results, 2, '0', STR_PAD_LEFT);
            $materialissue->mir_code = 'AB'.$currentYear.'MIR' . $mirNo;
        });
    }
    public function MaterialIssueItem()
    {
        return $this->hasOne(MaterialIssueItem::class, 'mir_item_no  ', 'id');
    }

}