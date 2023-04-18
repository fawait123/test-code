<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Pagination;
use App\Models\User;

class UserController extends Controller
{
    public function list(Request $request)
    {
        try{
            $meta = Pagination::defaultMetaInput($request->only(['page','perPage','order','dir','search']));
            $query = User::query();

            if($meta['search'] != ''){
                $query = $query->where('fullname','like','%'. $meta['search'].'%');
            }


            $total = $query->count();
            $meta = Pagination::additionalMeta($meta, $total);
            if ($meta['perPage'] != '-1') {
                $query->offset($meta['offset'])->limit($meta['perPage']);
            }
            $results = $query->get();
            $data = [
                'results'  => $results,
                'meta'     =>  $meta
            ];
            return response()->json([
                'success'=>true,
                'message'=>'List users',
                'data'=>$data
            ],200);

        }catch(Exception $error){
            return response()->json([
                'success'=>false,
                'message'=>$error->getMessage(),
                'data'=>[]
            ],500);
        }
    }
}
