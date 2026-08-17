<?php

namespace App\Enums;

enum Role: string
{
    case Administrateur = 'administrateur';
    case Enseignant = 'enseignant';
    case Eleve = 'eleve';
    case Parent = 'parent';
    case Comptable = 'comptable';

    public function label(): string
    {
        return match ($this) {
            self::Administrateur => 'Administrateur',
            self::Enseignant => 'Enseignant',
            self::Eleve => 'Élève',
            self::Parent => 'Parent',
            self::Comptable => 'Comptable',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Administrateur => 'admin.dashboard',
            self::Enseignant => 'enseignant.dashboard',
            self::Eleve => 'eleve.dashboard',
            self::Parent => 'parent.dashboard',
            self::Comptable => 'comptable.dashboard',
        };
    }
}
