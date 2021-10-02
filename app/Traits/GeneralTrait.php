<?php 
    
namespace App\Traits;
use Illuminate\Http\Request;
trait GeneralTrait
{
    public function handelResponse($response)
    {
        if (request()->header('Accept') == 'application/json') {
            return response()->json($response);
        } else {
            return $response;
        }
    }
    public function handelSuccessRedirect($response = ["status" => true, "msg" => ["product added successfully"]], $location = null)
    {
        if (request()->header('Accept') == 'application/json') {
            return response()->json($response);
        } else {
            if ($location) {
                return redirect($location)->with("success", $response["msg"]);
            } else {
                return redirect()->back()->with("success", $response["msg"]);
            }
        }
    }
    public function handelErrorRedirect($response = ["status" => false, "msg" => ["something went wrong"]], $location = null)
    {
        if (request()->header('Accept') == 'application/json') {
            return response()->json($response);
        } else {
            
            if ($location) {
                return redirect($location)->with("errors", $response["msg"]);
            } else {
                return redirect()->back()->with("errors", $response["msg"]);
            }
        }
    }

    
}   