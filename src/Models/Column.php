<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/

namespace Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Column extends AbstractModel
{

    use HasFactory;
    
    protected $guarded = ["id"];
    
    protected $with = ['header','cell','relationships'];
    
    public function report()
    {
        return $this->hasOne(Report::class);
    }
    
    public function relationships()
    {
        return $this->hasMany(Relationship::class)->orderBy('ordering');
    }

    public function header()
    {
        return $this->morphOne(Header::class, 'headerable');
    }

    public function cell()
    {
        return $this->morphOne(Cell::class,'cellable');
    }
    
}
