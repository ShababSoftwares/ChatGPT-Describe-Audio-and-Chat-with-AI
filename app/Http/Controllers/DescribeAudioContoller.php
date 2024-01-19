<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Describe_audio;
use App\Models\Uploaded_files;
use Orhanerday\OpenAi\OpenAi;
use Illuminate\Support\Facades\Http;

class DescribeAudioContoller extends Controller
{
    //
    public function uploaded_files(Request $request){
        $uploaded_files = Uploaded_files::orderBy('id','DESC')->get();
        return view('uploaded_files', compact('uploaded_files'));
    }
    
    public function upload_file(Request $request){
        return view('upload_file');
    }
    
    public function post_upload_file(Request $request){
        $request->validate([
            'file' => 'required|mimes:mp3,mp4,mpeg,mpga,m4a,wav,webm|max:2048'
        ]);
        $fileModel = new Uploaded_files();
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('translate', $fileName, 'uploads');
            $fileModel->file_name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = 'uploads/' . $filePath;
            $fileModel->save();
            
            $c_file = curl_file_create($fileModel->file_path);   
            $open_ai_key = getenv('OPENAI_API_KEY');
            $open_ai = new OpenAi($open_ai_key);
            $result = $open_ai->transcribe([
                "model" => "whisper-1",
                "file" => $c_file,
            ]);
            $d = json_decode($result); 
            $fileModel->transcript = $d->text;
            $fileModel->save();
            
            Session::flash('success', 'File has been uploaded successfully!');
            return redirect(route('ask_questions',$fileModel->id));
        }
    }
    
    public function ask_questions(Request $request, $file_id){
        $uploaded_file = Uploaded_files::find($file_id);
        $results = Describe_audio::with('file')->where('file_id',$file_id)->orderBy('id','ASC')->get();
        return view('ask_questions', compact('uploaded_file','results'));
    }
    
    public function post_ask_question(Request $request){
        $user_id = 1;
        $file_id = $request->file_id;
        $uploaded_file = Uploaded_files::find($file_id);
        $history[] = [
//            config('constants.ROLE') => config('constants.SYS'),config('constants.CONTENT') => "You are an AI expert who can describe transcript which is extracted from an audio file, you can answer from this transcript.",
            config('constants.ROLE') => config('constants.SYS'),config('constants.CONTENT') => "You are a proficient AI with a specialty in distilling information into key points. Based on the following text, identify and list the main points that were discussed or brought up. These should be the most important ideas, findings, or topics that are crucial to the essence of the discussion. Your goal is to provide a list that someone could read to quickly understand what was talked about.",
            config('constants.ROLE') => config('constants.USER'),config('constants.CONTENT') => $uploaded_file->transcript
//            config('constants.ROLE') => config('constants.SYS'),config('constants.CONTENT') => "You are a helpful assistant, ",
//            config('constants.ROLE') => config('constants.USER'),config('constants.CONTENT') => "transalte given file into text.",
//            config('constants.ROLE') => config('constants.ASSISTANT'),config('constants.CONTENT') => $uploaded_file->transcript
        ];
        $results = Describe_audio::where('file_id',$file_id)->orderBy('id','ASC')->get();
        
        if($results->isNotEmpty()){
            foreach($results as $row){
                $history[] = [config('constants.ROLE') => config('constants.USER'), config('constants.CONTENT') => $row['user_msg']];
                $history[] = [config('constants.ROLE') => config('constants.ASSISTANT'), config('constants.CONTENT') => $row['ai_msg']];
            }
        }
        
        $message = new Describe_audio();
        $message->user_id = $user_id;
        $message->user_msg = $request->msg;
        $message->file_id = $file_id;
        $message->save();
        
        
        $history[] = [config('constants.ROLE') => config('constants.USER'), config('constants.CONTENT') => $request->msg];
        
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);
        $complete = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => $history,
            'temperature' => 1.0,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);
        $d = json_decode($complete);
        $return_html = '<div class="msg right-msg">
                    <div class="msg-img" style="background-image: url(../images/man.png)"></div>
                    <div class="msg-bubble">
                        <div class="msg-info">
                            <div class="msg-info-name">You</div>
                            <div class="msg-info-time">'.DATE('h:i A').'</div>
                        </div>
                        <div class="msg-text">
                            '.$request->msg.'
                        </div>
                    </div>
                </div>';
        $response_html = '<div class="msg left-msg">
                    <div class="msg-img" style="background-image: url(../images/artificial-intelligence.png)"></div>
                    <div class="msg-bubble">
                        <div class="msg-info">
                            <div class="msg-info-name">BOT</div>
                            <div class="msg-info-time">'.DATE('h:i A').'</div>
                        </div>
                        <div class="msg-text typing hidden">
                            '.$d->choices[0]->message->content.'
                        </div>
                        <div class="msg-text typeit"></div >
                    </div>
                </div>';
        $message->ai_msg = $d->choices[0]->message->content;
        $message->save();
        return response()->json([
            'status' => trans('done'),
            'return_html'=>$return_html,
            'response_html'=>$response_html
        ]);
    }
    
    public function post_delete_questions(Request $request){
        $file_id = $request->file_id;
        Describe_audio::where('file_id',$file_id)->delete();
        return response()->json([
            'status' => trans('done')
        ]);
    }
    
    public function delete_file_chat(Request $request){
        $file_id = $request->file_id;
        $file = Uploaded_files::find($file_id);
        Describe_audio::where('file_id',$file_id)->delete();
        Uploaded_files::where('id',$file_id)->delete();
        @unlink($file->file_path);
        return response()->json([
            'status' => trans('done')
        ]);
    }
    
    public function test_file(Request $request){
//        $this->upload_open_ai_file();
//        $this->list_open_ai_files();
//        $this->create_assistant();
//        $this->list_assistants();
//        $this->assistant_file('asst_zz4KsAo8yVrJVPNJRQAHyM2f', 'file-FLolwDfZvhAx2OKmKe8z4acy');
        
//        $this->delete_assistant('asst_zz4KsAo8yVrJVPNJRQAHyM2f');
//        $this->open_ai_file_content('file-FLolwDfZvhAx2OKmKe8z4acy');
//        $this->delete_open_ai_file('file-FLolwDfZvhAx2OKmKe8z4acy');
//        $this->delete_open_ai_file('file-FLolwDfZvhAx2OKmKe8z4acy');
    }
    
    
    function upload_open_ai_file(){
        $c_file = curl_file_create('uploads/translate/sample.pdf');
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);
        $result = $open_ai->uploadFile([
            "purpose" => "assistants",
            "file" => $c_file,
        ]);
        dd($result);
    }
    function list_open_ai_files(){
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);
        $files = $open_ai->listFiles();
        echo '<pre>';
        print_r($files);
        dd($result);
    }
    function delete_open_ai_file($file_id){
        $open_ai_key = getenv('OPENAI_API_KEY');
        $open_ai = new OpenAi($open_ai_key);
        $result = $open_ai->deleteFile($file_id);
        dd($result);
    }
    function open_ai_file_content($file_id){
        $apiURL = 'https://api.openai.com/v1/files/'.$file_id.'/content';
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
        ];
        $response = Http::withHeaders($headers)->get($apiURL);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    
    
    function create_assistant(){
        // create assistant
        $apiURL = 'https://api.openai.com/v1/assistants';
        $postInput = [
            'name' => 'Data extractor',
            'description' => 'You are a good Translator.',
            'model' => 'gpt-3.5-turbo-1106',
            'tools' => array(array('type'=>'retrieval')),
            'file_ids' => array('file-FLolwDfZvhAx2OKmKe8z4acy'),
        ];
        
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    function list_assistants(){
        $apiURL = 'https://api.openai.com/v1/assistants?order=desc';
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->get($apiURL);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    function assistant_file($assistant_id,$file_id){
        $apiURL = 'https://api.openai.com/v1/assistants/'.$assistant_id.'/files/'.$file_id;
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->get($apiURL);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    function delete_assistant($assistant_id){
        $apiURL = 'https://api.openai.com/v1/assistants/'.$assistant_id;
        $postInput = [
            
        ];
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->delete($apiURL);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    
    function create_thread(){
        // create thread
        $apiURL = 'https://api.openai.com/v1/threads';
        $postInput = [
            
        ];
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    function get_thread(){
        $apiURL = 'https://api.openai.com/v1/threads/{THREAD_ID}';
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->get($apiURL);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    function delete_thread($thread_id){
        $apiURL = 'https://api.openai.com/v1/threads/'.$thread_id;
        $headers = [
            'Authorization' => 'Bearer '.getenv('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
            'OpenAI-Beta' => 'assistants=v1',
        ];
        $response = Http::withHeaders($headers)->delete($apiURL);
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
        echo '<pre>';
        print_r($statusCode);
        dd($responseBody);
    }
    
}
