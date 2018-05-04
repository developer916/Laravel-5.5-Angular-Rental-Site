<?php

	namespace App\Http\Controllers\Admin;

	use App\Models\Message;
	use App\Models\Property;
	use App\Models\Tag;
	use App\User;
	use Auth;
	use Carbon\Carbon;
	use DB;
	use Illuminate\Http\Request;
	use App\Http\Requests;
	use App\Http\Controllers\Controller;
	use Illuminate\Support\Facades\Input;

	class MessagesController extends Controller {
		// TODO Pass Auth User as a parameter?

		/**
		 * Returns all the messages for the current user.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function getMessages () {
			if (Auth::check()) { // TODO Auth check is not necessary because of Middleware in router?
				$messages = Auth::user()->orderedMessages;
				foreach ($messages as $message) {
					$userProfile = User::find($message->sender_id)->profile;
					if ($userProfile != NULL) {
						$message->sender->profile =
							User::find($message->sender_id)->profile->get(['avatar']);
					}
				}

				return response()->json(['success' => 1, 'messages' => $messages]);
			}

			return response()->json(['success' => 0]);
		}

		/**
		 * Update a given message
		 *
		 * @param Request $request
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function putMessage (Request $request) {
			$message = Auth::user()->messages()->where('id', '=', $request->get('id'))->first();

			if ($request->has('pivot')) {
				$pivot = $request->get('pivot');

				$message->pivot->read    = $pivot['read'];
				$message->pivot->starred = $pivot['starred'];
				if ($message->pivot->read_date == NULL && $pivot['read'] == 1) {
					$message->pivot->read_date = Carbon::now()->toDateTimeString();
				}

				$message->pivot->save();
			}

			return response()->json(['success' => 1, 'pivot' => $message->pivot]);
		}

		/**
		 * Post a new message
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function postSendMessage () {
			if (Auth::check()) {
				$message = Message::create([
					'thread'    => (Input::get('thread') ? Input::get('thread') : $this->generateNewThreadID()),
					'subject'   => Input::get('subject'),
					'text'      => Input::get('text'),
					'sender_id' => Auth::user()->id,
					'priority'  => (Input::get('priority') != NULL ? Input::get('priority') : 0),
					'type'      => (Input::get('type') ? Input::get('type') : 'message')
				]);

				$recipients = ['u' => [], 'p' => []]; // Used to keep track of who has been addressed already.

				// Determine recipients
				foreach (Input::get('recipients') as $recipient) {
					$r = explode('|', $recipient['id']);
					if ($r[0] == 'u') {
						// An individual user was addressed.
						$message->recipients()->attach($r[1]);
						$recipients['u'][] = $r[1];
					} else if ($r[0] == 'p') {
						// A property was addressed.
						$property = Property::find($r[1]);
						if ($property) {
							$tenants  = $property->tenantsAsUsers;
							$landlord = $property->landlord;

							// Address all the tenants
							foreach ($tenants as $tenant) {
								if (!in_array($tenant->id, $recipients['u'])) {
									// This user has not been addressed yet (individually)
									$message->recipients()->attach($tenant->id);
								}
							}

							// Address the landlord
							if (!in_array($landlord->id, $recipients['u'])) {
								$message->recipients()->attach($landlord->id);
							}

							$message->properties()->attach($property->id);
						}
						$recipients['p'][] = $r[1];
					}
				}

				$message->update(['to' => json_encode($recipients)]);

				return response()->json(['success' => 1]);
			}

			return response()->json(['success' => 0]);
		}

		/**
		 * Generate a new Thread ID
		 * @return mixed thread ID
		 */
		private function generateNewThreadID () {
			return DB::table('messages')->max('thread') + 1;
		}

		/**
		 * Get all the details required for composing a reply.
		 *
		 * @param $id int id of the message being replied to.
		 *
		 * @return json response
		 */
		public function getReplyDetails ($id, $type) {
			// current thread, subject, etc.


			$message = Auth::user()->messages()->where('id', '=', $id)->first();

			if (count($message) == 1) {

				if ($type == "user") {
                    $user            = User::findOrFail($message->sender_id);
                    $user->id        = 'u|' . $user->id;
					$user['profile'] = $user->profile;
					return ['success' => 1, 'message' => $message, 'user' => $user];
				} elseif ($type == "reply-all") {
					$to         = json_decode($message->to);
					$recipients = [];

					foreach ($to->u as $uId) {
						$tmp          = User::findOrFail($uId);
						$tmp->id      = 'u|' . $tmp->id;
                        $tmp->tempId      = 'u|' . $tmp->id;
						$recipients[] = $tmp;
					}
					foreach ($to->p as $pId) {
						$tmp          = Property::findOrFail($pId);
						$tmp->id      = 'p|' . $tmp->id;
                        $tmp->tempId      = 'p|' . $tmp->id;
						$recipients[] = $tmp;
					}

					return ['success' => 1, 'message' => $message, 'recipients' => $recipients];
				}
			}

			return response()->json(['success' => 0]);
		}

		/**
		 * Mark a given message as being read.
		 */
		public function postMarkAsRead ($id) {
			$pivot            = Auth::user()->messages()->find($id)->pivot;
			$pivot->read      = 1;
			$pivot->read_date = Carbon::now();
			$pivot->save();

			return response()->json(['success' => Auth::user()->messages()->find($id)->pivot->read, 'rd' => $pivot->read_date, 'carbon' => Carbon::now()]);
		}

		/**
		 * Remove the message with the specified message ID
		 *
		 * @param $id message ID
		 *
		 * @return json success is 1 in case of success
		 */
		public function deleteMessage ($id) {
			$pivot             = Auth::user()->messages->find($id)->pivot;
			$pivot->deleted_at = Carbon::now();
			$pivot->save();

			return response()->json(['success' => ($pivot->deleted_at != NULL)]);
		}

		/**
		 * Used to post tags to messages.
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function postTags () {
			// Find the message
			$message = Message::find(Input::get('message'));

			// If we find the message
			if ($message) {
				// Determine all the tags and create tags if needed
				$tags      = Input::get('tags');
				$syncArray = [];
				foreach ($tags as $tag) {
					// New tags are marked with IDs set to -1.
					if ($tag['id'] == -1) {
						$newTag = Tag::create([
							'name'    => $tag['name'],
							'user_id' => Auth::user()->id
						]);
						$newTag->save();
						$syncArray[] = $newTag->id;
					} else {
						$syncArray[] = $tag['id'];
					}
				}
				// Actually sync the IDs bound to the message
				$message->tags()->sync($syncArray);

				return response()->json(['success' => 1, '$syncArray' => $syncArray]);
			}

			// Message was not found
			return response()->json(['success' => 0]);
		}
	}
