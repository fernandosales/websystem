<?php


namespace AccountancyBundle\Manager;

use AccountancyBundle\Entity\Book;
use AccountancyBundle\Entity\Record;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class BookManager
{
    /** @var ManagerRegistry */
    private $doctrine;


    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return ManagerRegistry
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return $this->doctrine->getManagerForClass(Book::class);
    }

    public function addNewRecord(Book $book, Record $record)
    {
        $book->addRecord($record);
        $this->getEntityManager()->persist($book);
        try {
            $this->getEntityManager()->flush();
            return true;
        } catch (OptimisticLockException $e) {
            return false;
        } catch (ORMException $e) {
            return false;
        }
    }

}