<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Tag;
use App;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

class TagsController extends Controller
{
    /**
     * Get all the messages related to a specified tag
     * @param $tag mixed the tag
     * @return mixed the messages
     */
    public function getMessagesFromTag($tag)
    {
        if (Auth::check()) {
            $tag = Tag::where('name', '=', $tag)
                ->where('user_id', '=', Auth::user()->id)
                ->firstOrFail();

            App::error(function (ModelNotFoundException $e) {
                return response()->json(['success' => 0]);
            });

            return $tag->messages();
        }
    }

    /**
     * Create a new tag.
     * @param Request $request Request data
     * @return \Illuminate\Http\JsonResponse Success indicator with the new tag (if)
     */
    public function postTag(Request $request) {
        if (Auth::check()) {
            $tag = Tag::where('name', '=', $request->get('name'))->
                        where('user_id', '=', Auth::user()->id)->first();

            // The tag didn't exist yet.
            if ($tag == null) {
                $data = $request->all();
                $data['user_id'] = Auth::user()->id;
                $tag = Tag::create($data);

                return response()->json(['success' => ($tag->id ? 1 : 0), 'tag' => $tag]);
            } else {
                return response()->json(['success' => 0, 'reason' => 'duplicate']);
            }
        }
    }

    /**
     * Updates an existing tag.
     * @param Request $request
     * @return array
     */
    public function patchTag(Request $request) {
        $tag = Tag::where('id', '=', $request->get('id'))->
                    where('user_id', '=', Auth::user()->id)->first();

        if ($tag != null) {
            $tag->fill($request->all());
            $tag->save();
            return response()->json(['success' => 1, 'tag' => $tag]);
        }
        return response()->json(['success' => 0]);
    }

    /**
     * Retrieve all tags.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTags() {
        if (Auth::check())
            return Auth::user()->tags()->with('messages')->get();

        return response()->json(['success' => 0]);
    }

    /**
     * Delete a tag.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $tag = Tag::findOrFail($id);
        if ($tag) {
            $tag->delete();
            return response()->json(['success' => 1]);
        }
        return response()->json(['success' => 0]);
    }
}
