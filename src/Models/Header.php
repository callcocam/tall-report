<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Header  extends AbstractModel
{
    use HasFactory;
    
    protected $guarded = ["id"];

    protected $with = ['attribute'];
    
    /**
     * Get the parent headerable model (user or tenant).
     */

    public function headerable()
    {
        return $this->morphTo();
    }

    public function attribute(){

      return $this->morphOne(Attribute::class, 'attributeable');
    }
    
    protected function slugTo()
    {
        return false;
    }
    
    public function isUser()
    {
        return false;
    }
}
