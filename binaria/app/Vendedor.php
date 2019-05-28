<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nome', 'esquerdo', 'direito',
  ];
}
