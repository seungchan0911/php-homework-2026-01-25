<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = ['store_id','user_id', 'book_id', 'due_date', 'is_returned'];

    public function getDueDateAttribute() {
        return $this->created_at->addDays(7);
    }
    
    public function getStatusTextAttribute() {
        if (!$this->is_returned) {
            $days = number_format(now()->diffInDays($this->due_date, false), 0);
            
            if ($days > 0) {
                return "{$days}일 남음";
            } elseif ($days === 0) {
                return "오늘 반납";
            } else {
                return "연체 " . abs($days) . "일";
            }
        }
        
        return "-";
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
