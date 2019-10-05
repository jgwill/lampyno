<?php

namespace WeDevs\PM\Task_List\Transformers;

use WeDevs\PM\Task_List\Models\Task_List;
use League\Fractal\TransformerAbstract;
use WeDevs\PM\User\Transformers\User_Transformer;
use WeDevs\PM\Task\Transformers\Task_Transformer;
use WeDevs\PM\Comment\Transformers\Comment_Transformer;
use WeDevs\PM\File\Transformers\File_Transformer;
use WeDevs\PM\Milestone\Transformers\Milestone_Transformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use WeDevs\PM\Common\Traits\Resource_Editors;
use WeDevs\PM\Task\Models\Task;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Pagination\Paginator;
use League\Fractal\Resource\Collection as Collection;


class Task_List_Transformer extends TransformerAbstract {

    use Resource_Editors;

    protected $defaultIncludes = [
        'creator', 'updater', 'milestone'
    ];

    protected $availableIncludes = [
        'assignees',
        'tasks',
        'complete_tasks',
        'incomplete_tasks',
        'comments',
        'files',
    ];

    public function transform( Task_List $item ) { 
        $data = [
            'id'          => (int) $item->id,
            'title'       => $item->title,
            'description' => pm_filter_content_url( $item->description ),
            'order'       => (int) $item->order,
            'status'      => $item->status,
            'created_at'  => format_date( $item->created_at ),
            'meta'        => $this->meta( $item ),
            'extra'       => true,
            'project_id' => $item->project_id

        ];

        return apply_filters( 'pm_task_list_transform', $data, $item );
    }

        /**
     * Getter for defaultIncludes.
     *
     * @return array
     */
    public function getDefaultIncludes()
    {
        return apply_filters( "pm_task_list_transformer_default_includes", $this->defaultIncludes );
    }

    public function meta( Task_List $item ) {
        $meta = $item->metas()->get()->toArray();
        $meta = wp_list_pluck( $meta, 'meta_value', 'meta_key' );

        return array_merge( $meta, [
            'total_tasks'            => $item->tasks( $item->project_id )->count(),
            'total_complete_tasks'   => $item->tasks( $item->project_id )->where( 'status', Task::COMPLETE )->count(),
            'total_incomplete_tasks' => $item->tasks( $item->project_id )->where( 'status', Task::INCOMPLETE )->count(),
            'total_comments'         => $item->comments()->count(),
            'totla_files'            => $item->files()->count(),
            'total_assignees'        => $item->assignees()->count(),
        ] );
    }

    public function includeAssignees( Task_List $item ) {
        $assignees = $item->assignees;

        return $this->collection( $assignees, new User_Transformer );
    }

    public function includeComments( Task_List $item ) {
        $page = isset( $_GET['comment_page'] ) ? intval($_GET['comment_page']) : 1;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        }); 

        $comments = $item->comments()
            ->orderBy( 'created_at', 'ASC' )
            ->paginate( pm_config('app.comment_per_page') );

        $comment_collection = $comments->getCollection();
        $resource = $this->collection( $comment_collection, new Comment_Transformer );

        $resource->setPaginator( new IlluminatePaginatorAdapter( $comments ) );

        return $resource;
    }

    public function includeFiles( Task_List $item ) {
        $page = isset( $_GET['file_page'] ) ? intval($_GET['file_page']) : 1;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        }); 

        $files = $item->files()->paginate( 10 );

        $file_collection = $files->getCollection();
        $resource = $this->collection( $file_collection, new File_Transformer );

        $resource->setPaginator( new IlluminatePaginatorAdapter( $files ) );

        return $resource;
    }

    public function includeMilestone( Task_List $item ) {
        $milestone = $item->milestones->first();

        if ( $milestone ) {
            return $this->item( $milestone, new Milestone_Transformer );
        }

        return null;
    }

    public function includeTasks( Task_List $item ) {
        $tasks = $item->tasks;
        return $this->collection( $tasks, new Task_Transformer );
    }


    public function includeCompleteTasks( Task_List $item ) {
        $page = isset( $_GET['complete_task_page'] ) ? intval($_GET['complete_task_page']) : 1;
        $per_page_count = isset( $_GET['complete_task_per_page'] ) ? intval($_GET['complete_task_per_page']) : false;

        $per_page = pm_get_setting( 'complete_tasks_per_page' );
        $per_page = $per_page ? $per_page : 5;

        if ( intval( $per_page_count ) ) {
            $per_page = $per_page_count;
        } 

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        }); 

        $tasks = $item->tasks()
                ->where( 'status', 1 );

        $tasks = apply_filters( 'pm_complete_task_query', $tasks,  $item->project_id, $item );
        if ( $per_page == '-1' ) {
            $per_page = $tasks->count();
        }
        $tasks =  $tasks->orderBy( pm_tb_prefix() . 'pm_boardables.order', 'ASC' )
            ->paginate( $per_page );

        return $this->make_paginated_tasks( $tasks );
    }

    public function includeIncompleteTasks( Task_List $item ) {
        $page = isset( $_GET['incomplete_task_page'] ) ? intval( $_GET['incomplete_task_page'] ) : 1;
        $per_page_count = isset( $_GET['incomplete_task_per_page'] ) ? intval($_GET['incomplete_task_per_page']) : false;

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        }); 

        $per_page = pm_get_setting( 'incomplete_tasks_per_page' );
        $per_page = $per_page ? $per_page : 5;
        
        if ( intval( $per_page_count ) ) {
            $per_page = $per_page_count;
        } 
        
        $tasks = $item->tasks()
            ->where( 'status', 0 );
        $tasks = apply_filters( 'pm_incomplete_task_query', $tasks,  $item->project_id, $item );
        
        if ( $per_page == '-1' ) {
            $per_page = $tasks->count();
        }
        
        $tasks = $tasks->orderBy( pm_tb_prefix() . 'pm_boardables.order', 'ASC' )
            ->paginate( $per_page );
        return $this->make_paginated_tasks( $tasks );
    }

    private function make_paginated_tasks( $tasks ) {
        $task_collection = $tasks->getCollection();
        $resource = $this->collection( $task_collection, new Task_Transformer );

        $resource->setPaginator( new IlluminatePaginatorAdapter( $tasks ) );

        return $resource;
    }
}
