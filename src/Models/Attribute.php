<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends AbstractModel
{
    use HasFactory;
    
    protected $guarded = ["id"];

    /**
     * Get the parent attributeable model (user or tenant).
     */

    public function attributeable()
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
}
