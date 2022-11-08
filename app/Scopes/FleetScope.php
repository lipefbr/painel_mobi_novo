<?php

namespace App\Scopes;
 
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Auth;
use App\Fleet;
use App\AdminFleet;

class FleetScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if(!App::runninginConsole()){
            
            $user = Auth::user();           

            if($user && $user->getTable() == 'admins' && !$user->isSuperAdmin() && !$user->isAdmin() ) {

                if($model->getTable() == 'providers') {
                    if($user->isParentUser()) {
                       
                        $builder->whereIn($model->getTable() .'.fleet',  AdminFleet::where('admin_id', $user->id)->pluck('fleet_id')); 
                    
                    } else {
                    
                       $builder->whereIn($model->getTable() .'.fleet', Fleet::withoutGlobalScopes()->where('admin_id', $user->id)->pluck('id'));   
                    
                    }
                    
                
                } else if($model->getTable() == 'fleets') {
                     if($user->isParentUser()) {
                       
                       $builder->where($model->getTable() .'.id',  AdminFleet::where('admin_id', $user->id)->pluck('fleet_id')); 
                    
                    } else {

                        $builder->where($model->getTable() .'.admin_id', $user->id);    
                    }

                } else {

                    if($user->isParentUser()) {
                       
                        $builder->whereIn($model->getTable() .'.fleet_id',  AdminFleet::where('admin_id', $user->id)->pluck('fleet_id')); 
                    
                    } else {
                        
                        $builder->whereIn($model->getTable() .'.fleet_id', Fleet::withoutGlobalScopes()->where('admin_id', $user->id)->pluck('id')); 
                    
                    }
                }

            }
            
        }
        
    }
}