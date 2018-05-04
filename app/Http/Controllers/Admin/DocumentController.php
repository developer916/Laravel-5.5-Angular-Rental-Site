<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\DocumentService;
use App\Models\Document;
use Auth;
use App\Http\Requests;
use App\Http\Requests\Admin\DocumentRequest;
use App\Http\Controllers\Controller;


class DocumentController extends Controller
{


    public function getDocuments(DocumentService $service)
    {
        $documents = $service->getAuthUserDocuments();
        $arrDocs = [];
        foreach ($documents as $document) {
            if ($document->file) {
                $arrDocs[] = [
                    'id' => $document->id,
                    'file' => '<a href="' . $document->file . '">' . $document->file . '</a>',
                    'description' => $document->description,
                    'privacy' => $document->privacy,
                    'status' => $document->status,
                    'date' => $document->created_at->diffForHumans(),
                    'size' => bytesToSize($document->file_size),
                    'actions' => documentActions($document->id)
                ];
            }
        }
        $cnt = count($arrDocs);
        return response()->json([
            'data' => $arrDocs,
            'recordsFiltered' => $cnt,
            'draw' => 2,
            'recordsTotal' => $cnt
        ]);
    }

    public function postCreate(DocumentService $service)
    {
        return response()->json($service->save());
    }

    public function getDocument(DocumentService $service, $id)
    {
        return response()->json($service->view($id));
    }

    public function postUpdate(DocumentService $service)
    {
        return response()->json($service->save());
    }

    public function getDeleteDocument(DocumentService $service, $id)
    {
        return response()->json($service->delete($id));
    }


    public function postUpload(DocumentService $service)
    {
        $result = $service->uploadFile();
        if ($result['status']) {
            return response()->json($result['file'], 200);
        } else {
            return response()->json([], 400);
        }
    }


}
