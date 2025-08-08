<?php

namespace App\Repositories;

use App\Models\Source;

class SourceRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getAllSources()
    {
        // Logic to retrieve all sources
        return Source::all();
    }
    public function getSourceById($id)
    {
        // Logic to retrieve a source by ID
        return Source::findOrFail($id);
    }
    public function createSource($data)
    {
        // Logic to create a new source
        return Source::create($data);
    }
    public function updateSource($id,$data)
    {
        // Logic to update an existing source
        $source = Source::findOrFail($id);
        $source->update($data);
        return $source;
    }
    public function deleteSource($id)
    {
        // Logic to delete a source
        $source = Source::findOrFail($id);
        $source->delete();
        return true;
    }
    public function getSourceByName($name)
    {
        // Logic to retrieve a source by name
        return Source::where('name', $name)->first();
    }
}
