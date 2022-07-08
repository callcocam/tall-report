<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report  extends AbstractModel
{
    use HasFactory;
    
    protected $guarded = ["id"];
    
    protected $with = ['attribute', 'columns'];
    
    protected $casts = [
      'foreigns_table' => 'array'
  ];

     /**
     * Get the parent descriptionable model (user or tenant).
     */

    public function columns()
    {
        return $this->hasMany(Column::class)->orderBy('ordering');
    }
  
    public function attribute(){

      return $this->morphOne(Attribute::class, 'attributeable');

    }
  
    public function filters()
    {
        return $this->hasMany(Filter::class);
    }
}
