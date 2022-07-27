#TAL REPORT TABLE

Pacote para gerar elatórios dinamicamente

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

ALTER app.js
...
import './bootstrap';

import 'livewire-sortable';//add import slivewire-sortable resourses/js/app.js

...    

```
#ALTERANDO O MIX PARA INCLUIR o MIX DO PACOTE


```

mix
.js('resources/js/app.js', 'public/js')
.js('vendor/callcocam/report/resources/js/report.js', 'public/js')
.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
])
.postCss('vendor/callcocam/report/resources/css/report.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
])
    
```


#ALTER PRESSETS 

tailwind.config.js
```
  presets:[
         ...
        require('./vendor/callcocam/report/tailwind.config.js'),
        ...
    ],
  
```


#PUBLICAR AS FACTORIES E SEEDERS

```
./vendor/bin/sail artisan vendor:publish --tag=acl-factories --force
 or 
sail artisan vendor:publish --tag=acl-factories --force

EXAMPLE:

if(class_exists(\Tall\Form\Models\Status::class)){
    \Tall\Form\Models\Status::factory()->create([
        'name'=>'Published'
    ]);
    \Tall\Form\Models\Status::factory()->create([
        'name'=>'Draft'
    ]);
}
if(class_exists(\Tall\Tenant\Models\Tenant::class)){
    $host = \Str::replace("www.",'',request()->getHost());
    \Tall\Tenant\Models\Tenant::factory()->create([
        'name'=> 'Base',
        'domain'=> $host,
        'database'=>env("DB_DATABASE","landlord"),
        'prefix'=>'landlord',
        'middleware'=>'landlord',
        'provider'=>'mysql',
    ]);
}
\App\Models\User::query()->forceDelete();        
\App\Models\User::factory(100)->create();
$user =   \App\Models\User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@example.com',
]);
  
```