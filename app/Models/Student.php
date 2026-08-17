<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

        protected $fillable = [
                'nom', 'prenom', 'email', 'classe',
                        'date_naissance', 'tuteur_nom', 'tuteur_contact', 'user_id',
                            ];

                                protected $casts = [
                                        'date_naissance' => 'date',
                                            ];

                                                public function user()
                                                    {
                                                            return $this->belongsTo(User::class);
                                                                }
                                                                }