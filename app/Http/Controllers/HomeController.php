<?php

namespace App\Http\Controllers;
// use App\Events\UserSignedUp;
// use App\Events\SendMessage;
// use Illuminate\Support\Facades\Redis;
use Auth;
use App\User;
use App\Room;
use App\Message;
use App\Notification;
use DB;
use Illuminate\Http\Request;
use App\Notifications\SendNewMessage;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$rooms = Room::all();
        
        return view('home');
    }

    public function search_room($name)
    {
      $data_search = Room::where('type','general')->where('name','like','%'.$name.'%')->get();
      if ($data_search) {
      return response(['data'=>$data_search]);
        
      }
    }

    public function create_room(Request $request)
    {
           $file =  $request->file('image');
        
        if($request->hasFile('image')){
      $user_id = Auth::user()->id;
      //return $user_id;
      $imageName = $request->image->getClientOriginalName();
      $request->image->storeAs('public/images/rooms',$imageName);
           $room =   Room::create([
        'name'=>request('room_name'),
        'image'=> $imageName,
        'user_id'=>$user_id
      ]);
     
        }

        $room_id = $room->id;
         $user_id = Auth::user()->id;
        DB::table('room_user')->insert(['room_id'=>$room_id,'user_id'=>$user_id]);
        $data = Room::with('users')->find($room_id);

        return response(['data'=> $data]);
    }

    public function get_rooms()
    {
      $user_id = Auth::user()->id;
        $data = DB::table('users')
        ->join('room_user','room_user.user_id','=','users.id')
        ->join('rooms','room_user.room_id','=','rooms.id')
       -> where('users.id','=',$user_id)
       ->select('rooms.id','rooms.name')
        ->get();

     $notifications = Auth::user()->notifications()->get();

      // $notifications = Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        
      //dd($data);

        return response(['data'=> $data, 'notifications'=>$notifications]);
    }

    public function get_roomById($id)
    {
        
      //$data =  Message::where('room_id', $id)->get();

        $data_msg = Room::find($id)->messages()->with('user')->get();
        

        //return $data_msg;
       $room_name = Room::find($id)->name;

        //event(new SendMessage($room_name)); // use event with redis
        $data_room = Room::with('users')->find($id);
      // return $data;

        if (!empty($data_room->users->find(Auth::user()->id))) {
           return response(['data'=>false,'data_msg'=>$data_msg,'data_room'=>$data_room]);
        }else{
            return response(['data'=>true,'data_room'=>$data_room]);
        }

        return response(['data'=> $data,'data_msg'=>null]);
          
    }

    public function join_user()
    {
        
        $room_id = request('room_id');
         $user_id = Auth::user()->id;
        
       

        DB::table('room_user')->insert(['room_id'=>$room_id,'user_id'=>$user_id]);
         $data_room = Room::with('users')->find($room_id);
      $data =    json_encode(['msg'=> Auth::user()->name." joined." , 'image'=>null]);

          $join_message = Message::
                        create(
                            [
                                'message'=> $data,
                                'from'=> $user_id,
                                'to'=> $room_id,
                            ]);
        $data_msg = Room::find($room_id)->messages;
       
        return response(['data'=> $data_msg , 
                        'join_message'=> $join_message,
                        'data_room'=>$data_room,
                      ]);        
    }


    public function send_message(Request $request) {
       $user_id = Auth::user()->id;
        $room_id =request('room_id');
        $message = request('message');
        $data_room_users = Room::find($room_id)->users()->get();
       // return request()->all();
        if($request->hasFile('image')){

      $imageName = $request->image->getClientOriginalName();
      $request->image->storeAs('public/images',$imageName);
       $data =    json_encode(['msg'=>$message , 'image'=>$imageName]);
     
        }else{
      $data =    json_encode(['msg'=>$message , 'image'=>null]);

         
     }
        // // return response(['room_id'=>request('room_id'),'user_id'=>$user_id]);

        $send_message = Message::
                        create([
                                'message'=>$data,
                                'from'=> $user_id,
                                'to'=> $room_id,
                            ]);
                         $from = $send_message->id;

              foreach ($data_room_users as $key => $user_not) {
                $user_not->notify(new SendNewMessage($send_message));
                
              }

       // dd($notifications);
       // dd($users);
      //  dd(User::orderBy('created_at', 'desc'));

                if ($send_message) {
                  $send_message = Message::with('user')->find($from);
                  
                 
                }
               return response()->json(['data'=>$send_message ,'user_info'=>'']);

    }

  


    public function get_user_by_id($id) {
       $user = User::find($id);
       return response(['data'=>$user]);
    }



}
