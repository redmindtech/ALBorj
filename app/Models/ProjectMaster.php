<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMaster extends Model
{
    use HasFactory;
    protected $table ='project_masters';
    protected $primaryKey='project_no';
    protected $fillable =
    [
        'site_no', 'site_name', 'project_name', 'project_type', 'project_comments', 'manager_name', 'manager_contact_number', 'company_name', 'client_contact_name', 'client_contact_number', 'consultant_name', 'start_date', 'end_date', 'actual_project_end_date', 'status', 'total_price_cost', 'advanced_amount', 'retention', 'amount_to_be_received', 'amount_return', 'amount_return_date', 'amount_returns_comment'
    ];
}
