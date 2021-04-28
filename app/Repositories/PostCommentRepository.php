<?php

namespace App\Repositories;

use App\Models\PostComment;

class PostCommentRepository
{
	/**
	 * The model that will be managed by this repository
	 *
	 * @var <Object>
	 */
    public $model;

	public function __construct(PostComment $model)
    {
        $this->model = $model;
    }

    /**
	 * Method that will save a new comment to a post
	 *
	 * @param $data <array> - the post information to be saved
	 *
	 * @return <mixed>
     */
    public function create(array $data)
    {
    	\DB::beginTransaction();
        try {
            $model = $this->model;
            $model->content = $data['content'];
            $model->post_id = $data['post_id'];
            $model->parent_id = $data['parent_id'];
            $model->level = $data['level'] ?? 1;
            $model->created_by = 1;
            $model->created_at = \Carbon::now();

            if ($model->save()) {
                \DB::commit();

                return $this->get($model->id);
            }
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return false;
    }

    /**
	 * Retrieve one single instance of a comment
	 *
	 * @param $id <int> - the comment id
	 *
	 * @return <object | null>
     */
    public function get($id)
    {
        return $this->model->find($id);
    }

    /**
	 * Retrieve child comments upto level 3 only. This will recursively call until level 3.
	 * This way it will only execute 3 queries and also structure the data.
	 *
	 * @param $query <ActivQeury> - the active query object
     */
    public function getChildren($query, $counter = 1)
    {
    	$query->with(['children' => function ($q) use ($counter) {
    		$q->orderBy('created_at', 'DESC');
    		
    		if ($counter >= 3) {
    			$this->getChildren($q);
    		}
    	}]);
    }
}