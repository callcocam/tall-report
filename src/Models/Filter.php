<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filter  extends AbstractModel
{
    use HasFactory;
    
    protected $guarded = ["id"];

    public function report()
    {
        return $this->hasOne(Report::class);
    }
    
}
