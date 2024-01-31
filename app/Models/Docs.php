<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Orbit\Concerns\Orbital;

class Docs extends Model
{
    use Orbital;

    /**
     * The guarded attributes.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The model schema.
     *
     * @return void
     */
    public static function schema(Blueprint $table)
    {
        $table->string('slug');
        $table->string('title');
        $table->string('description')->nullable();
        $table->string('group')->nullable();
        $table->integer('priority')->default(1);
        $table->longText('content');
    }

    /**
     * Get the key name for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'slug';
    }

    /**
     * Get the increment value for the model.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
