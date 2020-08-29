<?php


namespace App\Http\Repository;


class BaseRepository
{

    public function paginationRepository($request,$query)
    {
        $limit    = $request['limit'];
        $offset   = $request['offset'] * $limit;
        $count = $query->count();
        if (isset($limit) ) $query->limit($limit);
        if(isset($offset) && $offset!=null)  $query->offset($offset);
        $data = $query->get();
        return array('count'=>$count,'data'=>$data);
    }
}
