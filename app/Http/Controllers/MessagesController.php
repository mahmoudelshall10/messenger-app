<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Recipient;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Participant;
use App\Models\Message;
use App\Events\MessageCreated;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Auth::user();
        $conversation = $user->conversations()
        ->with(['participants' => function($builder) use ($user) {
        $builder->where('id', '<>', $user->id);
        }])
        ->findOrFail($id);

        $messages = $conversation->messages()
            ->with('user')
            ->where(function($query) use ($user) {
                $query
                    ->where(function($query) use ($user) {
                        $query->where('user_id', $user->id)
                            ->whereNull('deleted_at');
                    })
                    ->orWhereRaw('id IN (
                        SELECT message_id FROM recipients
                        WHERE recipients.message_id = messages.id
                        AND recipients.user_id = ?
                        AND recipients.deleted_at IS NULL
                    )', [$user->id]);
            })
            ->latest()
            ->paginate();

        return [
            'conversation' => $conversation,
            'messages' => $messages,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            // 'body' => [Rule::requiredIf(function() use ($request){
            //     return !$request->hasFile('attachment');
            // }),'string'],
            // 'attachment' => ['file'],
            'conversation_id' => [
                Rule::requiredIf(function() use ($request){
                    return !$request->user_id;
                }),
                'integer',
                'exists:conversations,id'
            ],
            'user_id'         => [
                Rule::requiredIf(function() use ($request){
                return !$request->conversation_id;
            })
            ,'integer',
            'exists:users,id'
            ]
        ]);
        $user = Auth::user();

        $conversation_id = $request->conversation_id;
        $user_id = $request->user_id;
        // $user_id = 2;




        DB::beginTransaction();

        try {

            if($conversation_id){
                $conversation = $user->conversations()->findOrFail($conversation_id);
            } else {
                $conversation = Conversation::where('type','=','peer')
                    ->whereHas('participants',function ($q) use ($user_id,$user) {
                    $q->join('participants as participants2','participants2.conversation_id','participants.conversation_id')
                    ->where('participants.user_id','=',$user_id)
                    ->where('participants2.user_id','=',$user->id);
                })->first();



                if (!$conversation) {
                    $conversation = Conversation::create([
                        'user_id' => $user->id,
                        'type' => 'peer',
                    ]);

                    $conversation->participants()->attach([
                        $user->id => ['joined_at'=> now()],
                        $user_id => ['joined_at'=> now()],
                    ]);
                }
            }

            $type = 'text';
            $body =  $request->body;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $body = [
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mimetype' => $file->getMimeType(),
                    'file_path' => $file->store('attachments', [
                        'disk' => 'public'
                    ]),
                ];
                $type = 'attachment';
            }

            $message = $conversation->messages()->create([
                'user_id' => $user->id,
                'type' => $type,
                'body' => $body,
            ]);

            DB::statement('
            INSERT INTO recipients (user_id,message_id)
            SELECT user_id, ? FROM participants
            WHERE conversation_id = ?
            AND user_id <> ?
            ',[$message->id,$conversation->id,$user->id]);

            $conversation->update([
                'last_message_id' => $message->id,
            ]);

            DB::commit();
            $message->load('user');
            broadcast(new MessageCreated($message));
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            throw  $e;
            // something went wrong
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Recipient::where([
            'user_id' => Auth::id(),
            'message_id' => $id
        ])->delete();

        return [
            'message' => 'deleted!'
        ];
    }
}
