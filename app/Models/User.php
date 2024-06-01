<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Dto\DataTables\DataTableQueryResultDto;
use App\Dto\DataTables\DataTableUserFiltersDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function dataTablesGetUsers(DataTableUserFiltersDto $filters): DataTableQueryResultDto
    {
        $query = $this->from('users as u')
            ->select('u.id', DB::raw("CONCAT(u.first_name, ' ', u.name) as name"), 'u.email', 'u.username', 'u.is_activated', DB::raw('COUNT(uc.car_id) as car_count'))
            ->leftJoin('user_car as uc', 'uc.user_id', '=', 'u.id')
            ->when($filters->search, function ($query, $search) {
                return $query->where('name', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($filters->orderColumn, function ($query, $filters) {
                return $query->orderBy($filters->orderColumn, $filters->orderColumnDir);
            });

        $count = (clone $query)->count();
        $result = $query
            ->groupBy('u.id')
            ->skip($filters->start)
            ->take($filters->length)
            ->get()
            ->toArray();

        return DataTableQueryResultDto::create(['count' => $count, 'result' => $result]);
    }
}
