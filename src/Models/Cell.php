<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cell extends AbstractModel
{
    use HasFactory;
    
    protected $guarded = ["id"];
    
    protected $with = ['attribute'];

    /**
     * Get the parent cellable model (user or tenant).
     */

    public function cellable()
    {
      return $this->morphTo();
    }

    /**
     * @return string
     */
    protected function slugTo()
    {
      return false;
    }

    public function isUser(){
      return false;
    }

    public function attribute(){
      return $this->morphOne(Attribute::class, 'attributeable');
    }
    
}
