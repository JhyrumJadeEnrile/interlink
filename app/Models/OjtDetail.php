<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OjtDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'required_hours',
        'accumulated_hours',
    ];

    protected $casts = [
        'required_hours' => 'integer',
        'accumulated_hours' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function hoursRemaining(): int
    {
        return max(0, $this->required_hours - $this->accumulated_hours);
    }

    public function progressPercentage(): int
    {
        if ($this->required_hours === 0) {
            return 0;
        }
        return min(100, (int) round($this->accumulated_hours / $this->required_hours * 100));
    }
}
