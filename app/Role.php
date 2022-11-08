<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'id','name','parent_id'
    ];

    /*
   public function permissions()
   {
      return $this->hasMany(Permission::class, 'group_id', 'id');
   }*/

   public function children()
   {
      return $this->hasMany(Group::class, 'parent_id');
   }

}
