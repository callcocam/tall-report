<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Relationship  extends AbstractModel
{
    use HasFactory;

    protected $guarded = ["id"];

    protected $with = ['header','cell'];


    public function header()
    {
        return $this->morphOne(Header::class, 'headerable');
    }

    public function cell()
    {
        return $this->morphOne(Cell::class,'cellable');
    }

  
}
