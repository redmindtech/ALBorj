<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMasterItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "id",
        "proj_no",
        "item_no",
        "specification",
        'qty',
        "unit",
        "rate_per_qty",
        "amount",
        "deleted",
        "pending_qty"
       
];
protected $table = 'project_master_item';
protected $primaryKey = 'id';
protected $fillable =
    [
        "id",
        "proj_no",
        "item_no",
        "specification",
        'qty',
        "unit",
        "rate_per_qty",
        "amount",
        "deleted",
        "pending_qty"
      ];
      protected static function booted()
      {
          parent::boot();
          static::creating(function ($project) {
              $project->deleted = '0';
          });
      }


}
