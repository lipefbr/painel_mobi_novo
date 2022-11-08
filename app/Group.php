<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id','name','parent_id'
    ];

    
   public function permissions()
   {
      return $this->hasMany(Permission::class, 'group_id', 'id');
   }

   public function children()
   {
      return $this->hasMany(Group::class, 'parent_id');
   }

}
