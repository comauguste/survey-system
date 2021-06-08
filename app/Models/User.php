<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getInitials()
    {
        $words = explode(" ", $this->name);
        $acronym = "";

        foreach ($words as $w) {
            $acronym .= $w[0];
        }

        return $acronym;
    }

    public function getAccountType()
    {
        if ($this->account_type == 1) {
            $accountType = "Administrator";
        } elseif ($this->account_type == 2) {
            $accountType = "Surveyor";
        } else {
            $accountType = "Surveyee";
        }
        return $accountType;
    }

    public function getAccountTypeBadge()
    {
        if ($this->account_type == 1) {
            $badge = "badge badge-primary-info fw-boldest px-4 py-3";
        } elseif ($this->account_type == 2) {
            $badge = "badge badge-light-info fw-boldest px-4 py-3";
        } else {
            $badge = "badge badge-light-warning fw-boldest px-4 py-3";
        }
        return $badge;
    }

    public function getEmailVerificationStatus()
    {
        if ($this->email_verified_at != null) {
            $badge = "Verified";
        } else {
            $badge = "Unverified";
        }
        return $badge;
    }

    public function getEmailVerificationStatusBadge()
    {
        if ($this->email_verified_at != null) {
            $badge = "symbol-label bg-light-success text-success fw-bold";
        } else {
            $badge = "badge badge-light-danger fw-boldest px-4 py-3";
        }
        return $badge;
    }
}
