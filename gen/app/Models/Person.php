<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    // Les colonnes autorisées pour les insertions/mises à jour
    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];

    /**
     * Relation : Une personne peut avoir plusieurs enfants.
     */
    public function children()
    {
        return $this->hasMany(Person::class, 'parent_id'); // Assurez-vous d'avoir un champ `parent_id` dans votre table
    }

    /**
     * Relation : Une personne peut avoir plusieurs parents.
     */
    public function parents()
    {
        return $this->belongsToMany(Person::class, 'person_parent', 'child_id', 'parent_id'); 
        // Assurez-vous d'avoir une table pivot `person_parent`
    }

    /**
     * Relation : Une personne a un utilisateur créateur.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by'); // Supposant que `created_by` fait référence à la table `users`
    }
    public function relationships()
    {
    return $this->hasMany(Relationship::class, 'person_id');
    }
 
    public function getDegreeWith($target_person_id)
    {
        // Si la personne cible est la même que la personne actuelle
        if ($this->id === $target_person_id) {
            return 0;
        }

        // Initialiser les structures de données pour le BFS
        $visited = [];
        $queue = [
            ['person_id' => $this->id, 'degree' => 0] // Début avec la personne actuelle et un degré de 0
        ];

        // Ajouter les parents et les enfants à la queue
        while (!empty($queue)) {
            $current = array_shift($queue);
            $current_person_id = $current['person_id'];
            $current_degree = $current['degree'];

            // Arrêter si le degré dépasse 25
            if ($current_degree > 25) {
                return false;
            }

            // Marquer cette personne comme visitée
            if (isset($visited[$current_person_id])) {
                continue;
            }

            $visited[$current_person_id] = true;

            // Vérifier si on a atteint la personne cible
            if ($current_person_id == $target_person_id) {
                return $current_degree;
            }

            // Ajouter les parents (si existants) à la queue
            $parents = DB::table('people')->where('id', $current_person_id)->pluck('parent_id')->toArray();
            foreach ($parents as $parent_id) {
                if ($parent_id && !isset($visited[$parent_id])) {
                    $queue[] = ['person_id' => $parent_id, 'degree' => $current_degree + 1];
                }
            }

            // Ajouter les enfants (si existants) à la queue
            $children = DB::table('people')->where('parent_id', $current_person_id)->pluck('id')->toArray();
            foreach ($children as $child_id) {
                if (!isset($visited[$child_id])) {
                    $queue[] = ['person_id' => $child_id, 'degree' => $current_degree + 1];
                }
            }
        }

        return false; // Aucun chemin trouvé ou le degré est trop grand
    }
}
