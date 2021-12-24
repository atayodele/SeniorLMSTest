<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'fname', 'lname', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function studentUser(){
        return $this->belongsTo('App\Student');
    }

    public function hasRole($role){
        if($this->roles()->where('name', $role)->first()){
            return true;
        }
        return false;
    }
    
    public function hasAnyRoles($roles){
        if($this->roles()->whereIn('name', $roles)->first()){
            return true;
        }
        return false;
    }

    public static function UserList($roleName){
        $query = User::whereHas('roles', function($q) use ($roleName){
                    $q->where('name', $roleName);
                })->get();
        return $query;
    }

    public static function CheckDuplicateRegNo($reg, $dept)
    {
        $check = DB::table("students")
                        ->where("department_id",$dept)
                        ->where('RegNo', $reg)
                        ->first();
        if($check){
            return true;
        }
        return false;
    }
}
