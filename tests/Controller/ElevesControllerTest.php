<?php

namespace App\Tests\Controller;

use App\Entity\Eleves;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ElevesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/eleves/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Eleves::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'elefe[sexe]' => 'Testing',
            'elefe[dateNaissance]' => 'Testing',
            'elefe[numActe]' => 'Testing',
            'elefe[dateActe]' => 'Testing',
            'elefe[dateRecrutement]' => 'Testing',
            'elefe[dateInscription]' => 'Testing',
            'elefe[matricule]' => 'Testing',
            'elefe[isAdmin]' => 'Testing',
            'elefe[isAllowed]' => 'Testing',
            'elefe[isActif]' => 'Testing',
            'elefe[isHandicap]' => 'Testing',
            'elefe[natureHandicape]' => 'Testing',
            'elefe[statutFinance]' => 'Testing',
            'elefe[imageName]' => 'Testing',
            'elefe[imageSize]' => 'Testing',
            'elefe[updatedAt]' => 'Testing',
            'elefe[createdAt]' => 'Testing',
            'elefe[slug]' => 'Testing',
            'elefe[nom]' => 'Testing',
            'elefe[prenom]' => 'Testing',
            'elefe[lieuNaissance]' => 'Testing',
            'elefe[etablissement]' => 'Testing',
            'elefe[ecoleInscription]' => 'Testing',
            'elefe[ecoleAnDernier]' => 'Testing',
            'elefe[classe]' => 'Testing',
            'elefe[parent]' => 'Testing',
            'elefe[user]' => 'Testing',
            'elefe[createdBy]' => 'Testing',
            'elefe[updatedBy]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setSexe('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setNumActe('My Title');
        $fixture->setDateActe('My Title');
        $fixture->setDateRecrutement('My Title');
        $fixture->setDateInscription('My Title');
        $fixture->setMatricule('My Title');
        $fixture->setIsAdmin('My Title');
        $fixture->setIsAllowed('My Title');
        $fixture->setIsActif('My Title');
        $fixture->setIsHandicap('My Title');
        $fixture->setNatureHandicape('My Title');
        $fixture->setStatutFinance('My Title');
        $fixture->setImageName('My Title');
        $fixture->setImageSize('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setSlug('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setLieuNaissance('My Title');
        $fixture->setEtablissement('My Title');
        $fixture->setEcoleInscription('My Title');
        $fixture->setEcoleAnDernier('My Title');
        $fixture->setClasse('My Title');
        $fixture->setParent('My Title');
        $fixture->setUser('My Title');
        $fixture->setCreatedBy('My Title');
        $fixture->setUpdatedBy('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Elefe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setSexe('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setNumActe('Value');
        $fixture->setDateActe('Value');
        $fixture->setDateRecrutement('Value');
        $fixture->setDateInscription('Value');
        $fixture->setMatricule('Value');
        $fixture->setIsAdmin('Value');
        $fixture->setIsAllowed('Value');
        $fixture->setIsActif('Value');
        $fixture->setIsHandicap('Value');
        $fixture->setNatureHandicape('Value');
        $fixture->setStatutFinance('Value');
        $fixture->setImageName('Value');
        $fixture->setImageSize('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setEtablissement('Value');
        $fixture->setEcoleInscription('Value');
        $fixture->setEcoleAnDernier('Value');
        $fixture->setClasse('Value');
        $fixture->setParent('Value');
        $fixture->setUser('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'elefe[sexe]' => 'Something New',
            'elefe[dateNaissance]' => 'Something New',
            'elefe[numActe]' => 'Something New',
            'elefe[dateActe]' => 'Something New',
            'elefe[dateRecrutement]' => 'Something New',
            'elefe[dateInscription]' => 'Something New',
            'elefe[matricule]' => 'Something New',
            'elefe[isAdmin]' => 'Something New',
            'elefe[isAllowed]' => 'Something New',
            'elefe[isActif]' => 'Something New',
            'elefe[isHandicap]' => 'Something New',
            'elefe[natureHandicape]' => 'Something New',
            'elefe[statutFinance]' => 'Something New',
            'elefe[imageName]' => 'Something New',
            'elefe[imageSize]' => 'Something New',
            'elefe[updatedAt]' => 'Something New',
            'elefe[createdAt]' => 'Something New',
            'elefe[slug]' => 'Something New',
            'elefe[nom]' => 'Something New',
            'elefe[prenom]' => 'Something New',
            'elefe[lieuNaissance]' => 'Something New',
            'elefe[etablissement]' => 'Something New',
            'elefe[ecoleInscription]' => 'Something New',
            'elefe[ecoleAnDernier]' => 'Something New',
            'elefe[classe]' => 'Something New',
            'elefe[parent]' => 'Something New',
            'elefe[user]' => 'Something New',
            'elefe[createdBy]' => 'Something New',
            'elefe[updatedBy]' => 'Something New',
        ]);

        self::assertResponseRedirects('/eleves/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getNumActe());
        self::assertSame('Something New', $fixture[0]->getDateActe());
        self::assertSame('Something New', $fixture[0]->getDateRecrutement());
        self::assertSame('Something New', $fixture[0]->getDateInscription());
        self::assertSame('Something New', $fixture[0]->getMatricule());
        self::assertSame('Something New', $fixture[0]->getIsAdmin());
        self::assertSame('Something New', $fixture[0]->getIsAllowed());
        self::assertSame('Something New', $fixture[0]->getIsActif());
        self::assertSame('Something New', $fixture[0]->getIsHandicap());
        self::assertSame('Something New', $fixture[0]->getNatureHandicape());
        self::assertSame('Something New', $fixture[0]->getStatutFinance());
        self::assertSame('Something New', $fixture[0]->getImageName());
        self::assertSame('Something New', $fixture[0]->getImageSize());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getLieuNaissance());
        self::assertSame('Something New', $fixture[0]->getEtablissement());
        self::assertSame('Something New', $fixture[0]->getEcoleInscription());
        self::assertSame('Something New', $fixture[0]->getEcoleAnDernier());
        self::assertSame('Something New', $fixture[0]->getClasse());
        self::assertSame('Something New', $fixture[0]->getParent());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getCreatedBy());
        self::assertSame('Something New', $fixture[0]->getUpdatedBy());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleves();
        $fixture->setSexe('Value');
        $fixture->setDateNaissance('Value');
        $fixture->setNumActe('Value');
        $fixture->setDateActe('Value');
        $fixture->setDateRecrutement('Value');
        $fixture->setDateInscription('Value');
        $fixture->setMatricule('Value');
        $fixture->setIsAdmin('Value');
        $fixture->setIsAllowed('Value');
        $fixture->setIsActif('Value');
        $fixture->setIsHandicap('Value');
        $fixture->setNatureHandicape('Value');
        $fixture->setStatutFinance('Value');
        $fixture->setImageName('Value');
        $fixture->setImageSize('Value');
        $fixture->setUpdatedAt('Value');
        $fixture->setCreatedAt('Value');
        $fixture->setSlug('Value');
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setLieuNaissance('Value');
        $fixture->setEtablissement('Value');
        $fixture->setEcoleInscription('Value');
        $fixture->setEcoleAnDernier('Value');
        $fixture->setClasse('Value');
        $fixture->setParent('Value');
        $fixture->setUser('Value');
        $fixture->setCreatedBy('Value');
        $fixture->setUpdatedBy('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/eleves/');
        self::assertSame(0, $this->repository->count([]));
    }
}
