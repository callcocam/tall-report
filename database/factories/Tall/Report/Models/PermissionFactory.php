<?php

namespace Database\Factories\Tall\Report\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Tall\Acl\Models\Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
