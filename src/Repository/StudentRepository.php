<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * find one student by name
     * @param $first
     * @param $last
     * @return Student|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneStudentByName($first, $last): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.first = :first')
            ->andWhere('s.last = :last')
            ->setParameter('first', $first)
            ->setParameter('last', $last)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * insert all students
     * @param $students
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insertAllStudents($students)
    {
        foreach ($students as $student) {
            // check if student name has already exist
            if (!$this->findOneStudentByName($student->first, $student->last))
                $this->saveStudent($student);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * save student
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     */
    private function saveStudent($data)
    {
        $student = new Student();
        $student->setEmail($data->email);
        $student->setAddress($data->address);
        $student->setCreated($data->created);
        $student->setFirst($data->first);
        $student->setLast($data->last);

        $this->getEntityManager()->persist($student);
    }
}