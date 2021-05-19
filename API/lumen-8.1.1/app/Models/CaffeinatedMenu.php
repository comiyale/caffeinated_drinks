<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaffeinatedMenu extends Model {
    protected $table = 'caffeinated_menu';

    protected $fillable = [
        'id',
        'name',
        'description',
        'caffeine_quantity',
        'caffeine_quantity_unit',
        'status',
    ];
}