<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                $results = ProjectMaster::max('project_no');
                info($results);
                $currentYear = substr(date('Y'), -2);
                if ($results > 0) {
                    $project->project_code = 'PR' .  $currentYear. '0' . ($results +1 );
                } else {
                    $project->project_code = 'PR' .  $currentYear.'0' .'1';
                }
                
    
    
            });
        }

}