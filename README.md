#TAL REPORT TABLE

Pacote para gerar elatórios dinamicamente

#INSTALL Starter Kits 

```
./vendor/bin/sail artisan jetstream:install livewire

```

#ALTERAR A TABLE SESSIONS

```
Schema::create('sessions', function (Blueprint $table) {
    ...
   //$table->foreignId('user_id')->nullable()->index();
    $table->foreignUuid('user_id')->nullable()->index();
    ...
});

tambem pode dar alguns comflitos com a tabela de users

Schema::create('users', function (Blueprint $table) {
    //$table->id();
    $table->uuid('id')->primary();//Mudaa para uuid
   ...
});

```

#UPDATE MODEL USER

```
    //ADD
    public $incrementing = false;

    protected $keyType = "string";

    //ALTER COMENTED
        // protected $fillable = [
        //     'name',
        //     'email',
        //     'password',
        // ];

    // ADD
        protected $guarded = ['id'];


        protected static function boot()
        {
            parent::boot();        
            static::creating(function ($model) {
                if (is_null($model->id)):
                    $model->id = \Ramsey\Uuid\Uuid::uuid4();
                endif;
            });
        }


```

#INSTALL MIGRATE

```
./vendor/bin/sail artisan migrate

```

#INSTALL SORTABLE 

```
https://github.com/livewire/sortable

./vendor/bin/sail npm i livewire-sortable --save-dev

```