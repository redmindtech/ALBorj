<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MaterialIssueItem extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [
        "mir_no","item_no","item","store_room","item_quantity"
    ];
    protected $table ='material_issue_return_item';
    protected $primaryKey='mir_item_no';
    protected $fillable =
    [
        'mir_no','item_no','item','store_room','item_quantity'
    ];


    public function materialissue()
    {
        return $this->belongsTo(MaterialIssue::class, 'mir_no','mir_no');
    }
    public function items(){
        return $this->belongsTo(ItemMaster::class, 'item_no', 'mir_no');
    }


}