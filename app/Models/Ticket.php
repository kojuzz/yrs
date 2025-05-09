<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_number',
        'user_id',
        'ticket_pricing_id',
        'type',
        'direction',
        'price',
        'valid_at',
        'expire_at',
    ];
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function ticketPricing() 
    {
        return $this->belongsTo(TicketPricing::class, 'ticket_pricing_id', 'id');
    }
    public function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['type']) {
                    case 'one_time_ticket':
                        $text = 'One Time Ticket';
                        $color = '16a34a';
                        break;
                    case 'one_month_ticket':
                        $text = 'One Month Ticket';
                        $color = 'dc2626';
                        break;
                    default:
                        $text = '';
                        $color = '4b5563';
                        break;
                }
                return [
                    'text' => $text,
                    'color' => $color
                ];
            }
        );
    }
    public function acsrDirection(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['direction']) {
                    case 'clockwise':
                        $text = 'Clockwise';
                        $color = '16a34a';
                        break;
                    case 'anticlockwise':
                        $text = 'AntiClockwise';
                        $color = '2563eb';
                        break;
                    case 'both':
                        $text = 'Both';
                        $color = 'ea580c';
                        break;
                    default:
                        $text = '';
                        $color = '4b5563';
                        break;
                }
                return [
                    'text' => $text,
                    'color' => $color
                ];
            }
        );
    }
}
