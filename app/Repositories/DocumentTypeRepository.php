<?php

namespace App\Repositories;

use App\Models\DocumentType;

class DocumentTypeRepository extends Repository
{
    /**
     *  Get all document types
     *
     *  @return array
     */
    public static function all()
    {
        return DocumentType::all();
    }
}
