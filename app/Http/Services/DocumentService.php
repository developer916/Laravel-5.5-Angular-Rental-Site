<?php
/**
 * Created by PhpStorm.
 * User: cos
 * Date: 03/12/15
 * Time: 13:57
 */

namespace App\Http\Services;


use App\Models\Document;
use App\Models\DocumentShares;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DocumentService
{
    protected $request;
    protected $userService;

    public function __construct(\Illuminate\Http\Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    /**
     * @return array
     */
    public function save()
    {
        if (!$this->request->get('id')) {
            $document = new Document();
            $document->file = '';
            $document->privacy = 'Private';
            $document->folder_id = 1;
            $document->user_id = Auth::user()->id;
            $status = $document->save();
        } else {
            $document = Document::where('id', $this->request->get('id'))->first();
            if ($document) {
                $files = $this->request->get('files', null);
                $document->user_id = Auth::user()->id;
                $document->description = $this->request->get('description');
                $document->privacy = $this->request->get('privacy');
                if (!$document->property_id) {
                    $document->property_id = $this->request->get('property_id', null);
                }
                //
                $document->status = 1;
                if ($files && is_array($files)) {
                    $document->file = $files[0]['file'];
                    $document->file_size = $files[0]['file_size'];
                }
                $status = $document->save();
                if ($status) {
                    //get the list of all the user we shared
                    $sharedUserIds = DocumentShares::where('document_id', $document->id)->pluck('user_id')->toArray();
                    //read the list of user we shared from request, otherwise all users children get to have access
                    $shares = $this->request->get('shares');
                    if ($document->privacy == 'Public') {
                        $shares = Tenant::where('parent_id', \Auth::user()->id)->get([
                            'users.id',
                            'users.name',
                        ]);
                    }
                    //this users are already in share, no need to insert
                    $touches = [];
                    $insert = [];
                    if ($shares) {
                        $now = Carbon::now('utc')->toDateTimeString();
                        foreach ($shares as $share) {
                            if (!in_array($share['id'], $sharedUserIds)) {
                                $insert[] = [
                                    'document_id' => $document->id,
                                    'user_id' => $share['id'],
                                    'created_at' => $now,
                                    'updated_at' => $now
                                ];
                                //notyfy insert
                            } else {
                                $touches[] = $share['id'];
                            }
                        }
                    }
                    $deletes = [];
                    //if theere are users shares that are not new and are not in touches then relation should be deleted
                    foreach ($sharedUserIds as $shareUid) {
                        if (!in_array($shareUid, $touches)) {
                            $deletes[] = $shareUid;
                            //notify deleted
                        } else {
                            //notify updated
                        }
                    }
                    //deletes
                    if (count($deletes)) {
                        DocumentShares::where('document_id', $document->id)->whereIn('user_id', $deletes)->delete();
                    }
                    //inserts
                    if (count($insert)) {
                        \DB::table('document_shares')->insert($insert);
                    }
                }
            }
        }

        return [
            'status' => $status,
            'data' => [
                'id' => $document->id,
            ]
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $document = Document::where('id', $id)->first();
        if ($document) {
            $remove = $document->delete();
            if ($remove) {
                //Document relationship with user should be deleted also
                DocumentShares::where('document_id', $document->id)->delete();
                return [
                    'status' => 1
                ];
            }
        }
        return [
            'status' => 0
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function view($id)
    {
        $document = Document::where('id', $id)->with('shares.user')->first();
        if ($document) {
            $viewDocument = [
                'id' => $document->id,
                'file' => $document->file,
                'file_size' => $document->file_size,
                'privacy' => $document->privacy,
                'description' => $document->description,
                'created_at' => $document->created_at->toDateTimeString(),
                'updated_at' => $document->updated_at->toDateTimeString(),
            ];
            $shares = [];
            //if document is not public then we get the list of user we shared
            if ($document->privacy != 'Public' && $document->shares) {
                foreach ($document->shares as $share) {
                    $shares[] = [
                        'id' => $share['user']['id'],
                        'name' => $share['user']['name']
                    ];
                }
            }
            $viewDocument['shares'] = $shares;
            $document = $viewDocument;
        }
        return [
            'status' => ($document) ? 1 : 0,
            'data' => $document
        ];
    }

    public function getAuthUserDocuments($params = [])
    {
        $documents = Document::where('status', '>', 0)->with('shares.user')->where('user_id', Auth::user()->id);
        if (isset($params['property_id'])) {
            $documents->where('property_id', (int)$params['property_id']);
        }
        return $documents->get();
    }

    public function getSharedUserDocuments($userId)
    {
        return Document::where('status', '>', 0)->with(['shares.user' => function ($query) use ($userId) {
            $query->where('shares.user_id', $userId);
        }])->get();
    }

    /**
     * @return array
     */
    public function uploadFile()
    {
        $document = Document::find($this->request->get('id'));
        if ($document) {
            $filename = $this->request->file('file')->getClientOriginalName();
            $property = (int)$this->request->get('property_id');
            if ($property) {
                $relativePath = $this->userService->getRelativePath() . '/properties/' . $property . '/docs/';
            } else {
                $relativePath = $this->userService->getRelativePath() . '/docs/';
            }
            $directory = public_path() . $relativePath;
            $fileSize = $this->request->file('file')->getSize();
            $upload_success = $this->request->file('file')->move($directory, $filename);
            if ($upload_success) {
                $file = [
                    'file' => $relativePath . $filename,
                    'id' => $document->id,
                    'file_size' => $fileSize,
                ];
                return [
                    'status' => 1,
                    'file' => $file
                ];
            }
        }
        return [
            'status' => 0,
            'file' => null
        ];
    }

}