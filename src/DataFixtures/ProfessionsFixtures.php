<?php

namespace App\DataFixtures;

use App\Entity\Professions;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfessionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $professions = [
            'Médecin', 'Ingénieur', 'Avocat', 'Professeur', 'Architecte', 'Infirmier', 'Psychologue', 
            'Comptable', 'Médecin dentiste', 'Journaliste', 'Cadre', 'Directeur', 'Développeur', 'Webmaster',
            'Traducteur', 'Artiste', 'Chef de projet', 'Ingénieur informatique', 'Analyste', 'Entrepreneur',
            'Designer', 'Écrivain', 'Acteur', 'Chanteur', 'Musicien', 'Photographe', 'Bibliothécaire', 
            'Chef cuisinier', 'Sculpteur', 'Peintre', 'Plombier', 'Électricien', 'Maçon', 'Jardinier', 
            'Vétérinaire', 'Agriculteur', 'Technicien', 'Consultant', 'Chargé de communication', 
            'Responsable marketing', 'Cadre supérieur', 'Secrétaire', 'Assistant administratif', 'Rédacteur', 
            'Analyste financier', 'Chef d’entreprise', 'Auditeur', 'Chargé de recrutement', 'Formateur', 
            'Gestionnaire de paie', 'Directeur commercial', 'Responsable qualité', 'Responsable logistique', 
            'Responsable des ressources humaines', 'Courtier', 'Directeur général', 'Réceptionniste', 
            'Hôtesse de l’air', 'Pilote', 'Agent de sécurité', 'Garde du corps', 'Technicien audiovisuel', 
            'Coach sportif', 'Médecin légiste', 'Chef de cuisine', 'Boulanger', 'Charpentier', 'Coiffeur', 
            'Esthéticienne', 'Conducteur de travaux', 'Serrurier', 'Fleuriste', 'Couturier', 'Peintre en bâtiment', 
            'Menuisier', 'Éboueur', 'Chauffeur', 'Facteur', 'Conseiller financier', 'Géomètre', 'Ophtalmologue', 
            'Dentiste', 'Kinésithérapeute', 'Pharmacien', 'Instructeur de conduite', 'Maître nageur', 
            'Animateur radio', 'Influenceur', 'Détective privé', 'Vendeur', 'Responsable achats', 'Chef d’équipe', 
            'Analyste de données', 'Consultant en stratégie', 'Responsable de la conformité', 'Ingénieur civil', 
            'Consultant en systèmes d’information'
        ];

        foreach ($professions as $index => $profession) {
            $professionEntity = new Professions();
            $professionEntity->setDesignation($profession);
            $manager->persist($professionEntity);
            $this->addReference('profession_' . $index, $professionEntity);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PrenomsFixtures::class,
        ];
    }

}
