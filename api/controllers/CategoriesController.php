<?php

declare(strict_types=1);

/**
 * Class CategoriesController
 *
 * This controller handles the operations related to categories.
 * It provides methods to get all or get one category.
 *
 */
class CategoriesController
{
    protected PDO $pdo;

    /**
     * CategoriesController constructor.
     *
     * @param PDO $pdo The PDO instance for database connection.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retrieves all categories.
     *
     * @return array An array of categories.
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare(
            "
            WITH RECURSIVE category_tree AS (
                SELECT id, name, parent, created_at, updated_at, 0 AS Depth
                FROM categories
                WHERE parent IS NULL

                UNION ALL

                SELECT c.id, c.name, c.parent, c.created_at, c.updated_at, ch.depth + 1
                FROM categories c
                INNER JOIN category_tree ch ON c.parent = ch.id
                WHERE ch.depth < 3
            )

            SELECT
                ch.id,
                ch.name,
                ch.parent AS parent_id,
                ch.created_at,
                ch.updated_at,
                COUNT(c.course_id) AS count_of_courses
            FROM category_tree ch
            LEFT JOIN courses c ON c.category_id IN (
                SELECT id
                FROM category_tree
                WHERE id = ch.id OR parent = ch.id OR parent IN (
                    SELECT id FROM category_tree WHERE parent = ch.id OR parent IN (
                        SELECT id FROM category_tree WHERE parent = ch.id
                    )
                )
            )
            GROUP BY ch.id, ch.name, parent_id, ch.created_at, ch.updated_at;
            "
        );

        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    /**
     * Retrieve a category by its ID.
     *
     * @param string $id The ID of the category to retrieve.
     * @return array The category data.
     */
    public function getById(string $id): array
    {
        $stmt = $this->pdo->prepare("
           WITH RECURSIVE category_tree AS (
                SELECT id, name, parent, created_at, updated_at, 0 AS Depth
                FROM categories
                WHERE id = :id

                UNION ALL

                SELECT c.id, c.name, c.parent, c.created_at, c.updated_at, ch.depth + 1
                FROM categories c
                INNER JOIN category_tree ch ON c.parent = ch.id
                WHERE ch.depth < 3
            )

            SELECT
                ch.id,
                ch.name,
                ch.parent AS parent_id,
                ch.created_at,
                ch.updated_at,
                COUNT(c.course_id) AS count_of_courses
            FROM category_tree ch
            LEFT JOIN courses c ON c.category_id IN (
                SELECT id
                FROM category_tree
            )
            GROUP BY ch.id, ch.name, parent_id, ch.created_at, ch.updated_at;
            ");
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category;
    }
}
