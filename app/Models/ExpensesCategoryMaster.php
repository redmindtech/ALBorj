<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ExpensesCategoryMaster extends Model
{
    use HasFactory;
    const REQUEST_INPUTS = [ "category_name","category_description","deleted" ];


    protected $table ='expenses_category_masters';
    protected $primaryKey='id';
    protected $fillable =   [   "category_name","category_description","deleted" ];
    protected static function booted()
    {
        parent::boot();
        static::creating(function ($expense_category) {
            $expense_category->deleted ='0';
        });
    }
}