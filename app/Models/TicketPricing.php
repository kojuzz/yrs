<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TicketPricing extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'price',
        'offer_quantity',
        'remain_quantity',
        'started_at',
        'ended_at',
    ];
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
}
