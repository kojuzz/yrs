<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'trx_id',
        'wallet_id',
        'user_id',
        'sourceable_id',
        'sourceable_type',
        'method',
        'type',
        'amount',
        'description'
    ];
    public function wallet() {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }    
    public function sourceable() {
        return $this->morphTo();
    }
    public function acsrMethod(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['method']) {
                    case 'add':
                        $text = 'Add';
                        $color = '16a34a';
                        break;
                    case 'reduce':
                        $text = 'Reduce';
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
    public function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['type']) {
                    case 'manual':
                        $text = 'Manual';
                        $color = 'ea580c';
                        break;
                    case 'top_up':
                        $text = 'Top Up';
                        $color = '2563eb';
                        break;
                    case 'buy_ticket':
                        $text = 'Buy Ticket';
                        $color = '059669';
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
