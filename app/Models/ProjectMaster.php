<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectMaster extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
            "site_no",
            "project_name",
            "project_type",
            'project_code',
            "project_comments",
            "employee_no",
            "client_no",
            "consultant_name",
            "start_date",
            "end_date",
            "actual_project_end_date",
            "status",
            "total_price_cost",
            "advanced_amount",
            "amount_type",
            "retention_type",
            "retention",
            "amount_to_be_received",
            "amount_return",
            "amount_return_date",
            "amount_returns_comment"
    ];
    protected $table = 'project_masters';
    protected $primaryKey = 'project_no';
    protected $fillable =
        [
            'site_no',
            'project_name',
            'project_type',
             'project_code',
            'project_comments',
            'employee_no',
            'client_no',
            'consultant_name',
            'start_date',
            'end_date',
            'actual_project_end_date',
            'status',
            'total_price_cost',
            'advanced_amount',
            'amount_type',
            'retention_type',
            'retention',
            'amount_to_be_received',
            'amount_return',
            'amount_return_date',
            'amount_returns_comment'
        ];
        public function EmployeeMaster() {
            return $this->belongsTo(EmployeeMaster::class,'employee_no','id');

        }
        public function ClientMaster() {
            return $this->belongsTo(ClientMaster::class,'client_no','client_no');

        }
        public function SiteMaster() {
            return $this->belongsTo(SiteMaster::class,'site_no','site_no');

        }
        protected static function booted()
        {
            parent::boot();
            static::creating(function ($project) {
                $results = DB::selectOne("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'project_masters'")->AUTO_INCREMENT;
                $currentYear = substr(date('Y'), -2);
                $projectNo = str_pad($results, 2, '0', STR_PAD_LEFT);
                $project->project_code = 'PR' . $currentYear . $projectNo;
            });
        }

}