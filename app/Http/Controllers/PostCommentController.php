<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostCommentRepository;
use App\Http\Requests\StorePostComment;

class PostCommentController extends Controller
{
	/**
	 * Instancetiate the controller class and inject the repository class that will be utilized by this controller
	 *
	 * @param $repoitory <Object> App\Repositories\PostCommentRepository
	 */
    public function __construct(PostCommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostComment $request)
    {
    	return $this->repository->create($request->all());
    }

    /**
	 * Retrieve list of comments
	 *
	 * @param  \Illuminate\Http\Request  $request
 	 *
	 * @return \Illuminate\Http\Response
     */
  	public function fetchComments(Request $request)
  	{
  		date_default_timezone_set('Asia/Manila');

  		$offset = $request->input('offset') ?? 0;

  		$model = $this->repository->model;

  		$model = $model->select([
  			'*',
  			\DB::raw('DATE_FORMAT(CONVERT_TZ(created_at, "+00:00", "' . date('P') . '"), "%Y-%m-%d %H:%i:%s") AS created_at')
  		])
  		->where('parent_id', null)
  		->orderBy('created_at', 'DESC')
  		->with(['children' => function ($q) {
  			$q->orderBy('created_at', 'DESC');

			$this->repository->getChildren($q, 2);
  		}]);

  		$comments = $model->offset($offset)->limit(10)->get()->toArray();

  		return [
  			'comments' => $comments,
  			'total_count' => $this->repository->model->count()
  		];
  	}
}
