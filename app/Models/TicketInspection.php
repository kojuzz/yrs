<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketInspection extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'ticket_inspector_id',
        'route_id'
    ];
    
    
}
