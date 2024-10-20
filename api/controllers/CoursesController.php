<?php

declare(strict_types=1);

/**
 * Class CoursesController
 *
 * This controller handles the operations related to courses.
 * It provides functionalities to get all or one course information.
 */
class CoursesController
{
    protected PDO $pdo;

    /**
     * CoursesController constructor.
     *
     * @param PDO $pdo The PDO instance for database connection.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retrieves all courses.
     *
     * @return array An array of all courses.
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT
                course_id as id,
                title as name,
                description,
                image_preview as preview,
                categories.name as main_category_name,
                categories.id as main_category_id,
                courses.created_at,
                courses.updated_at
            FROM courses
            INNER JOIN categories ON courses.category_id = categories.id"
        );
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $courses;
    }

    /**
     * Retrieves a course by its ID.
     *
     * @param string $id The ID of the course to retrieve.
     * @return array The course data.
     */
    public function getById(string $id): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT
                course_id as id,
                title as name,
                description,
                image_preview as preview,
                categories.name as main_category_name,
                categories.id as main_category_id,
                courses.created_at,
                courses.updated_at
            FROM courses
            INNER JOIN categories ON courses.category_id = categories.id
            WHERE course_id = :id"
        );
        $stmt->execute(['id' => $id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        return $course ?: [];
    }
}
