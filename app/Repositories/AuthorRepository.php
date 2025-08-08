<?php

namespace App\Repositories;

use App\Models\Authors;

class AuthorRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}
    public function getAllAuthors()
    {
        // Logic to retrieve all authors
        return Authors::all();
    }
    public function getAuthorById($id)
    {
        // Logic to retrieve an author by ID
        return Authors::findOrFail($id);
    }
    public function createAuthor(array $data)
    {
        // Logic to create a new author
        return Authors::create($data);
    }
    public function updateAuthor($id, array $data)
    {
        // Logic to update an existing author
        $author = Authors::findOrFail($id);
        $author->update($data);
        return $author;
    }
    public function deleteAuthor($id)
    {
        // Logic to delete an author
        $author = Authors::findOrFail($id);
        $author->delete();
        return true;
    }
    public function searchByParams($params)
    {
        // Logic to search authors by parameters
        $query = Authors::query();
        foreach ($params as $key => $value) {
            if (in_array($key, ['name', 'email'])) {
                $query->where($key, 'like', '%' . $value . '%');
            }
        }
        return $query->get();
    }
    public function getAuthorByName($name)
    {
        // Logic to retrieve an author by name
        return Authors::where('name', $name)->first();
    }
}
